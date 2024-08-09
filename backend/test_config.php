<?php

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/testing.php';
dump(config('database.connections.pgsql'));
