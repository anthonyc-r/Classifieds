<?php 
include dirname(__FILE__).'/../../controllers/UserController.php';
$specificUser = getUserByNameIfSet();
include dirname(__FILE__).'/../templates/PageTemplateStart.php';

if (!$user) {
?>

  <p>Please log in to view user profiles.</p>

<?php
}
else if ($specificUser) {
?>

  <article id="userInfo">
		<ul>
			<li><h1><?php echo $specificUser->name ?></h1></li>
			<li><p><?php echo $specificUser->email ?></p></li>
			<li><p><?php echo $specificUser->tel ?></p></li>
			<li><p><?php echo $specificUser->postcode ?></p></li>
		</ul>
		<?php
		if (isUserMe($user, $specificUser)) {
		?>
			<a href="Edit.php?name=<?php echo $user->name ?>">Edit Profile</a>
		<?php
		}
		?>
	</article>
	
<?php
}
else {
?>

  <p>Could not find the user.</p>

<?php
}
 
include dirname(__FILE__).'/../templates/PageTemplateEnd.php';
?>
