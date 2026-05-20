<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RaceYear as Golem;

class JednotliveEtapy extends BaseController
{
    // 1. Metoda pro zobrazení všech karet na úvodní stránce
    public function karty()
{
    $raceYearModel = new \App\Models\RaceYear();

    // Přidali jsme asArray()
    $raceData = $raceYearModel->asArray()->findAll(10); 

    $data = [
        "fujky" => $raceData
    ];

    return view("Karty", $data);
}
    // 2. Metoda pro zobrazení detailu po kliknutí na tlačítko
    public function etapy($id)
    {
        // Tady si pak vytáhneš data z DB jen pro to jedno konkrétní $id
        $data = [
            "id_etapy" => $id
            // "etapy" => $nejakaDataZModelu
        ];

        return view("jednotlive_Etapy", $data);
    }
}
