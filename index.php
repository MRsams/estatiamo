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
                $response->getBody()->write(json_encode(Controller::factory('Structure')->find_many(true)));
            });

        $this->group("/beaches",
            function(){
                $this->get("",
                    function(RequestInterface $request, ResponseInterface $response){
                        $model = \Model::factory('StructureModel');
                        $response->getBody()->write(json_encode($model->filter('type','beaches')->find_array()));
                    });
            });

        $this->group("/pools",
            function(){
                $this->get("",
                    function(RequestInterface $request, ResponseInterface $response){
                        $model = \Model::factory('Structure');
                        $response->getBody()->write(json_encode($model->filter('type','pools')->find_array()));
                    });
            });
    });

$app->run();