<?= $this->extend('Layout/template') ?>
<?= $this->section('content'); ?>
<div class="row">
<?php
foreach ($karty as $row) { //kdyz tohle umazu tak facha
    ?>

<div class="card" style="width:400px">
    <img class="card-img-top" src="../bootstrap4/img_avatar1.png" alt="Card image" style="width:100%">
    <div class="card-body">
      <h4 class="card-title">John Doe</h4>
      <p class="card-text">Some example text some example text. John Doe is an architect and engineer</p>
      <a href="#" class="btn btn-primary">See Profile</a>
    </div>
  </div>

  <?php
}
?>
  <?= $this->endSection(); ?>