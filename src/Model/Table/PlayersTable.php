<?php
/**
 * Created by PhpStorm.
 * User: corentin
 * Date: 27/10/16
 * Time: 22:11
 */

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PlayersTable extends Table
{

    public function validationDefault(Validator $validator)
    {
        return $validator
            ->notEmpty('email', "An email address is needed")
            ->notEmpty('password', "A password is needed");
    }



}