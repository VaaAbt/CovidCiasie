<?php

use Slim\App;

return function (App $app) {
    $capsule = new Illuminate\Database\Capsule\Manager();
    $settings = $app->getContainer()->get('settings');
    $capsule->addConnection($settings['db']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
};
