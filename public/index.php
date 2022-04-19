<?php

declare(strict_types=1);
session_start();

use App\Controllers\HomeController;
use Slim\Http\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/');
$dotenv->load();

$app = AppFactory::create();

$con = $app->getContainer();
$container['HomeController'] = function() {
    return new HomeController();
};

$app->get('/', function (Request $request,Response $response, $args) {
    $renderer = new PhpRenderer(__DIR__.'/../resources/view');
    return $renderer->render($response, "page.html");
});

$app->post('/search/full', HomeController::class.':getFormByPersonsId');
$app->post('/search', HomeController::class.':searchPerson');

$app->get('/person/{id:\d+}', HomeController::class.':displayPerson');
$app->post('/person', HomeController::class.':getPersonsData');

$app->post('/insert', HomeController::class.':saveFirstPart');
$app->post('/insertTwo', HomeController::class.':saveSecondPart');

$app->post('/delete/last', HomeController::class.':deleteCurrentForm');
$app->post('/simple/delete', HomeController::class.':simpleDelete');
$app->post('/full/delete', HomeController::class.':fullDelete');

$app->run();
