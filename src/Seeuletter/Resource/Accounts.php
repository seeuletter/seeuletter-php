<?php

/*
 * This file is part of the Seeuletter.com PHP Client.
 *
 * (c) 2017 Seeuletter.com, https://www.seeuletter.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Seeuletter\Resource;

use Seeuletter\Resource as ResourceBase;
use Seeuletter\Exception\NetworkErrorException;

class Accounts extends ResourceBase
{
    public function updateEmail($id, $email)
    {
        return $this->sendRequest(
            'PUT',
            $this->seeuletter->getVersion(),
            $this->seeuletter->getClientVersion(),
            $this->resourceName().'/'.strval($id),
            array(),
            [ 'email' => $email ]
        );
    }

    public function all(array $query = array(), $includeMeta = false)
    {
       throw new NetworkErrorException("Invalid REST operation : GET /accounts");
    }

    public function get($id)
    {
       throw new NetworkErrorException("Invalid REST operation : GET /accounts/:account_id");
    }

    public function delete($id)
    {
       throw new NetworkErrorException("Invalid REST operation : DELETE /accounts/:account_id");
    }
}
