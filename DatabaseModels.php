<?php
/**
 * Created by PhpStorm.
 * User: samuele
 * Date: 16/03/16
 * Time: 19.10
 */

require __DIR__.'/vendor/autoload.php';

\ORM::configure('mysql:host=localhost;dbname=estatiamo');
\ORM::configure('username', 'root');
\ORM::configure('password', 'MRsams1995');
\ORM::configure('return_result_sets', true);

class Controller{
    
    public $model;
    
    public function __construct(){
        $this->model = \Model::factory(str_replace('Controller', 'Model', get_class($this)));
    }

    public function find_one($id=null, $resolved=false){
        if(false === $resolved)
            return $this->model->find_one($id);
        return $this->model->find_one($id)->as_array();
    }

    public function find_many($resolved){
        if(false === $resolved)
            return $this->model->find_many();
        return $this->model->find_array();
    }
    
    public static function factory($className){
        $name = $className.'Controller';
        if(class_exists($name))
            return new $name;
        throw new Exception('class: '.$className.' not exists');
    }

}

class StructureController extends Controller{



}

class StructureModel extends \Model{

    const TYPE_BEACH = 0;
    const TYPE_POOL = 1;

    public static $_table = 'structure';

    public static function type($orm, $type){
        if('beaches' === $type)
            return $orm->where('type', self::TYPE_BEACH);
        elseif('pools' === $type)
            return $orm->where('type', self::TYPE_POOL);
        else
            throw new InvalidArgumentException("type must be 'beaches' or 'pools'.");
    }

}

