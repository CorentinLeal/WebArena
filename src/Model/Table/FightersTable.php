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

        $datafighter = $this->find('all', array('conditions' => array('player_id' => $user_id, 'name' => $name)))->toArray();

        if ($datafighter == null) {
            return null;
        }

        $id = $datafighter[0]['id'];
        $fighter = $this->get($id);
        return $fighter;
    }

    /*
     * Cette fonction retourne une liste de tous les Combattants d'un Joueur.
     * Paramètre: l'id du Joueur dont on veut les Combattants
     */

    public function getAllFightersByUser($user_id) {

        $fighters = $this->find('all', array('conditions' => array('player_id' => $user_id)))->toArray();
        foreach ($fighters as $fighter) {
            $fighter = $fighter->toArray();
            $id = $fighter[0]['id'];
            $fighter = $this->get($id);
            $result = array_merge($result, array($fighter->name => $fighter->name));
        }

        return $result;
    }

    /*
     * Cette fonction retourne un Combattant
     * Paramètre: le nom du Combattant dont on veut les attributs
     */

    public function getFighterByName($name) {

        $datafighter = $this->findByName($name)->toArray();
        $id = $datafighter[0]['id'];
        $fighter = $this->get($id);

        return $fighter;
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
        $target = array();
        $result = -1;

        $MAPWIDTH = Configure::read('MAPWIDTH');
        $MAPHEIGHT = Configure::read('MAPHEIGHT');

        if ((($fighter->coordinate_x + $vecteur['x']) >= 0) &&
                (($fighter->coordinate_x + $vecteur['x']) < $MAPWIDTH) &&
                (($fighter->coordinate_y + $vecteur['y'] >= 0) &&
                (($fighter->coordinate_y + $vecteur['y']) < $MAPHEIGHT)
                )
        ) {
            $target = $this->find('all', array('conditions' => array('coordinate_x' => ($fighter->coordinate_x + $vecteur['x']))))->toArray();
        } else
            $result = -2;
        if (count($target) == 0)
            $result++;
        else
            $result = $target[0];

        pr($result);

        return $result;
    }

    /*
     * Cette méthode permet au Combattant de se déplacer sur le terrain.
     * Paramètres: Combattant à déplacer et la direction dans laquelle il va.
     * Valeur de retour: Un Evenement déplacement avec nom et coordonnées
     */

    public function seDeplace($fighter, $direction) {
        $event = array('name' => '', 'coordinate_x' => 0, 'coordinate_y' => 0);

        $event['name'] .= $fighter->name . " se déplace";

        $vecteur = $this->vecteur($direction);

        $event['name'] .= $fighter->coordinate_x + $vecteur['x'];
        $event['name'] .= $fighter->coordinate_y + $vecteur['y'];

        /*
         * On vérifie si un Combattant ne se trouve pas déjà sur la case cible
         */
        if ($this->estLa($fighter, $vecteur) == 0) {
            pr($fighter);
            if($this->save($fighter)){
                pr($this);
            }
        } else {
            pr("tata");
            $event['name'] .= " mais se heurte à quelqu'un.";
        }

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

        if ($this->getFighterByUserAndName($playerId, $name)) {
            return null;
        }


        //Choix d'un couple (x,y) de coordonnée aléatoire dans l'arène
        $coord['coordinate_x'] = rand(0, $MAPWIDTH - 1);
        $coord['coordinate_y'] = rand(0, $MAPHEIGHT - 1);


        $fighter = $this->newEntity();

        $createFighter = array('name' => $name,
            'level' => 1,
            'xp' => 0,
            'coordinate_x' => $coord['coordinate_x'],
            'coordinate_y' => $coord['coordinate_y'],
            'skill_sight' => 2,
            'skill_strength' => 1,
            'skill_health' => 5,
            'current_health' => 5,
            'player_id' => $playerId);
        $fighter = $this->patchEntity($fighter, $createFighter);

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
            if ($rand > (10 + $defenser['Fighter']['level'] - $fighter->level)) {
                //Enregistrement de la blessure en DB
                $defenser['Fighter']['current_health'] -= $fighter->skill_strength;
                $fighter->id = $defenser['Fighter']['id'];
                $fighter->current_health = $defenser['Fighter']['current_health'];
                $this->save($fighter);
            }
        }
    }

    public function kill($fighter) {

        $result = $this->delete($fighter->id);

        return $result;
    }

    /*
     * Méthode de vérification si un combattant peu monter de niveau
     * Reçoit un combattant et retourne un booléen
     */

    public function canLevelUp($fighter) {

        $XPUP = Configure::read('XPUP');
        $result = false;

        if ($fighter->xp >= $XPUP)
            $result = true;

        return $result;
    }

    /*
     * Méthode de passage de niveau d'un combattant
     * Reçoit un combattant et une stat à  améliorer et retourne le Fighter modifié
     */

    public function levelUp($fighter, $stat) {

        $XPUP = Configure::read('XPUP');

        //Si le Fighter à XPUP d'xp au moins
        if ($fighter->xp >= $XPUP) {

            //Retrait de XPUP d'xp, incrément du level, amélioration d'une stat et remise au max des HP
            $fighter->xp -= $XPUP;
            $fighter->level ++;
            
            
            switch ($stat) {
                case 'health':
                    $fighter->skill_health ++;
                    break;
                case 'sight':
                    $fighter->skill_sight ++;
                    break;
                case 'strength':
                    $fighter->skill_strength ++;
                    break;
            }
        }

        $fighter->current_health = $fighter->skill_health;

        return $fighter;
    }

}
