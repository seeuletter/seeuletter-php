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

interface ResourceInterface
{
    public function all(array $options = array(), $includeMeta = false);
    public function create(array $data);
    public function get($id);
    public function delete($id);
}
