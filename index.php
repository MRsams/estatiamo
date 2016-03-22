<?php
/**
 * Created by PhpStorm.
 * User: samuele
 * Date: 16/03/16
 * Time: 17.25
 */

require __DIR__ . "/vendor/autoload.php";
require 'DatabaseModels.php';

use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\ResponseInterface;

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$c = new \Slim\Container($configuration);
$app = new \Slim\App($c);

$app->group("/structure",
    function(){
        $this->get("",
            function(RequestInterface $request, ResponseInterface $response){
                $response->getBody()->write(json_encode(Controller::factory('Structure')->find_many()));
            });

        $this->get("/beaches",
            function(RequestInterface $request, ResponseInterface $response){
                $beaches = Controller::factory('Structure')->getBeaches();
                $response->getBody()->write(json_encode($beaches));
            });

        $this->get("/pools",
            function(RequestInterface $request, ResponseInterface $response){
                $pools = Controller::factory('Structure')->getPools();
                $response->getBody()->write(json_encode($pools));
            });

        $this->get("/{id:[0-9]+}",
            function(RequestInterface $request, ResponseInterface $response, array $args){
                $structure = Controller::factory('Structure');
                $response->getBody()->write(json_encode($structure->getById($args['id'])));
            });
    });

$app->run();