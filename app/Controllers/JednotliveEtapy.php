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
        $db = \Config\Database::connect();

        // Vytáhneme data z databáze a rovnou je vyfiltrujeme podle id_race = 83
        $races = $raceYearModel->asArray()
                               ->where('id_race', 83)
                               ->orderBy('year', 'DESC') // Seřadí od nejnovějšího roku
                               ->findAll(); 

        // Projdeme každý závod a spočítáme k němu celkovou délku etap
        foreach ($races as $key => $race) {
            // POZOR: Pokud se tvoje tabulka s etapami jmenuje jinak než 'stages', přepiš název níže
            $sumQuery = $db->table('stage') 
                           ->selectSum('distance', 'total_distance')
                           ->where('id_race_year', $race['id']) // id_race_year odpovídá id z tabulky závodů
                           ->get()
                           ->getRowArray();

            // Uložíme výsledný součet do pole k danému závodu (pokud nic nenajde, dá 0)
            $races[$key]['total_distance'] = $sumQuery['total_distance'] ?? 0;
        }

        // Data předáme do View pod původním názvem 'fujky'
        $data['fujky'] = $races;

        return view("Karty", $data);
    }

    // 2. Metoda pro zobrazení detailu po kliknutí na tlačítko
    public function etapy($id)
    {
        $raceYearModel = new Golem(); // Model RaceYear

        // Spojíme tabulky dohromady a vybereme konkrétní ID
        // Předpokládám, že propojujeme RaceYear -> Result -> Rider
        $jezdecData = $raceYearModel
            ->select('Race_Year.*, Result.*, Rider.*') // Vybere sloupce ze všech tabulek
            ->join('Result', 'Result.id_stage = Race_Year.id_race', 'inner') // Spojení na výsledky
            ->join('Rider', 'Rider.id = Result.id', 'inner')               // Spojení na jezdce
            ->where('Race_Year.id_race', $id)                               // Vyfiltrujeme podle ID z URL
            ->first();                                                     // Vytáhneme první odpovídající řádek jako objekt

        // Pokud databáze nic nevrátila, vyhodíme 404, ať web nespadne na chybě
        if (!$jezdecData) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Etapa nebo jezdec nenalezen.");
        }

        // Zabalíme data do pole pro View
        $data = [
            "id_etapy" => $id,
            "jezdec"   => $jezdecData // Tady už bude schovaný i ten tvůj $jezdec->first_name!
        ];

        return view("jednotlive_Etapy", $data);
    }
}