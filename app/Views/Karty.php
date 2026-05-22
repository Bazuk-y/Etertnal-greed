<?= $this->extend('Layout/template') ?>
<?= $this->section('content'); ?>
<div class="row">
<?php
/** @var array $fujky */
foreach ($fujky as $row) {
    ?>
    <div class="card" style="width:400px; margin: 10px;">
        <img class="card-img-top" src="../bootstrap4/img_avatar1.png" alt="Card image" style="width:100%">
        <div class="card-body">
            <h4 class="card-title"><?= esc($row['id_race'] ?? 'Neznámý závod') ?></h4>
            <p class="card-text">Tady bude nějaký popisek z databáze.</p>
            
            <?= anchor("jednotlive_etapy/" . $row['id_race'], 'Jednotlivé etapy', ['class' => 'btn btn-primary']) ?>      
        </div>
    </div>
    <?php
}
?>
</div>
<?= $this->endSection(); ?>