<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/',function ($request, $response) {
    $response->getBody()->write("Hello world!");
    return $response;
});
