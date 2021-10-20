<?php

use App\Utils\Auth;
use DI\Container;
use Slim\App;
use Slim\Csrf\Guard;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Twig\TwigFunction;

return static function (App $app) {
    /** @var Container $container */
    $container = $app->getContainer();

    // Create Twig
    $twig = Twig::create('../src/View', ['cache' => false, 'debug' => true]);

    // Add Twig-View Middleware
    $app->add(TwigMiddleware::create($app, $twig));

    // Add Twig session variable
    $environment = $twig->getEnvironment();
    $environment->addGlobal('auth', (object)[
        'isLoggedIn' => Auth::isLoggedIn(),
        'user' => Auth::getUser()
    ]);

    // Add CSRF function to generate fields
    $environment->addFunction(new TwigFunction('csrf_token', function () use ($container) {
        /* @var Guard $csrf */
        $csrf = $container->get('csrf');
        $csrfNameKey = $csrf->getTokenNameKey();
        $csrfValueKey = $csrf->getTokenValueKey();
        $csrfName = $csrf->getTokenName();
        $csrfValue = $csrf->getTokenValue();

        return <<<HTML
            <input type="hidden" name="$csrfNameKey" value="$csrfName">
            <input type="hidden" name="$csrfValueKey" value="$csrfValue">
        HTML;
    }, ['is_safe' => ['html']]));

    // Add twig to container
    $container->set('twig', $twig);
};