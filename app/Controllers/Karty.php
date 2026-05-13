<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Karty as KartyModel;



class Karty extends BaseController
{
    private $dataTypkomponent;

    public function index(){
        $KM = new KartyModel();
        $funguj = $KM->findAll();
        $data = [
            "funguj" => $funguj

        ];
        echo view('Karty', $data);

    }
}








?>