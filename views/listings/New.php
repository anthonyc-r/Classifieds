<?php 
include dirname(__FILE__)."/../../controllers/ListingController.php";
include dirname(__FILE__)."/../templates/PageTemplateStart.php";
?>

<?php
/**ENTER IF !NEWLISTING**/
if ($user && !newListing($user)) {
?>
  <form action="./New.php" method="POST">
    <span><?php echo $errors ?></span>
    <table>
      <tr>
        <td><label>Title</label></td>
        <td><input type="text" name="title"></td>
      </tr>
      <tr>
        <td><label>Description</label></td>
        <td><textarea name="description"></textarea></td>
      </tr>
      <tr>
        <td><label>Price</label></td>
        <td><input type="text" name="price"></td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit"></td>
      </tr>
    </table>
  </form>
<?php
} 
else if($user) {
?>
  <p>Listing submitted!</p>
<?php
} else {
?>
  <p>Please log in to submit an advert.</p>
<?php
}
/**EXIT IF**/ 
include dirname(__FILE__)."/../templates/PageTemplateEnd.php";
?>
