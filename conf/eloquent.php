<?php

use Slim\App;

return static function (App $app) {
    $capsule = new Illuminate\Database\Capsule\Manager();
    $settings = $app->getContainer()->get('settings');
    $capsule->addConnection($settings['db']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
};
