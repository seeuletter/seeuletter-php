<?php

/*
 * This file is part of the Seeuletter.com PHP Client.
 *
 * (c) 2017 Seeuletter.com, https://www.seeuletter.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Seeuletter;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ConnectException;
use Seeuletter\Exception\AuthorizationException;
use Seeuletter\Exception\InternalErrorException;
use Seeuletter\Exception\NetworkErrorException;
use Seeuletter\Exception\ResourceNotFoundException;
use Seeuletter\Exception\UnexpectedErrorException;
use Seeuletter\Exception\ValidationException;
use Seeuletter\Exception\RateLimitException;

abstract class Resource implements ResourceInterface
{
    protected $seeuletter;

    protected $client;

    public function __construct(Seeuletter $seeuletter)
    {
        $this->seeuletter = $seeuletter;
        $this->client = new Client(array('base_uri' => 'https://api.seeuletter.com/'));
    }

    public function all(array $query = array(), $includeMeta = false)
    {
        $all = $this->sendRequest(
            'GET',
            $this->seeuletter->getVersion(),
            $this->seeuletter->getClientVersion(),
            $this->resourceName(),
            $query
        );
        if ($includeMeta) {
            return $all;
        }

        return $all;
    }

    public function create(array $data)
    {
        return $this->sendRequest(
            'POST',
            $this->seeuletter->getVersion(),
            $this->seeuletter->getClientVersion(),
            $this->resourceName(),
            array(),
            $data
        );
    }

    public function get($id)
    {
        return $this->sendRequest(
            'GET',
            $this->seeuletter->getVersion(),
            $this->seeuletter->getClientVersion(),
            $this->resourceName().'/'.strval($id)
        );
    }

    public function delete($id)
    {
        return $this->sendRequest(
            'DELETE',
            $this->seeuletter->getVersion(),
            $this->seeuletter->getClientVersion(),
            $this->resourceName().'/'.strval($id)
        );
    }

    protected function resourceName()
    {
        $class = explode('\\', strtolower(get_called_class()));

        return array_pop($class);
    }

    protected function sendRequest($method, $version, $clientVersion, $path, array $query = array(), array $body = null)
    {
        $path = $this->getPath($path, $query);
        $options = $this->getOptions($version, $clientVersion, $body);

        try {
            $response = $this->client->request($method, $path, $options);
            //@codeCoverageIgnoreStart
            // There is no way to induce this error intentionally.
        } catch (ConnectException $e) {
            throw new NetworkErrorException($e->getMessage());
            //@codeCoverageIgnoreEnd
        } catch (GuzzleException $e) {
            $responseErrorBody = strval($e->getResponse()->getBody());
            $errorMessage = $this->errorMessageFromJsonBody($responseErrorBody);
            $statusCode = $e->getResponse()->getStatusCode();

            if ($statusCode === 401)
                throw new AuthorizationException('Unauthorized', 401);

            if ($statusCode === 403)
                throw new AuthorizationException($errorMessage, 403);

            if ($method == 'GET' && ($statusCode === 404 || $statusCode === 422))
                throw new ResourceNotFoundException($errorMessage, 404);

            if ($method == 'POST' && $statusCode === 404)
                throw new ResourceNotFoundException($errorMessage, 404);

            if ($statusCode === 422)
                throw new ValidationException($errorMessage, 422);

            // @codeCoverageIgnoreStart
            // must induce serverside error to test this, so not testable
            if ($statusCode === 429)
                throw new RateLimitException($errorMessage, 429);
            // @codeCoverageIgnoreEnd

            // @codeCoverageIgnoreStart
            // must induce serverside error to test this, so not testable
            if ($statusCode >= 500)
                throw new InternalErrorException($errorMessage, $statusCode);
            // @codeCoverageIgnoreEnd

            // @codeCoverageIgnoreStart
            // not possible to test this code because we don't return other status codes
            throw new UnexpectedErrorException('An Unexpected Error has occurred: ' . $e->getMessage());
        } catch (Exception $e) {
            throw new UnexpectedErrorException('An Unexpected Error has occurred: ' . $e->getMessage());
        }
            // @codeCoverageIgnoreEnd

        return json_decode($response->getBody(), true);
    }

    protected function getPath($path, array $query = array())
    {
        $path = $path;
        $queryString = '';
        if (!empty($query)) {
            $queryString = '?'.http_build_query($query);
        }
        return $path.$queryString;
    }

    protected function getOptions($version, $clientVersion, array $body = null)
    {
        $options = array(
            'headers' => array(
                'Accept' => 'application/json; charset=utf-8',
                'User-Agent' => 'Seeuletter/v1 PhpBindings/' . $clientVersion,
            ),
            'auth' => array($this->seeuletter->getApiKey(), '')
        );

        if ($version) {
            $options['headers']['Seeuletter-Version'] = $version;
        }

        if (!$body) {
            return $options;
        }

        $body = $this->stringifyBooleans($body);
        $files = array_filter($body, function ($element) {
            return (is_string($element) && strpos($element, '@') === 0);
        });

        if(!$files) {
            $options['form_params'] = $body;
            return $options;
        }

        $body = $this->flattenArray($body);
        $options['multipart'] = array();
        foreach($body as $key => $value) {
            $element = array(
                'name' => $key,
                'contents' => $value
            );

            if ((is_string($value) && strpos($value, '@') === 0)) {
                $element['contents'] = fopen(substr($value, 1), 'r');
            }

            $options['multipart'][] = $element;
        }

        return $options;
    }

    /*
     * Because guzzle uses http_build_query it will turn all booleans into '' and '1' for
     * false and true respectively. This function will turn all booleans into the string
     * literal 'false' and 'true'
     */
    protected function stringifyBooleans($body)
    {
        return array_map(function($value) {
            if (is_bool($value)) {
                return $value ? 'true' : 'false';
            } else if (is_array($value)) {
                return $this->stringifyBooleans($value);
            }
            return $value;
        }, $body);
    }

    /*
     * This method is needed because multipart guzzle requests cannot have nested data
     * This function will take:
     * array(
     *     'foo' => array(
     *         'bar' => 'baz'
     *     )
     * )
     * And convert it to:
     * array(
     *     'foo[bar]' => 'baz'
     * )
     */
    protected function flattenArray(array $body, $prefix = '')
    {
        $newBody = array();
        foreach ($body as $k => $v) {
            $key = (!strlen($prefix)) ? $k : "{$prefix}[{$k}]";
            if (is_array($v)) {
                $newBody += $this->flattenArray($v, $key);
            } else {
                $newBody[$key] = $v;
            }
        }
        return $newBody;
    }

    protected function errorMessageFromJsonBody($body)
    {
        $response = json_decode($body, true);
        if (is_array($response) && array_key_exists('error', $response)) {
            $error = $response['error'];

            return $error['message'];
        }

        return 'An Internal Error has occurred';

    }
}
