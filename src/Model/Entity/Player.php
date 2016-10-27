<?php
/**
 * Created by PhpStorm.
 * User: corentin
 * Date: 27/10/16
 * Time: 23:47
 */

namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

class Player extends Entity
{

    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }

}