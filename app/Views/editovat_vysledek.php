<?= $this->extend("layout/sablona");?>
<?= $this->section("content");?>

<div class="container mt-4" style="max-width: 600px;">
    <div class="card shadow">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">Správa výsledků etapy</h4>
        </div>
        <div class="card-body">
            <form action="<?= site_url('vysledky/ulozit/' . $vysledek['id']); ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id_rider" value="<?= $vysledek['id_rider'] ?>">

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Jméno" value="<?= esc($vysledek['first_name']) ?>" required>
                    <label for="first_name">Jméno závodníka</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Příjmení" value="<?= esc($vysledek['last_name']) ?>" required>
                    <label for="last_name">Příjmení závodníka</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="time" name="time" placeholder="Čas" value="<?= esc($vysledek['time']) ?>" required>
                    <label for="time">Čas v etapě</label>
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select" id="rank" name="rank" required>
                        <option value="" disabled <?= empty($vysledek['rank']) ? 'selected' : '' ?>>Vyberte položku</option>
                        <?php for ($i = 1; $i <= 100; $i++): ?>
                            <option value="<?= $i ?>" <?= $vysledek['rank'] == $i ? 'selected' : '' ?>><?= $i ?>. místo</option>
                        <?php endfor; ?>
                        <option value="DNF" <?= $vysledek['rank'] == 'DNF' ? 'selected' : '' ?>>DNF (Nedokončil)</option>
                    </select>
                    <label for="rank">Pořadí v etapě</label>
                </div>

                <div class="mb-4">
                    <label for="wysiwyg-editor" class="form-label text-muted small">Poznámka k operaci (WYSIWYG)</label>
                    <textarea id="wysiwyg-editor" name="poznamka"><p>Záznam upraven přes administraci webu.</p></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="javascript:history.back()" class="btn btn-secondary">Zrušit</a>
                    <button type="submit" class="btn btn-success">Uložit změny</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#wysiwyg-editor',
        height: 180,
        menubar: false,
        plugins: 'lists link',
        toolbar: 'undo redo | bold italic | bullist numlist'
    });
</script>

<?= $this->endSection(); ?>