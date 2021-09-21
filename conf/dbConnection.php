<?php

$capsule = new Illuminate\Database\Capsule\Manager();
$settings = require  __DIR__ . '/settings.php';
$capsule->addConnection($settings['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();
