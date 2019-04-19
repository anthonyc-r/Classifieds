<?php
include dirname(__FILE__).'/../../controllers/RegistrationController.php';
$error = register();
include dirname(__FILE__).'/../templates/PageTemplateStart.php';
?>

<?php
if ($user) {
?>
<h1>Registration successful.</h1>
<?php
}
else if ($error) {
?> 
<h1>An error occurred: <?php echo $error ?></h1>
<?php
}
else {
?>
  <form method="POST" id="registrationForm">
    <table>
      <tr><td><label>Username: </label></td><td><input type="text" name="username"></td></tr>
	    <tr><td><label>Email: </label></td><td><input type="email" name="email"></td></tr>
			<tr><td><label>Postcode: </label></td><td><input type="postcode" name="postcode"></td></tr>
			<tr><td><label>Tel: </label></td><td><input type="telephone" name="telephone"></td></tr>
			<tr><td><label>Password: </label></td><td><input type="password" name="password"></td></tr>
	    <tr><td><input type="submit" value="Register"></td></tr>
    </table>
  </form>
<?php
}
?>




<?php
include dirname(__FILE__).'/../templates/PageTemplateEnd.php';
?>
