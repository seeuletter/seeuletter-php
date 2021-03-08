<?php
require '../vendor/autoload.php';

$apiKey = 'test_1d09eb54-c7a6-4f89-abd2-2e4106c5b115';
$seeuletter = new \Seeuletter\Seeuletter($apiKey);

$to_address_electronic = array(
  'first_name'            => 'Erlich',
  'last_name'             => 'Dumas',
  'company'               => 'Seeuletter',
  'email'                 => 'seeuletter@example.com'
);

$letter = $seeuletter->letters()->createElectronic(array(
  'to'                  => $to_address_electronic,
  'source_file'         => '<html>This is the electronic letter attached document</html>',
  'source_file_type'    => 'html',
  'description'         => 'Test Electronic Letters',
  'content'             => 'Please review the attached documents',
  'postage_type'        => 'lre'
));

print_r($letter);

?>
