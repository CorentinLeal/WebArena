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


        $fighter = null;

        if ($this->request->is('post')) {
        
            //Creer un nouveau combattant
            if (array_key_exists('nom', $this->request->data) && $this->request->data['nom']!=null) {
                $name = $this->request->data('nom');
                $fighter = $this->Fighters->createFighter($this->Auth->user('id'), $name);

                if ($fighter==null) {
                    $this->Flash->success(__("Le combattant n'a pas pu être enregistré! (Vous possedez peut etre déjà un fighter avec ce nom)   "));
                } else if ($this->Fighters->save($fighter)){
                    $this->Flash->success(__("Combattant enregistré !"));
                    $this->set('fighter', $fighter);
                    
                }
                
                $this->set('canLevelUp', false);

                //selectionner un combattant pour en afficher ses caractéristiques
            } else if (array_key_exists('choix', $this->request->data)&& $this->request->data['choix']!=null) {
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
            else if (array_key_exists('LevelUpHealth', $this->request->data)&& $this->request->data['LevelUpHealth']!=null) {
                //Récupération du Fighter à partir de son nom et de son Player
                $name = $this->request->data['LevelUpHealth'];
                
                $currentfighter = $this->Fighters->getFighterByUserAndName($this->Auth->user('id'), $name);
                
                // Méthode de passage de niveau avec le skill renseigné
                $fighter = $this->Fighters->levelUp($currentfighter, 'health');

                //Détermination de la possibilité de passer un niveau
                if ($this->Fighters->canLevelUp($fighter)) {
                    $this->set('canLevelUp', true);
                    $this->set('fighter', $fighter);
                } else
                    $this->set('canLevelUp', false);

                if ($this->Fighters->save($fighter)) {
                    $this->Flash->success(__("Combattant enregistré !"));
                    $this->set('fighter', $fighter);
                }

                
                //augmentation du skill vision
            } else if (array_key_exists('LevelUpSight', $this->request->data) && $this->request->data['LevelUpSight']!=null) {
                //Récupération du Fighter à partir de son nom et de son Player
                $name = $this->request->data('LevelUpSight');
                $fighter = $this->Fighters->getFighterByUserAndName($this->Auth->user('id'), $name);

                // Méthode de passage de niveau avec le skill renseigné
                $currentfighter = $this->Fighters->levelUp($fighter, 'sight');
                $this->set('fighter', $fighter);

                //Détermination de la possibilité de passer un niveau
                if ($this->Fighters->canLevelUp($currentfighter)) {
                    $this->set('canLevelUp', true);
                    $this->set('fighter', $fighter);
                } else
                    $this->set('canLevelUp', false);

                if ($this->Fighters->save($fighter)) {
                    $this->Flash->success(__("Combattant enregistré !"));
                    $this->set('fighter', $fighter);
                }

                //augmentation du skill force
            } else if (array_key_exists('LevelUpStrength', $this->request->data) && $this->request->data['LevelUpStrength']!=null) {
                //Récupération du Fighter à partir de son nom et de son Player
                $name = $this->request->data('LevelUpStrength');
                $fighter = $this->Fighters->getFighterByUserAndName($this->Auth->user('id'), $name);

                // Méthode de passage de niveau avec le skill renseigné
                $fighter = $this->Fighters->levelUp($fighter, 'strength');
                $this->set('fighter', $fighter);

                //Détermination de la possibilité de passer un niveau
                if ($this->Fighters->canLevelUp($fighter)) {
                    $this->set('canLevelUp', true);
                    $this->set('fighter', $fighter);
                } else
                    $this->set('canLevelUp', false);
                if ($this->Fighters->save($fighter)) {
                    $this->Flash->success(__("Combattant enregistré !"));
                    $this->set('fighter', $fighter);
                }
            }
        }
    }

    public function sight()
    {
        $this->set('width', Configure::read('MAPWIDTH'));
        $this->set('height', Configure::read('MAPHEIGHT'));

        $this->set('currentFighter', null);

        $this->loadModel('Fighters');

        //pr($this->request);
        if ($this->request->is('post')) {

            if (array_key_exists('ChooseFighter', $this->request->data) && $this->request->data['ChooseFighter']!=null){
                $fighter = $this->Fighters->getFighterByUserAndName($this->Auth->user('id'), $this->request->data('ChooseFighter'));
                $this->set('currentFighter', $fighter);

            }else if (array_key_exists('MoveLeft', $this->request->data) && $this->request->data['MoveLeft']!=null){
                $fighter = $this->Fighters->getFighterByUserAndName($this->Auth->user('id'), $this->request->data('MoveLeft'));
                $this->set('currentFighter', $fighter);

                $this->Fighters->seDeplace($fighter, "ouest");

            }else if (array_key_exists('MoveRight', $this->request->data) && $this->request->data['MoveRight']!=null){
                $fighter = $this->Fighters->getFighterByUserAndName($this->Auth->user('id'), $this->request->data('MoveRight'));
                $this->set('currentFighter', $fighter);

                $this->Fighters->seDeplace($fighter, "est");

            }else if (array_key_exists('MoveUp', $this->request->data) && $this->request->data['MoveUp']!=null){
                $fighter = $this->Fighters->getFighterByUserAndName($this->Auth->user('id'), $this->request->data('MoveUp'));
                $this->set('currentFighter', $fighter);

                $this->Fighters->seDeplace($fighter, "nord");

            }else if (array_key_exists('MoveDown', $this->request->data) && $this->request->data['MoveDown']!=null){
                $fighter = $this->Fighters->getFighterByUserAndName($this->Auth->user('id'), $this->request->data('MoveDown'));
                $this->set('currentFighter', $fighter);

                $this->Fighters->seDeplace($fighter, "sud");

            }else if (array_key_exists('AttackLeft', $this->request->data) && $this->request->data['AttackLeft']!=null){
                $fighter = $this->Fighters->getFighterByUserAndName($this->Auth->user('id'), $this->request->data('AttackLeft'));
                $this->set('currentFighter', $fighter);

                $this->Fighters->attaque($fighter, "ouest");

            }else if (array_key_exists('AttackRight', $this->request->data) && $this->request->data['AttackRight']!=null){
                $fighter = $this->Fighters->getFighterByUserAndName($this->Auth->user('id'), $this->request->data('AttackRight'));
                $this->set('currentFighter', $fighter);

                $this->Fighters->attaque($fighter, "est");

            }else if (array_key_exists('AttackUp', $this->request->data) && $this->request->data['AttackUp']!=null){
                $fighter = $this->Fighters->getFighterByUserAndName($this->Auth->user('id'), $this->request->data('AttackUp'));
                $this->set('currentFighter', $fighter);

                $this->Fighters->attaque($fighter, "nord");

            }else if (array_key_exists('AttackDown', $this->request->data) && $this->request->data['AttackDown']!=null){
                $fighter = $this->Fighters->getFighterByUserAndName($this->Auth->user('id'), $this->request->data('AttackDown'));
                $this->set('currentFighter', $fighter);

                $this->Fighters->attaque($fighter, "sud");
            }
        }
    }

    public function diary()
    {

    }

}
