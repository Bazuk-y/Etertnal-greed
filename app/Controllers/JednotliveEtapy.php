<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Rider;
use App\Models\RaceYear;
use App\Models\Result;


class JednotliveEtapy extends BaseController
{
    public function Join()
    {
       $RaceYear = new RaceYear();
       $Race = $RaceYear->join("RaceYear","Race_Year.id_race = Result.id_stage","inner")->join("Result","Result.id = Rider.id","inner");
        
        


        
    }
}
