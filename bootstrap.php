<?php

declare(strict_types=1);


require_once __DIR__ . '/vendor/autoload.php';


use Core\App;
use Core\Database;

set_exception_handler([Core\ErrorHandler::class, 'handleException']);
set_error_handler([Core\ErrorHandler::class, 'handleError']);
$config = require __DIR__ . '/config.php';


App::bind('config', $config);
App::bind('database', new Database($config['database']));
