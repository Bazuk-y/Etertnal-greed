<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<?= $this->include("layout/css"); //  css?>
</head>
<body>
<div class="container">
<?= $this->renderSection("content"); //obsah stránky ?> 

<?= $this->include("layout/js"); // načtení java script?> 
</div>
</body>

</html>