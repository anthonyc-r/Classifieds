<?php 
include dirname(__FILE__).'/../../controllers/UserController.php';
include dirname(__FILE__).'/../templates/PageTemplateStart.php';
if (!$user) {
?>

	<p>Please log in to edit this profile.</p>

<?php
}
else if (didEditUser($user)) {
?>

	<p>Your profile has been updated!</p>

<?php
}
else {
?>

	<form method='POST' action=''>
		<table>
			<tr>
				<td>name:</td>
				<td><input type='text' name='name' disabled placeholder='<?php echo $user->name ?>' /></td>
				<td>You cannot edit your name.</td>
			</tr>
			<tr>
				<td>email:</td>
				<td><input type='email' name='email' placeholder='<?php echo $user->email ?>' /></td>
			</tr>
				<tr><td>tel:</td>
				<td><input type='text' name='tel' placeholder='<?php echo $user->tel ?>' /></td>
			</tr>
				<tr><td>postcode:</td>
				<td><input type='text' name='postcode' placeholder='<?php echo $user->postcode ?>' /></td>
			</tr>
		</table>
		<input type='submit' value='Submit' />
	</form>

<?php
}
include dirname(__FILE__).'/../templates/PageTemplateEnd.php';
?>
