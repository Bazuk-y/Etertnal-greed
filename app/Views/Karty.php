<?= $this->extend('Layout/sablona'); ?>
<?= $this->section('content'); ?>
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
        <img class="card-img-top" src="../bootstrap4/img_avatar1.png" alt="Card image" style="width:100%">
        <div class="card-body">
            <h4 class="card-title"><?= esc($row['year'] ?? 'Neznámý závod') ?></h4>
            <p class="card-text">Celková délka: <?= esc($row['total_distance']) ?> km</p>
            <p class="card-text">Datum začátku:<?=  $row['start_date'] ?></p>
            <p class="card-text">Datum Konce:<?=  $row['end_date'] ?></p>
            
            <?= anchor("jednotlive_etapy/" . $row['id_race'], 'Jednotlivé etapy', ['class' => 'btn btn-primary']) ?>      
        </div>
    </div>
    <?php
}
?>
</div>
<?= $this->endSection(); ?>