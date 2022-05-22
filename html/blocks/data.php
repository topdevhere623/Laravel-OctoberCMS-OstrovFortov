<?php
include __DIR__.'/../../api/tickets/Api.php';
$api = Api::getInstance();
//$piers = $api->getPiersTo();

$time = strtotime('+1 day');
$date = date('Y-m-d', $time);
$calendarDate = date('d.m.Y', $time);
//$piersBack = $api->getPiersBack();
$programs = $api->getPrograms();
$cruisesTo = $api->getCruisesTo($date);
$cruisesBack = $api->getCruisesBack($date);