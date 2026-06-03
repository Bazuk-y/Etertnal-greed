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

    // Vytáhneme data z databáze a rovnou je vyfiltrujeme podle id_race = 83
    $data['fujky'] = $raceYearModel->asArray()
                                   ->where('id_race', 83)
                                   ->orderBy('year', 'DESC') // Seřadí od nejnovějšího roku
                                   ->findAll(); 

    return view("Karty", $data);
}
    // 2. Metoda pro zobrazení detailu po kliknutí na tlačítko
    public function etapy($id)
    {
        // Tady si pak vytáhneš data z DB jen pro to jedno konkrétní $id
        $data = [
            "id_etapy" => $id,
            "Rider" => $first_name
            // "etapy" => $nejakaDataZModelu
        ];

        return view("jednotlive_Etapy", $data);
    }
}
