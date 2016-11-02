<?php
App::uses('AppModel', 'Model');

class Event extends AppModel {
	
	
	/*
	 *MÃ©thode de crÃ©ation d'un Ã©vÃ©nement
	 *ReÃ§oit un Event en array contenant un nom et des coordonnÃ©es initialisÃ©s
	 */
	public function enregistrer($datas){
		
		//CrÃ©ation d'un objet Event
		$event = $this->newEntity();
		//Enregistrement de l'objet en base avec les paramètres reçu en valeurs d'attributs
		$datas = array('name'=>$datas->name,'coordinate_x'=>$datas->coordinate_x, 'coordinate_y'=>$datas->coordinate_y,'date'=>date('Y-m-d H:i:s', strtotime("now")));
                $event = $this->patchEntity($event, $datas);
		$this->save($event);
	}
	
	/*
	 *MÃ©thode de rÃ©cupÃ©ration d'un Event convertie en string
	 *ReÃ§oit un id d'Event et retourne l'Event convertie en string
	 */
	public function getEventToString($id){
		$result = "";
		
		//RÃ©cupÃ©ration de l'Event par l'id en paramÃ¨tre
		$event = $this->get($id);
		
		//Concatenation des informations de l'Event
		$result .= "[".$event->date."]:";
		$result .= $event->name;
		$result .= " en (".$event->coordinate_x.",".$event->coordinate_y.")";
		
		return $result;
	}
	
	public function getEventList($coord, $range){
        $res = array();
        $inRange = array();
        
        for ( $x=0; $x<=$range; $x++) {
            $y = $range - $x;
            for ($y; $y>=0 ;$y--) {
                array_push($inRange, array('coord_x'=>$x,'coord_y'=>$y));
                array_push($inRange, array('coord_x'=>$x,'coord_y'=>-$y));
                array_push($inRange, array('coord_x'=>-$y,'coord_y'=>$x));
                array_push($inRange, array('coord_x'=>-$y,'coord_y'=>-$x));
            }
        }
		$inRange = array_map("unserialize", array_unique(array_map("serialize", $inRange)));

        foreach($inRange as $case){
            $event = $this->find('all',array('conditions'=>array('coordinate_x'=>$coord['coord_x']+$case['coord_x'],
                                                                'coordinate_y'=>$coord['coord_y']+$case['coord_y']
                                                                )
                                            )
                                );
				if(count($event) !=0){
					foreach($event as $event){
						if(strtotime("now") - strtotime($event['Event']['date']) <86400)array_push($res,$event);
					}
				}
        }

        return $res;
	}
	
}

?>