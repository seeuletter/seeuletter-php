<?php
require '../vendor/autoload.php';

$seeuletter = new \Seeuletter\Seeuletter('test_1d09eb54-c7a6-4f89-abd2-2e4106c5b115');


$to_address = array(
  'name'                  => 'Seeuletter',
  'address_line1'         => '30 rue de rivoli',
  'address_line2'         => '',
  'address_city'          => 'Paris',
  'address_country'       => 'France',
  'address_postalcode'    => '75004'
);

$letter = $seeuletter->letters()->create(array(
  'to'                  => $to_address,
  'source_file'         => '@../../test.pdf',
  'description'         => 'Test Letters',
  'color'               => 'bw',
  'source_file_type'    => 'file',
  'postage_type'        => 'verte'
));

print_r($letter);

?>
