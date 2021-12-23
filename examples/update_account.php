<?php
require '../vendor/autoload.php';

$apiKey = 'API_KEY_HERE';
$seeuletter = new \Seeuletter\Seeuletter($apiKey);

$account_response = $seeuletter->accounts()->updateEmail("COMPANY_ID_HERE", "msb.partner.new@example.com");

print_r('The Seeuletter API Account responded with success');

?>
