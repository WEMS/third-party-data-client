<?php

require 'vendor/autoload.php';

$wemsClient = new \Wems\Api\ThirdPartyData\Client('http://example.org/third-party-data');

// authenticate using one of the following methods
$wemsClient->setBasicAuth('username', 'password');
//$wemsClient->setApiKey('api key');

$wemsClient->setObject('3270b178c2a9ffeda0da260abe81085255ad40f9');

$wemsClient->addData(strtotime('2014-01-01 00:00:00'), 42);
$wemsClient->addData(strtotime('2014-01-01 00:30:00'), 21);
$wemsClient->addData(strtotime('2014-01-01 01:00:00'), 57);

// if we're in test mode -
// $wemsClient->setDryRun(true);

$res = $wemsClient->send();

print_r($res->getStatusCode());
print_r($res->getResponseBody());
