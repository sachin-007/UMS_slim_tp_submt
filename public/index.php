







<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;


require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/db.php';


$app = AppFactory::create();
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Define app routes
$app->get('/hello/{name}', function (Request $request, Response $response, $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});

$app->get('/',function(Request $request,Response $response){
    $response->getBody()->write("working");
    return $response;
});


// $app->get('/posts',function(Request $request,Response $response){
//     $response->getBody()->write("hello world");
//     return $response;
// });



// friends routes
require __DIR__.'/../routes/friends.php';
require __DIR__.'/../routes/posts.php';
require __DIR__.'/../routes/saposts.php';

$app->run();