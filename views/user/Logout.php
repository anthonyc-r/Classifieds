<?php
include dirname(__FILE__).'/../../controllers/LogoutController.php';
logout();
include dirname(__FILE__).'/../templates/PageTemplateStart.php';
?>

<p1>You have successfully logged out!</p1>

<?php
include dirname(__FILE__).'/../templates/PageTemplateEnd.php';
?>
