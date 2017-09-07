<?php

/*
 * This file is part of the Lifebot.fr PHP Client.
 *
 * (c) 2017 Lifebot.fr, https://www.lifebot.fr
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lifebot;

use InvalidArgumentException;
use BadMethodCallException;
use Lifebot\Resource;
use Lifebot\Resource\Letters;

class Lifebot
{
    private $version;
    private $apiKey;
    private $clientVersion;

    public function __construct($apiKey = null, $version = null)
    {
        if (!is_null($apiKey)) {
            $this->setApiKey($apiKey);
        }
        $this->version = $version;
        $this->clientVersion = '1.0.0';
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function setApiKey($apiKey)
    {
        if (!is_string($apiKey) || empty($apiKey)) {
            throw new InvalidArgumentException('API Key must be a non-empty string.');
        }
        $this->apiKey = $apiKey;

        return $this;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getClientVersion()
    {
      return $this->clientVersion;
    }

    public function letters()
    {
        return new Letters($this);
    }
}
