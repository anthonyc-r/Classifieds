<?php 
include dirname(__FILE__)."/../../controllers/ListingController.php";
$listing = getListing();
include dirname(__FILE__)."/../templates/PageTemplateStart.php";
$success = deleteListing($user, $listing);

if ($success) {
?>

<p>This listing has been deleted.</p>

<?php 
}
else {
?>

<p>Oops, something went wrong...</p>

<?php
}
include dirname(__FILE__)."/../templates/PageTemplateEnd.php";
?>
