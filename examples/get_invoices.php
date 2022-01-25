<?php
require '../vendor/autoload.php';

$apiKey = 'API_KEY_HERE';
$seeuletter = new \Seeuletter\Seeuletter($apiKey);

$invoices_list = $seeuletter->invoices()->all(array(
  'status'               => "paid",
  'date_start'           => "2020-01-01",
));

echo '[List] The Seeuletter API Invoices responded : ';
print_r($invoices_list);

if (count($invoices_list['invoices']) > 0) {
    $single_invoice = $seeuletter->invoices()->get($invoices_list['invoices'][0]['_id']);

    echo '[Single] The Seeuletter API Invoice responded : ';
    print_r($single_invoice);
}
?>
