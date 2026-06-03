<?= $this->extend("layout/sablon");?>
<?= $this->section("content");?>

<body>
<div class="container">
    <br>
   <h1>Etapa</h1><br></h1>
   <br>
   <?php
$table = new \CodeIgniter\View\Table(); //generuje html kod tabulek
$table->setHeading("jmeno"); //nastaví sloupce
foreach($data as $row){ //bere data a dává je tam
$table->addRow(date($row->first_name));
}
$template = array( //vzhled tabulky
    'table_open'=> '<table class="table table-bordered">',
    'thead_open'=> '<thead>',
    'thead_close'=> '</thead>',
    'heading_row_start'=> '<tr>',
    'heading_row_end'=>' </tr>',
    'heading_cell_start'=> '<th>',
    'heading_cell_end' => '</th>',
    'tbody_open' => '<tbody>',
    'tbody_close' => '</tbody>',
    'row_start' => '<tr>',
    'row_end'  => '</tr>',
    'cell_start' => '<td>',
    'cell_end' => '</td>',
    'row_alt_start' => '<tr>',
    'row_alt_end' => '</tr>',
    'cell_alt_start' => '<td>',
    'cell_alt_end' => '</td>',
    'table_close' => '</table>'
    );
    
    $table->setTemplate($template);
    
echo $table->generate();

?> 
</div>
<?= $this->endSection(); ?>
