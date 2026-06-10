<?= $this->extend("layout/sablona");?>
<?= $this->section("content");?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Etapy ročníku</h1>
        <a href="<?= site_url('/') ?>" class="btn btn-outline-secondary">Zpět na ročníky</a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if(empty($etapy)): ?>
        <div class="alert alert-info">Pro tento ročník nebyly nalezeny žádné etapy.</div>
    <?php else: ?>
        <?php foreach ($etapy as $etapa): ?>
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Etapa č. <?= esc($etapa['number'] ?? $etapa['id']) ?>: <?= esc($etapa['departure'] ?: 'Neznámý start') ?> -> <?= esc($etapa['arrival'] ?: 'Neznámý cíl') ?></h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <strong>Datum etapy:</strong> <?= $etapa['date'] ? date('d.m.Y', strtotime($etapa['date'])) : 'Neuvedeno' ?>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <strong>Délka etapy:</strong> <?= esc($etapa['distance']) ?> km
                        </div>
                    </div>
                    
                    <h5 class="mt-3 text-secondary">Výsledky (Top 10)</h5>
                    
                    <?php if(empty($etapa['vysledky'])): ?>
                        <div class="alert alert-warning py-2 mb-0">
                            Výsledky pro tuto etapu nejsou v databázi k dispozici.
                        </div>
                    <?php else: ?>
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 10%">Pořadí</th>
                                    <th>Jméno a příjmení</th>
                                    <th style="width: 15%">Země</th>
                                    <th>Čas v etapě</th>
                                    <th style="width: 20%">Akce</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($etapa['vysledky'] as $vysledek): ?>
                                    <tr>
                                        <td><span class="badge bg-primary fs-6"><?= esc($vysledek['rank']) ?>.</span></td>
                                        <td><?= esc($vysledek['first_name'] . ' ' . $vysledek['last_name']) ?></td>
                                        <td>
                                            <span class="text-uppercase fw-bold text-muted"><?= esc($vysledek['country']) ?></span>
                                        </td>
                                        <td><code><?= esc($vysledek['time']) ?></code></td>
                                        <td>
                                            <a href="<?= site_url('vysledky/editovat/' . $vysledek['result_id']) ?>" class="btn btn-sm btn-warning">Upravit</a>
                                            <a href="<?= site_url('vysledky/smazat/' . $vysledek['result_id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Opravdu chcete tento výsledek soft-smazat?')">Smazat</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?= $this->endSection(); ?>