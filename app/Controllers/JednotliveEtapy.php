<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Result;

class JednotliveEtapy extends BaseController
{
    // 1. Úvodní stránka s kartami ročníků (id_race = 83)
    public function karty()
    {
        $db = \Config\Database::connect();

        $races = $db->table('koloslaf_race_year')
                    ->where('id_race', 83)
                    ->orderBy('year', 'DESC')
                    ->get()
                    ->getResultArray(); 

        foreach ($races as $key => $race) {
            $sumQuery = $db->table('koloslaf_stage') 
                           ->selectSum('distance', 'total_distance')
                           ->where('id_race_year', $race['id']) 
                           ->get()
                           ->getRowArray();

            $races[$key]['total_distance'] = $sumQuery['total_distance'] ?? 0;
        }

        $data['fujky'] = $races;
        return view("Karty", $data);
    }

    // 2. Seznam etap pro vybraný ročník a jejich TOP 10 výsledků
    public function etapy($id_race_year)
    {
        $db = \Config\Database::connect();

        $etapy = $db->table('koloslaf_stage')
                    ->where('id_race_year', $id_race_year)
                    ->get()
                    ->getResultArray();

        foreach ($etapy as $key => $etapa) {
            $vysledky = $db->table('koloslaf_result')
                ->select('koloslaf_result.id as result_id, koloslaf_result.time, koloslaf_result.rank, koloslaf_rider.first_name, koloslaf_rider.last_name, koloslaf_rider.country')
                ->join('koloslaf_rider', 'koloslaf_rider.id = koloslaf_result.id_rider', 'inner')
                ->where('koloslaf_result.id_stage', $etapa['id'])
                // TENTO ŘÁDEK ZDE SMAŽ NEBO ZAKOMENTUJ:
                // ->where('koloslaf_result.deleted_at', null) 
                ->orderBy('CAST(koloslaf_result.rank AS UNSIGNED)', 'ASC')
                ->limit(10)
                ->get()
                ->getResultArray();

            $etapy[$key]['vysledky'] = $vysledky;
        }

        $data = [
            "id_rocniku" => $id_race_year,
            "etapy"      => $etapy
        ];
        
        return view("jednotlive_Etapy", $data);
    }

    // 3. Zobrazení formuláře pro úpravu výsledku
    public function editovatVysledek($id_vysledku)
    {
        $db = \Config\Database::connect();

        $vysledek = $db->table('koloslaf_result')
            ->select('koloslaf_result.*, koloslaf_rider.first_name, koloslaf_rider.last_name')
            ->join('koloslaf_rider', 'koloslaf_rider.id = koloslaf_result.id_rider')
            ->where('koloslaf_result.id', $id_vysledku)
            ->get()
            ->getRowArray();

        if (!$vysledek) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Výsledek nenalezen.");
        }

        $data['vysledek'] = $vysledek;
        return view("editovat_vysledek", $data);
    }

    // 4. Uložení formuláře a přesné přesměrování zpět na tabulku etap
    public function ulozitVysledek($id_vysledku)
    {
        $resultModel = new Result();
        $db = \Config\Database::connect();

        // Zjistíme id_race_year, abychom věděli, kam uživatele z redirectu přesně vrátit
        $aktualniVysledek = $db->table('koloslaf_result')
            ->select('koloslaf_stage.id_race_year')
            ->join('koloslaf_stage', 'koloslaf_stage.id = koloslaf_result.id_stage')
            ->where('koloslaf_result.id', $id_vysledku)
            ->get()
            ->getRowArray();

        $id_race_year = $aktualniVysledek['id_race_year'] ?? null;
        $id_rider = $this->request->getPost('id_rider');
        
        // Aktualizace jezdce v tabulce koloslaf_rider
        $db->table('koloslaf_rider')->where('id', $id_rider)->update([
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name')
        ]);

        // Aktualizace času a pořadí v koloslaf_result přes bezpečný model
        $dataResult = [
            'time' => $this->request->getPost('time'),
            'rank' => $this->request->getPost('rank')
        ];

        $resultModel->update($id_vysledku, $dataResult);

        if ($id_race_year) {
            return redirect()->to(site_url('jednotlive_etapy/' . $id_race_year))->with('success', 'Výsledky byly úspěšně uloženy.');
        }
        return redirect()->to(site_url('/'))->with('success', 'Výsledky byly úspěšně uloženy.');
    }

    // 5. Metoda pro Soft Delete (Virtuální smazání)
    public function smazatVysledek($id_vysledku)
    {
        $resultModel = new Result();
        $resultModel->delete($id_vysledku);

        return redirect()->to(previous_url())->with('success', 'Záznam byl úspěšně soft-smazán.');
    }
}