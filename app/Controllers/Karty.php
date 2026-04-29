<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\Karty as KartyModel;

class Karty extends BaseController
{
    private $dataTypkomponent;

    public function index(){
        $TKM = new KartyModel();
        $data = [
            "karty" => $TKM
        ];
        echo view('Karty', $data);

    }
}








?>