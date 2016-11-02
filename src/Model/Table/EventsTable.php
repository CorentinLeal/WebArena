<?php

class Event extends AppModel {

    public function enregistrer($event) {

        $this->create();
        $datas = array('Event' => array(
                'name' => $event['name'],
                'coordinate_x' => $event['coordinate_x'],
                'coordinate_y' => $event['coordinate_y'],
                'date' => date('Y-m-d H:i:s', strtotime("now"))
            )
        );
        $this->save($datas);
    }

    public function description($id) {
        $result = "";

        $event = $this->findById($id);

        $result .= "[" . $event['Event']['date'] . "]:";
        $result .= $event['Event']['name'];
        $result .= " en (" . $event['Event']['coordinate_x'] . "," . $event['Event']['coordinate_y'] . ")";

        return $result;
    }

    public function listeEvenements($coord, $range) {
        $res = array();
        $inRange = array();
        for ($x = 0; $x <= $range; $x++) {
            $y = $range - $x;
            for ($y; $y >= 0; $y--) {
                array_push($inRange, array('coord_x' => $x, 'coord_y' => $y));
                array_push($inRange, array('coord_x' => $x, 'coord_y' => -$y));
                array_push($inRange, array('coord_x' => -$y, 'coord_y' => $x));
                array_push($inRange, array('coord_x' => -$y, 'coord_y' => -$x));
            }
        }
        $inRange = array_map("unserialize", array_unique(array_map("serialize", $inRange)));
        foreach ($inRange as $case) {
            $event = $this->find('all', array('conditions' => array('coordinate_x' => $coord['coord_x'] + $case['coord_x'], 'coordinate_y' => $coord['coord_y'] + $case['coord_y'])));
            if (count($event) != 0) {
                foreach ($event as $event) {
                    if (strtotime("now") - strtotime($event['Event']['date']) < 86400) {
                        array_push($res, $event);
                    }
                }
            }
        }
        return $res;
    }

}
