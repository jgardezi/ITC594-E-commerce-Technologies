<?php require_once("../core/includes/initialize.php"); ?>
<?php	
    $session->logout();
    redirect_to("signin.php");
?>
