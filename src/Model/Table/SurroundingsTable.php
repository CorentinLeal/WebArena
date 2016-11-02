<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Table;

class Surroundings extends Table {

    public $displayField = 'name';

    public function vector($direction) {
        $vector = array('x' => 0, 'y' => 0);

        switch ($direction) {
            case "north": $vector['y'] --;
                break;
            case "south": $vector['y'] ++;
                break;
            case "east": $vector['x'] ++;
                break;
            case "west": $vector['x'] --;
                break;
            default:;
        }

        return $vector;
    }

    public function checkSurroundings($fighter, $direction) {

        $result = array();

        //Détermination du vecteur mouvement à partir de la direction choisi par le joueur
        $vector = $this->vector($direction);

        //Vérification de la présence d'un Surroundings à la destination        
        $datasurroundings = $this->find('all', array('conditions' => array('coordinate_x' => ($fighter->coordinate_x + $vector['x']), 'coordinate_y' => ($player->coordinate_y + $vector['y']), 'order' => 'type')))->toArray();

        foreach ($datasurroundings as $surrounding) {
            $surrounding = $surrounding->toArray();
            $id = $surrounding[0]['id'];
            $surrounding = $this->get($id);
            $surroundings = array_merge($surroundings, array($surrounding->id => $surrounding->id));
        }

        if (count($surroundings) != 0) {
            foreach ($surroundings as $surrounding) {
                //var_dump($surrounding);
                switch ($surrounding->type) {
                    case 'trap':
                        array_push($result, 1);
                        break;
                    case 'mob':
                        array_push($result, 2);
                        break;
                    case 'wall':
                        array_push($result, 3);
                        break;
                    case 'warning_trap':
                        array_push($result, 4);
                        break;
                    case 'warning_mob':
                        array_push($result, 5);
                        break;
                    default:;
                }
            }
        } else
            array_push($result, 0);

        return $result;
    }

    public function getAllWall() {
        $resultat = $this->find('all', array('conditions' => array('type' => 'wall')));
        return $resultat;
    }

    public function getAllWarning() {
        $resultat = $this->find('all', array('conditions' => array('type' => 'warning_trap')));
        return $resultat;
    }

    public function getAllSurroundings() {
        $resultat = $this->find('all');
        return $resultat;
    }

    public function mobMove() {

        $MAPWIDTH = Configure::read('MAPWIDTH');
        $MAPHEIGHT = Configure::read('MAPHEIGHT');
        
        $datamob = $this->find('first', array('conditions' => array('type' => 'mob')))->toArray();
   
        if ($mob == null) {
            return null;
        }

        $id = $datamob[0]['id'];
        $mob = $this->get($id);
        
        
        $warnings = $this->find('all', array('conditions' => array('type' => 'mob')))->toArray();
        
        foreach ($warnings as $warning) {
                    $warning = $warning->toArray();
                    $id = $warning[0]['id'];
                    $warning = $this->get($id);
                    $warnings = array_merge($warnings, array($warning->id => $warning->id));
                }

                
        //Initialisation des coordonnées de spawn
        $coord = array('coordinate_x' => 0, 'coordinate_y' => 0);
        $tried = array();
        $freeSpot = false;

        while (!$freeSpot) {
            //Choix d'un couple (x,y) de coordonnée aléatoire dans l'arène
            $coord['coordinate_x'] = rand(0, $MAPWIDTH - 1);
            $coord['coordinate_y'] = rand(0, $MAPHEIGHT - 1);

            //Si la case (x,y) n'a pas été testée
            if (array_search($coord, $tried) == false) {
                //Si aucun Surroundings n'est positionné sur la case (x,y), la case est marquée comme libre
                      
                $datasurroundings = $this->find('all', array('conditions' => array('coordinate_x' => $coord['coordinate_x'], 'coordinate_y' => $coord['coordinate_y'])))->toArray();

                foreach ($datasurroundings as $surrounding) {
                    $surrounding = $surrounding->toArray();
                    $id = $surrounding[0]['id'];
                    $surrounding = $this->get($id);
                    $surroundings = array_merge($surroundings, array($surrounding->id => $surrounding->id));
                }
                
                if (count($surroundings == 0)){
                $freeSpot = true;}
                //Sinon la case est marquée comme testée
                else{
                    array_push($tried, $coord);
                }
            }
            //Si toute les cases ont été testées
            if (count($tried) == ($MAPWIDTH * $MAPHEIGHT)) {
                //L'Event est annulé et la boucle est terminée
                break;
            }
        }

        if ($freeSpot) {
            $mob->coordinate_x = $coord['coordinate_x'];
            $mob->coordinate_y = $coord['coordinate_y'];

            
            $this->save($mob);

            foreach ($warnings as $warning)
                $this->delete($warning->id);

            $this->genWarnings('mob', $coord);
        }
    }

