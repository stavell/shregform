<?php

namespace shumenxc;

class Shreg {

    public function registerPilot($pilotData) {
       foreach($pilotData as &$v) $v = trim($v);
       \DB::insert('pilots', $pilotData);

        return $this->getRegisteredPilots();
    }

    public function getRegisteredPilots() {
        return \DB::query("select pilot_number, name, nation, glider, status from pilots order by id");
    }

    public function getRegisteredPilotsDetailed() {
        return \DB::query("select * from pilots order by id");
    }

} 