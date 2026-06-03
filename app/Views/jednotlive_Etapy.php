<?= $this->extend("layout/sablona");?>
<?= $this->section("content");?>

<div class="container">
    <br>
    <h1>Etapa č. <?= esc($id_etapy) ?></h1>
    <br>

    <?php
    $table = new \CodeIgniter\View\Table();

    // Nastavení hlavičky tabulky
    $table->setHeading("Vlastnost", "Hodnota");

    // Přidání řádků z propojených tabulek
    $table->addRow("Jméno", $jezdec->first_name);
    $table->addRow("Příjmení", $jezdec->last_name);
    $table->addRow("Země", $jezdec->country);
    $table->addRow("Datum narození", $jezdec->date_of_birth);
    
    // Vzhled tabulky přes Bootstrap
    $template = [
        'table_open' => '<table class="table table-bordered table-striped">'
    ];
    $table->setTemplate($template);

    // Vypsání hotové tabulky
    echo $table->generate();
    ?> 
</div>

<?= $this->endSection(); ?>