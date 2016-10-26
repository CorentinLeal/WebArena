<?php
/**
 * Created by PhpStorm.
 * User: corentin
 * Date: 25/10/16
 * Time: 23:07
 */

namespace App\Model\Table;

use Cake\ORM\Table;

class FightersTable extends Table
{
    function getBestFighter(){
        $test=$this->find('all')->order('level')->limit(1);
        return $test->toArray();
    }
}