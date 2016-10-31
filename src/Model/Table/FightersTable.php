<?php

/**
 * Created by PhpStorm.
 * User: corentin
 * Date: 25/10/16
 * Time: 23:07
 */

namespace App\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Table;

class FightersTable extends Table {
    /*
     * TP1
     */

    public function getBestFighter() {
        $test = $this->find('all')->order('level')->limit(1);
        return $test->toArray();
    }

    /*
     * Cette fonction retourne un Combattant en particulier
     * Paramètres: l'id du Joueur dont on veut le Combattant, ainsi que le nom de ce Combattant
     */

    public function getFighterByUserAndName($user_id, $name) {
        
        $fighter = $this->find('all',array('conditions' => array('player_id' => $user_id, 'fighters.name' => $name)))->toArray();
        return $fighter;
    }

    /*
     * Cette fonction retourne une liste de tous les Combattants d'un Joueur.
     * Paramètre: l'id du Joueur dont on veut les Combattants
     */

    public function getAllFightersByUser($user_id) {
        return $this->find('all', array('conditions' => array('player_id' => $user_id)));
    }

    /*
     * Cette fonction retourne un Combattant
     * Paramètre: le nom du Combattant dont on veut les attributs
     */

    public function getFighterByName($name) {
        return $this->findByName($name);
    }

    /*
     * Cette fonction retourne une liste de noms de tous les Combattants d'un Joueur.
     * Paramètre: l'id du Joueur dont on veut les noms des Combattants
     */

    public function getAllFightersNamesByUser($user_id) {
        $result = array();
        $listeFighter = $this->find('all', array('conditions' => array('player_id' => $user_id)));

        foreach ($listeFighter as $fighter) {
            $result = array_merge($result, array($fighter['Fighter']['name'] => $fighter['Fighter']['name']));
        }
        return $result;
    }

    /*
     * Cette fonction crée un vecteur utilisé pour la gestion des déplacements du Combattant.
     * Paramètre: une direction (Nord, Sud ,Est, Ouest)
     * Valeur de retour: un vecteur indispensable pour la fonction seDeplace()
     */

    public function vecteur($direction) {
        $vecteur = array('x' => 0, 'y' => 0);

        switch ($direction) {
            case "nord":
                $vecteur['y'] ++;
                break;
            case "sud":
                $vecteur['y'] --;
                break;
            case "est":
                $vecteur['x'] ++;
                break;
            case "ouest":
                $vecteur['x'] --;
                break;
        }

        return $vecteur;
    }

    /*
     * Cette méthode teste la case sur laquelle va se déplacer un Combattant pour voir si un autre Combattant ne s'y trouve pas déjà.
     * Paramètres: Combattant qui va se déplacer, vecteur dans
     * Valeurs de retour: -1 si la case est en dehors du terrain
     *                     0 si la case est vide (et donc accessible)
     *                     Si la case est occupée, retourne le Combattant qui est dessus
     */

    public function estLa($fighter, $vecteur) {
        $player = $fighter;
        $target = array();
        $result = -1;

        if ((($player['Fighter']['coordinate_x'] + $vecteur['x']) >= 0) &&
                (($player['Fighter']['coordinate_x'] + $vecteur['x']) < MAPLIMITX) &&
                (($player['Fighter']['coordinate_y'] + $vecteur['y'] >= 0) &&
                (($player['Fighter']['coordinate_y'] + $vecteur['y']) < MAPLIMITY)
                )
        ) {
            $target = $this->find('all', array('conditions' => array('coordinate_x' => ($player['Fighter']['coordinate_x'] + $vecteur['x']))));
        } else
            $result = -2;
        if (count($target) == 0)
            $result++;
        else
            $result = $target[0];

        return $result;
    }

    /*
     * Cette méthode permet au Combattant de se déplacer sur le terrain.
     * Paramètres: Combattant à déplacer et la direction dans laquelle il va.
     * Valeur de retour: Un Evenement déplacement avec nom et coordonnées
     */

    public function seDeplace($fighter, $direction) {
        $event = array('name' => '', 'coordinate_x' => 0, 'coordinate_y' => 0);

        $player = $fighter;

        $event['name'] .= $player['Fighter']['name'] . " se déplace";

        $vecteur = $this->vecteur($direction);

        $event['name'] .= $player['Fighter']['coordinate_x'] + $vecteur['x'];
        $event['name'] .= $player['Fighter']['coordinate_y'] + $vecteur['y'];

        /*
         * On vérifie si un Combattant ne se trouve pas déjà sur la case cible
         */
        if ($this->estLa($player, $vecteur) == 0) {
            //On modifie les coordonees du Combattant en base puisqu'il s'est déplacé
            $data = array('Fighter' => array('id' => $player['Fighter']['id'], 'coordinate_y' => $player['Fighter']['coordinate_y'] + $vecteur['y'], 'coordinate_x' => $player['Fighter']['coordinate_x'] + $vecteur['x']));
            $this->save($data);
        } else
            $event['name'] .= " mais se heurte à quelqu'un.";

        return $event;
    }

    /*
     * La méthode de création de Combattant.
     * Paramètres: l'id du Joueur à qui appartiendra le nouveau Combattant, le nom du nouveau Combattant
     * Sauvegarde en base tous les attributs du nouveau Combattant. (Induit un nouveau tuple dans la table Fighter).
     */

    public function createFighter($playerId, $name) {

        $MAPWIDTH = Configure::read('MAPWIDTH');
        $MAPHEIGHT = Configure::read('MAPHEIGHT');


        //Choix d'un couple (x,y) de coordonnée aléatoire dans l'arène
        $coord['coordinate_x'] = rand(0, $MAPWIDTH - 1);
        $coord['coordinate_y'] = rand(0, $MAPHEIGHT - 1);


        $fighter = $this->newEntity();
        $fighter->player_id = $playerId;
        $fighter->name = $name;
        $fighter->coordinate_x = $coord['coordinate_x'];
        $fighter->coordinate_y = $coord['coordinate_y'];
        $fighter->level = 1;
        $fighter->xp = 0;
        $fighter->skill_sight = 2;
        $fighter->skill_strength = 1;
        $fighter->skill_health = 5;
        $fighter->current_health = 5;

        return $fighter;
    }

    /*
     * Méthode action d'attaque d'un combattant
     * Reçoit un Fighter en array et une direction en string
     * Retourne un Event en array avec des valeurs nom, coordinate_x et coordinate_y initialisées
     */

    public function attaque($fighter, $direction) {

        //Détermination du vecteur d'attaque à partir de la direction choisi par le joueur
        $vector = $this->vecteur($direction);

        //Vérification de la présence d'un Fighter sur la case cible
        $defenser = $this->estLa($fighter, $vector);

        //Si un Fighter est trouvé comme "Attaqué"
        if (is_array($defenser)) {
            $result = true;

            //Jet de tentative d'attaque
            $rand = rand(1, 20);

            //Si le jet d'attaque est supérieur à 10 plus la différence de niveau des deux joueurs, l'attaque réussie
            if ($rand > (10 + $defenser['Fighter']['level'] - $fighter['Fighter']['level'])) {
                //Enregistrement de la blessure en DB
                $defenser['Fighter']['current_health'] -= $fighter['Fighter']['skill_strength'];
                $datas = array('Fighter' => array('id' => $defenser['Fighter']['id'], 'current_health' => $defenser['Fighter']['current_health']));
                $this->save($datas);
            }
        }
    }
    
    
     public function kill($fighter)
    {
        $this->delete($fighter['id']);
    }

}
