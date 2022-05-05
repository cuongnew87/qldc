<html>
<body>

<?php
include(dirname(__DIR__, 2) . "\config.php");

header("Location: ../../index.php");
?>

Welcome <?php echo $_POST["password"]; ?><br>
Your email address is: <?php echo $_POST["email"]; ?>

</body>
</html>