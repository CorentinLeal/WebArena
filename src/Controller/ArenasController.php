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
use Cake\Core\Configure;

class ArenasController extends AppController
{

    public function index()
    {
        $this->set('myname', "Corentin Leal");

        $this->loadModel('Fighters');

        $var = $this->Fighters->getBestFighter();
        $this->set('test', $var);
    }

    public function login()
    {

    }

    public function fighter()
    {

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
                } else {
                    $this->Flash->success(__("Le combattant n'a pas pu être enregistré!"));
                }


                //selectionner un combattant pour en afficher ses caractéristiques
            } else if (array_key_exists('choix', $this->request->data)) {
                $name = $this->request->data('choix');

                $fighter = $this->Fighters->getFighterByUserAndName($this->Auth->user('id'), $name);

                $this->set('fighter', $fighter);

                if ($fighter) {
                    $this->Flash->success(__("Combattant selectionné !"));
                    $this->set('fighter', $fighter);
                }

                //détermination de la possibilité de passer un niveau
                if ($this->Fighters->canLevelUp($fighter)) {
                    $this->set('canLevelUp', true);
                    $this->set('fighter', $fighter);
                } else
                    $this->set('canLevelUp', false);
                $this->set('fighter', $fighter);
            }

            //Passage de niveau du Fighter séléctionné
            // augmentation du skill health
            else if (array_key_exists('FighterLevelUpHealth', $this->request->data)) {
                //Récupération du Fighter à partir de son nom et de son Player
                $fighter = $this->Fighters->getFighterByUserAndName($this->Auth->user('id'), $this->request->data['FighterLevelUpHealth']);

                // Méthode de passage de niveau avec le skill renseigné
                $fighter = $this->Fighters->levelUp($fighter, 'health');

                //Détermination de la possibilité de passer un niveau
                if ($this->Fighters->canLevelUp($fighter)) {
                    $this->set('canLevelUp', true);
                    $this->set('fighter', $fighter);
                } else
                    $this->set('canLevelUp', false);

                //augmentation du skill vision
            } else if (array_key_exists('FighterLevelUpSight', $this->request->data)) {
                //Récupération du Fighter à partir de son nom et de son User
                $fighter = $this->Fighters->getFighterByUserAndName($this->Auth->user('id'), $this->request->data['FighterLevelUpSight']);

                // Méthode de passage de niveau avec le skill renseigné
                $fighter = $this->Fighters->levelUp($fighter, 'sight');
                $this->set('raw', $fighter);

                //Détermination de la possibilité de passer un niveau
                if ($this->Fighters->canLevelUp($fighter)) {
                    $this->set('canLevelUp', true);
                    $this->set('fighter', $fighter);
                } else
                    $this->set('canLevelUp', false);

                //augmentation du skill force
            } else if (array_key_exists('FighterLevelUpStrength', $this->request->data)) {
                //Récupération du Fighter à partir de son nom et de son User
                $fighter = $this->Fighters->getFighterByUserAndName($this->Auth->user('id'), $this->request->data['FighterLevelUpStrength']);

                // Méthode de passage de niveau avec le skill renseigné
                $fighter = $this->Fighters->levelUp($fighter, 'strength');
                $this->set('raw', $fighter);

                //Détermination de la possibilité de passer un niveau
                if ($this->Fighters->canLevelUp($fighter)) {
                    $this->set('canLevelUp', true);
                    $this->set('fighter', $fighter);
                } else
                    $this->set('canLevelUp', false);
            }
        }
    }

    public function sight()
    {
        $this->set('width', Configure::read('MAPWIDTH'));
        $this->set('height', Configure::read('MAPHEIGHT'));

        $this->loadModel('Fighters');

        //pr($this->request);
        if ($this->request->is('post')) {

            if (array_key_exists('ChooseFighter', $this->request->data) && $this->request->data['ChooseFighter']!=null){
                $fighter = $this->Fighters->getFighterByUserAndName($this->Auth->user('id'), $this->request->data('ChooseFighter'));
                $this->set('currentFighter', $fighter);
            }
        }
    }

    public function diary()
    {

    }

}
