<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RaceYear;
use App\Models\Stage;
use App\Models\Result;
use App\Models\Rider;

class JednotliveEtapy extends BaseController
{
    protected $raceYearModel;
    protected $stageModel;
    protected $resultModel;
    protected $riderModel;

    // Inicializace modelů v konstruktoru, abychom je nemuseli všude volat ručně
    public function __construct()
    {
        $this->raceYearModel = new RaceYear();
        $this->stageModel    = new Stage();
        $this->resultModel   = new Result();
        $this->riderModel    = new Rider();
    }

    // 1. Úvodní stránka s kartami ročníků (id_race = 83)
    public function karty()
    {
        $races = $this->raceYearModel
                      ->asArray()
                      ->where('id_race', 83)
                      ->orderBy('year', 'DESC')
                      ->findAll(); 

        foreach ($races as $key => $race) {
            $sumQuery = $this->stageModel 
                             ->asArray()
                             ->selectSum('distance', 'total_distance')
                             ->where('id_race_year', $race['id']) 
                             ->first();

            $races[$key]['total_distance'] = $sumQuery['total_distance'] ?? 0;
        }

        $data['fujky'] = $races;
        return view("Karty", $data);
    }

    // 2. Seznam etap pro vybraný ročník a jejich TOP 10 výsledků
    public function etapy($id_race_year)
    {
        $etapy = $this->stageModel
                      ->asArray()
                      ->where('id_race_year', $id_race_year)
                      ->findAll();

        foreach ($etapy as $key => $etapa) {
            // Vytáhneme výsledky seřazené PODLE ČASU
            $vsechnyVysledky = $this->resultModel
                ->asArray()
                // Přidali jsme explicitně 'as rank', aby se to nebilo s IDčky
                ->select($this->resultModel->getTable() . '.id as result_id, ' . $this->resultModel->getTable() . '.time, ' . $this->resultModel->getTable() . '.rank as rider_rank, ' . $this->riderModel->getTable() . '.id as rider_id, ' . $this->riderModel->getTable() . '.first_name, ' . $this->riderModel->getTable() . '.last_name, ' . $this->riderModel->getTable() . '.country')
                ->join($this->riderModel->getTable(), $this->riderModel->getTable() . '.id = ' . $this->resultModel->getTable() . '.id_rider', 'inner')
                ->where($this->resultModel->getTable() . '.id_stage', $etapa['id'])
                
                // NOVÁ PODMÍNKA: Pouze výsledky typu 1
                ->where($this->resultModel->getTable() . '.type_result', 1)
                
                // Filtrování nulových a prázdných časů
                ->where($this->resultModel->getTable() . '.time !=', '0:00:00')
                ->where($this->resultModel->getTable() . '.time !=', '00:00:00')
                ->where($this->resultModel->getTable() . '.time !=', '')
                ->where($this->resultModel->getTable() . '.time IS NOT NULL')
                
                // Řadíme podle času
                ->orderBy($this->resultModel->getTable() . '.time', 'ASC')
                ->findAll();

            // Odstranění duplicitních jezdců
            $unikatniVysledky = [];
            $pouzitiJezdci = [];

            foreach ($vsechnyVysledky as $vysledek) {
                $riderId = $vysledek['rider_id'];

                if (!in_array($riderId, $pouzitiJezdci)) {
                    $pouzitiJezdci[] = $riderId;
                    $unikatniVysledky[] = $vysledek;
                }

                if (count($unikatniVysledky) === 10) {
                    break;
                }
            }

            $etapy[$key]['vysledky'] = $unikatniVysledky;
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
        $vysledek = $this->resultModel
            ->asArray()
            ->select($this->resultModel->getTable() . '.*, ' . $this->riderModel->getTable() . '.first_name, ' . $this->riderModel->getTable() . '.last_name')
            ->join($this->riderModel->getTable(), $this->riderModel->getTable() . '.id = ' . $this->resultModel->getTable() . '.id_rider')
            ->where($this->resultModel->getTable() . '.id', $id_vysledku)
            ->first();

        if (!$vysledek) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Výsledek nenalezen.");
        }

        $data['vysledek'] = $vysledek;
        return view("editovat_vysledek", $data);
    }

    // 4. Uložení formuláře a přesné přesměrování zpět na tabulku etap
    public function ulozitVysledek($id_vysledku)
    {
        // Zjistíme id_race_year, abychom věděli, kam uživatele z redirectu přesně vrátit
        $aktualniVysledek = $this->resultModel
            ->asArray()
            ->select($this->stageModel->getTable() . '.id_race_year')
            ->join($this->stageModel->getTable(), $this->stageModel->getTable() . '.id = ' . $this->resultModel->getTable() . '.id_stage')
            ->where($this->resultModel->getTable() . '.id', $id_vysledku)
            ->first();

        $id_race_year = $aktualniVysledek['id_race_year'] ?? null;
        $id_rider = $this->request->getPost('id_rider');
        
        // Aktualizace jezdce v tabulce přes model
        $this->riderModel->update($id_rider, [
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name')
        ]);

        // Aktualizace času a pořadí v result přes model
        $dataResult = [
            'time' => $this->request->getPost('time'),
            'rank' => $this->request->getPost('rank')
        ];

        $this->resultModel->update($id_vysledku, $dataResult);

        if ($id_race_year) {
            return redirect()->to(site_url('jednotlive_etapy/' . $id_race_year))->with('success', 'Výsledky byly úspěšně uloženy.');
        }
        return redirect()->to(site_url('/'))->with('success', 'Výsledky byly úspěšně uloženy.');
    }

    // 5. Metoda pro Soft Delete (Virtuální smazání)
    public function smazatVysledek($id_vysledku)
    {
        $this->resultModel->delete($id_vysledku);
        return redirect()->to(previous_url())->with('success', 'Záznam byl úspěšně soft-smazán.');
    }
}