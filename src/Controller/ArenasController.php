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

class ArenasController extends AppController {

    public function index() {
        $this->set('myname', "Corentin Leal");

        $this->loadModel('Fighters');

        $var = $this->Fighters->getBestFighter();
        $this->set('test', $var);
    }

    public function login() {
        
    }

    public function fighter() {

        $this->set('fighter', null);

        $this->loadModel('Fighters');

        if ($this->request->is('post')) {

                //Creer un nouveau combattant
            if (array_key_exists('nom', $this->request->data)) {
                $name = $this->request->data('nom');
                $fighter = $this->Fighters->createFighter($this->Auth->user('id'), $name);

                if ($this->Fighters->save($fighter)) {
                    $this->Flash->success(__("Combattant enregistré !"));
                    $this->set('fighter', $fighter);
                }

                if ($fighter) {
                    $this->Flash->success(__("Combattant selectionné !"));
                }
                
                //selectionner un combattant pour en afficher ses caractéristiques
            } else if (array_key_exists('choix', $this->request->data)) {
                $name = $this->request->data('choix');
                          
                $fighter = $this->Fighter->getFighterByName($name);             
                
                if ($fighter) {
                    $this->Flash->success(__("Combattant selectionné !"));
                    $this->set('fighter', $fighter);
                }
            }
            
            //delete un combattant
            } else if (array_key_exists('Suprimer', $this->request->data)) {
                $this->Fighter->kill($fighter);
                if (!$fighter) {
                    $this->Flash->success(__("Combattant supprimé !"));
                    $this->set('fighter', null);
                }
                
        }
    }

    public function sight() {
        
    }

    public function diary() {
        
    }

}
