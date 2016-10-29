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

    public function getBestFighter()
    {
        $test = $this->find('all')->order('level')->limit(1);
        return $test->toArray();
    }


    /*
 * Cette fonction retourne un Combattant en particulier. Elle prend l'id du Joueur concerné et le nom du Combattant qu'on attend
 */
    public function getFighterByUserAndName($user_id, $name)
    {
        return $this->find('first', array('conditions' => array('player_id' => $user_id, 'Fighter.name' => $name)));
    }


    /*
 * Cette fonction retourne la liste des Combattants d'un Joueur. Elle prend l'id du Joueur en paramètre
 */
    public function getAllFightersByUser($user_id)
    {
        return $this->find('all', array('conditions' => array('player_id' => $user_id)));
    }

    /*
     * Cette fonction retourne un Combattant. Elle prend son nom en paramètre
     */
    public function getFighterByName($name)
    {
        return $this->findByName($name);
    }

    /*
     * Cette fonction retourne seulement les noms (pas les autres attributs) des Combattants d'un Joueur. Elle prend l'id du Joueur en question
     */
    public function getAllFightersNamesByUser($user_id)
    {
        $result = array();
        $listeFighter = $this->find('all', array('conditions' => array('player_id' => $user_id)));

        foreach ($listeFighter as $fighter) {
            $result = array_merge($result, array($fighter['Fighter']['name'] => $fighter['Fighter']['name']));
        }
        return $result;
    }


    /*
     * Cette fonction crée un vecteur utilisé pour la gestion des déplacements du Combattant. Elle prend une direction en paramètres
     */
    public function vecteur($direction)
    {
        $vecteur = array('x' => 0, 'y' => 0);

        switch ($direction) {
            case "nord":
                $vecteur['y']++;
                break;
            case "sud":
                $vecteur['y']--;
                break;
            case "est":
                $vecteur['x']++;
                break;
            case "ouest":
                $vecteur['x']--;
                break;
        }

        return $vecteur;
    }

    public function estLa($fighter, $vecteur)
    {
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
        }else $result = -2;
        if(count($target) == 0) $result++;
        else $result = $target[0];

        return $result;
    }

    /*
     * Cette méthode permet au Combattant de se déplacer sur le terrain.
     * Paramètres: Combattant à déplacer et la direction dans laquelle il va.
     * Valeur de retour: Un Evenement déplacement avec nom et coordonnées
     */
    public function seDeplace($fighter, $direction)
    {
        $event = array('name' => '', 'coordinate_x' => 0, 'coordinate_y' => 0);

        $player = $fighter;

        $event['name'] .= $player['Fighter']['name'] . " se déplace";

        $vecteur = $this->vecteur($direction);

        $event['name'] .= $player['Fighter']['coordinate_x'] + $vecteur['x'];
        $event['name'] .= $player['Fighter']['coordinate_y'] + $vecteur['y'];

        /*
         * On vérifie si un Combattant ne se trouve pas déjà sur la case cible
         */
        if ($this->estLa($player,$vecteur) == 0){
            //On modifie les coordonees du Combattant en base puisqu'il s'est déplacé
            $data = array('Fighter' => array('id' => $player['Fighter']['id'], 'coordinate_y' => $player['Fighter']['coordinate_y'] + $vecteur['y'], 'coordinate_x' => $player['Fighter']['coordinate_x'] + $vecteur['x']))
            $this -> save($data);

        }else $event['name'] .= " mais se heurte à quelqu'un.";

        return $event;
    }

}