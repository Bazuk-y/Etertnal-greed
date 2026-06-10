<?= $this->extend("layout/sablona");?>
<?= $this->section("content");?>
<div class="container mt-4">
    <div class="row">
    <?php /** @var array $fujky */
    foreach ($fujky as $row): ?>
        <div class="col-md-4 d-flex align-items-stretch">
            <div class="card mb-4 w-100 shadow-sm">
                <img class="card-img-top img-fluid" src="<?= !empty($row['logo']) ? base_url("img/" . $row['logo']) : 'https://placehold.co/400x200?text=La+Tropicale' ?>" alt="Logo ročníku" style="max-height: 180px; object-fit: contain; padding: 15px;">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h4 class="card-title"><?= esc($row['year'] ?? 'Neznámý závod') ?></h4>
                        <p class="card-text mb-1"><strong>Celková délka:</strong> <?= esc($row['total_distance']) ?> km</p>
                        <p class="card-text mb-1"><strong>Datum začátku:</strong> <?= date('d.m.Y', strtotime($row['start_date'])) ?></p>
                        <p class="card-text mb-3"><strong>Datum konce:</strong> <?= date('d.m.Y', strtotime($row['end_date'])) ?></p>
                    </div>
                    <?= anchor("jednotlive_etapy/" . $row['id'], 'Jednotlivé etapy', ['class' => 'btn btn-primary w-100']) ?>      
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection(); ?>