    public function generate($type) {

        $MAPWIDTH = Configure::read('MAPWIDTH');
        $MAPHEIGHT = Configure::read('MAPHEIGHT');
        
        //Initialisation des coordonnées de spawn
        $coord = array('coordinate_x' => 0, 'coordinate_y' => 0);
        $tried = array();
        $freeSpot = false;

        while (!$freeSpot) {
            //Choix d'un couple (x,y) de coordonnée aléatoire dans l'arène
            $coord['coordinate_x'] = rand(0, $MAPWIDTH - 1);
            $coord['coordinate_y'] = rand(0, $MAPHEIGHT - 1);

            
            //Si la case (x,y) n'a pas été testée
            if (array_search($coord, $tried) == false) {
                //Si aucun Surroundings n'est positionné sur la case (x,y), la case est marquée comme libre
                      
                $surroundings = $this->find('all', array('conditions' => array('coordinate_x' => $coord['coordinate_x'], 'coordinate_y' => $coord['coordinate_y'])))->toArray();

                foreach ($surroundings as $surrounding) {
                    $surrounding = $surrounding->toArray();
                    $id = $surrounding[0]['id'];
                    $surrounding = $this->get($id);
                    $surroundings = array_merge($surroundings, array($surrounding->id => $surrounding->id));
                }
                
                if (count($surroundings == 0)){ 
                $freeSpot = true;}
                //Sinon la case est marquée comme testée
                else{
                    array_push($tried, $coord);
                }
            }

            //Si toute les cases ont été testées
            if (count($tried) == ($MAPWIDTH * $MAPHEIGHT))
                break;
        }
        
        //Si la dernière case testée est marquée libre
        if ($freeSpot) {
            switch ($type) {
                case 'wall': //Enregistrement du nouveau Surroundings
                    $datas = array('coordinate_x' => $coord['coordinate_x'],
                            'coordinate_y' => $coord['coordinate_y'],
                            'type' => $type
                        );
                    $wall = $this->newEntity();
                    $this->patchEntity($wall, $datas);
                    $this->save($mob);
                    break;

                case 'trap':
                case 'mob' : //Enregistrement du nouveau Surroundings
                    $datas = array('Surroundings' => array('coordinate_x' => $coord['coordinate_x'],
                            'coordinate_y' => $coord['coordinate_y'],
                            'type' => $type
                        )
                    );
                    $this->create();
                    $this->save($datas);
                    $this->genWarnings($type, $coord);
                    break;
                default :;
            }
        }
    }
    
    public function genWarnings($type, $coord) {
        
        $MAPWIDTH = Configure::read('MAPWIDTH');
        $MAPHEIGHT = Configure::read('MAPHEIGHT');

        $warning = $this->newEntity();
        $datas = array('coordinate_x' => 0, 'coordinate_y' => 0, 'type' => 'warning_' . $type);
        $warning = $this->patchEntity($datas);
        $i = 0;
        $j = 0;

        for ($k = 0; $k < 4; $k++) {

            switch ($k) {
                case 0: $i = -1;
                    $j = 0;
                    break;
                case 1: $i = 0;
                    $j = 1;
                    break;
                case 2: $i = 1;
                    $j = 0;
                    break;
                case 3: $i = 0;
                    $j = -1;
                    break;
                default:;
            }
            if (($coord['coordinate_x'] + $i >= 0) &&
                    ($coord['coordinate_x'] + $i < $MAPWIDTH) &&
                    ($coord['coordinate_y'] + $j >= 0) &&
                    ($coord['coordinate_y'] + $j < $MAPHEIGHT)
            ) {
                $warning->coordinate_x = $coord['coordinate_x'] + $i;
                $warning->coordinate_y = $coord['coordinate_y'] + $j;

                
                $this->save($warning);
            }
            $i++;
        }
    }

    public function genMap() {
        
        $MAPWIDTH = Configure::read('MAPWIDTH');
        $MAPHEIGHT = Configure::read('MAPHEIGHT');
        
        $ratio = $MAPWIDTH * $MAPHEIGHT / 10;

        for ($i = 0; $i < $ratio; $i++) {
            $this->generate('trap');
            $this->generate('wall');
        }

        $this->generate('mob');
    }

}
