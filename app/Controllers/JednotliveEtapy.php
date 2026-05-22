<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Rider as trpaslik;
use App\Models\RaceYear as Golem;
use App\Models\Result as zabak;


class JednotliveEtapy extends BaseController
{
    public function index()
    {
       $RaceYear = new Golem();
       $Race = $RaceYear->join("RaceYear","Race_Year.id_race = Result.id_stage","inner")->join("Result","Result.id = Rider.id","inner");
        $data = [
            "fujky" => $Race



        ];
        echo view("jednotlive_Etapy",$data);


        
    }
}
