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

class Invoices extends ResourceBase
{
    public function create(array $data)
    {
       throw new NetworkErrorException("Invalid REST operation : POST /invoices/:invoice_id");
    }

    public function delete($id)
    {
       throw new NetworkErrorException("Invalid REST operation : DELETE /invoices/:invoice_id");
    }
}
