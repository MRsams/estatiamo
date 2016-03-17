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

class Structure extends \Model{

    const TYPE_BEACH = 0;
    const TYPE_POOL = 1;

    public static function type($orm, $type){
        if('beaches' === $type)
            return $orm->where('type', self::TYPE_BEACH);
        elseif('pools' === $type)
            return $orm->where('type', self::TYPE_POOL);
        else
            throw new InvalidArgumentException("type must be 'beaches' or 'pools'.");
    }

}