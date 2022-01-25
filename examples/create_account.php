<?php
require '../vendor/autoload.php';

$apiKey = 'API_KEY_HERE';
$seeuletter = new \Seeuletter\Seeuletter($apiKey);

$account_response = $seeuletter->accounts()->create(array(
  'email'               => "msb.partner@example.com",
  'name'                => "Erlich Bachman",
  'phone'               => "+33104050607",
  'company_name'        => "MSB Partner from PHP Wrapper",
  'address_line1'       => '30 rue de rivoli',
  'address_line2'       => '',
  'address_city'        => 'Paris',
  'address_country'     => 'France',
  'address_postalcode'  => '75004'
));

print_r($account_response);

?>
