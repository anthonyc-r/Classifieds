<?php 
include dirname(__FILE__)."/../../controllers/ListingController.php";
$listing = getListing();
include dirname(__FILE__)."/../templates/PageTemplateStart.php";
?>
<article>
<?php
/**ENTER IF LISTING**/
if ($listing) {
  $listing = $listing->getAssoc();

?>
  <table id="listing">
    <tr>
      <td><h2>title</h2></td>
      <td><?php echo $listing['title']; ?></td>
    </tr>
    <tr>
      <td><h2>Description: </h2></td>
      <td><p><?php echo $listing['description'] ?></p></td>
    </tr>
    <tr>
      <td><h2>Price: </h2></td>
      <td><?php echo $listing['price'] ?></td>
    </tr>
  </table>
<?php
}
/*ENTER ELSE LISTING*/
else {
?>
  <h1>Ooops, something went wrong :(</h1>
<?php
/*END IF LISTING*/
}
?>
</article>

<?php
include dirname(__FILE__)."/../templates/PageTemplateEnd.php";
?>
