<?php

use Silex\Application;
use Symfony\Component\Dotenv\Dotenv;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\VarDumperServiceProvider;
use JG\Silex\Provider\CapsuleServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Symfony\Component\Dotenv\Exception\PathException;

$app = new Application();
$app['debug'] = true;

$dotenv = new Dotenv();
try {
    $dotenv->load(__DIR__ . '/.env');
} catch (PathException $exception) {
    copy(__DIR__ . '/.env.example', __DIR__ . '/.env');
    echo 'Generated a new .env file. Please reload.';
}

$app->register(new VarDumperServiceProvider());
$app->register(new SessionServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(
    new CapsuleServiceProvider(),
    [
        'capsule.connections' => [
            'default' => [
                'driver'   => getenv('DB_DRIVER'),
                'host'     => getenv('DB_HOST'),
                'database' => getenv('DB_DATABASE'),
                'username' => getenv('DB_USERNAME'),
                'password' => getenv('DB_PASSWORD'),
            ],
        ],
    ]
);

$app['twig.path'] = [__DIR__ . '/views'];
$app['twig.options'] = [
    'cache' => __DIR__ . '/var/twigcache',
];

return $app;
