<?php
require_once("spelData.php");
require_once("yath.php");


session_start();


if (!isset($_SESSION['Spel']['Yahtzee']))
    $_SESSION['Spel']['Yahtzee'] = new Yahtzee();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">style.css
    <title>Yahtzee spel</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<form class="form-style-5" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <?php
    $_SESSION['Spel']['Yahtzee']->play($_POST);
    ?>
</form>
</body>
</html>