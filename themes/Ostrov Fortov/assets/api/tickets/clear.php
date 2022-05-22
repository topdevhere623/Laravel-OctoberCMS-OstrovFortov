<?php
if (PHP_SAPI !== 'cli')die();
include_once 'Api.php';
$api = Api::getInstance();
$api->clearCache();