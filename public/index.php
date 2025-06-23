<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Application Rcette</h1>
    <?php 
    require_once "Constant.php";
    require_once ROOT_DIR . "/config/database.php";
    Database::getConnection();
    ?>
</body>
</html>