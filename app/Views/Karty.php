<?= $this->extend("layout/sablona");?>
<?= $this->section("content");?>
<div class="row">
<?php
/** @var array $fujky */
foreach ($fujky  as $row) {
    
        // Pokud id_race NENÍ 83, přeskoč tento řádek a jdi na další
        if ($row['id_race'] != "83") {
            continue;
        }
    ?>
    <div class="card" style="width:400px; margin: 10px;">
        <img class="card-img-top" src="<?= base_url("img/" . $row['logo']) ?>" alt="Card image" style="width:100%">
        <div class="card-body">
            <h4 class="card-title"><?= esc($row['year'] ?? 'Neznámý závod') ?></h4>
            <p class="card-text">Celková délka: <?= esc($row['total_distance']) ?> km</p>
            <p class="card-text">Datum začátku: <?= date('d.m.Y', strtotime($row['start_date'])) ?></p>
            <p class="card-text">Datum Konce: <?= date('d.m.Y', strtotime($row['end_date'])) ?></p>
            
            <?= anchor("jednotlive_etapy/" . $row['id_race'], 'Jednotlivé etapy', ['class' => 'btn btn-primary']) ?>      
        </div>
    </div>
    <?php
}
?>
</div>
<?= $this->endSection(); ?>