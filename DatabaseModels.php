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

    public function find_one($id=null, $resolved=true){
        if(true === $resolved)
            return $this->model->find_one($id)->as_array();
        return $this->model->find_one($id);
    }

    public function find_many($resolved=true){
        if(true === $resolved)
            return$this->model->find_array();
        return $this->model->find_many();
    }
    
    public static function factory($className){
        $name = $className.'Controller';
        if(class_exists($name))
            return new $name;
        throw new Exception('class: '.$className.' not exists');
    }

}

class Structure_price extends \Model{
    public static $_table = 'structure_prices';
}

class Umbrella extends \Model{}

class StructureController extends Controller{

    public function getBeaches($resolved=true){
        $beaches = $this->model->filter('type', 'beaches');
        if(true === $resolved)
            return $beaches->find_array();
        return $beaches->find_many();
    }

    public function getPools($resolved=true){
        $pools = $this->model->filter('type', 'pools');
        if(true === $resolved)
            return $pools->find_array();
        return $pools->find_many();
    }

    public function getById($id){
        $structure = $this->find_one($id, false);
        $prices = $structure->has_one('structure_price')->find_one();

        return $structure->as_array() + [
            'prices' => $prices->as_array(),
        ];
    }

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

    public function price(){
        return $this->has_one('structure_price');
    }

}

