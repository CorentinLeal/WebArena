<?php
/**
 * Created by PhpStorm.
 * User: corentin
 * Date: 13/10/16
 * Time: 23:36
 */

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Table\FightersTable;

class ArenasController extends AppController
{

    public function index()
    {
        $this->set('myname', "Corentin Leal");

        $this->loadModel('Fighters');
        $var=$this->Fighters->getBestFighter();
        $this->set('test', $var);
    }

    public function login()
    {

    }

    public function fighter()
    {

    }

    public function sight()
    {

    }

    public function diary()
    {

    }
}