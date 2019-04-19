<?php 
include dirname(__FILE__).'/../../controllers/ListingController.php';
include dirname(__FILE__).'/../templates/PageTemplateStart.php';
?>

<div id="sidebar">
  <p>Set catagory limits</p>
  <p>Set listings per page</p>
  <p>Set price limits</p>
  <p>Set area limits</p>
</div>
<div id="listings">
<?php
$listings = getListings();
foreach($listings as $listing) {
  $assoc = $listing->getAssoc();
  $rowid = $listing->getRowid();
  $page = "./View.php?id=$rowid";
  ?>
  <a href="<?php echo $page ?>"><div class="listing">
    <h3><?php echo $assoc['title'] ?></h3>
    <p><?php echo $assoc['description'] ?></p>
    <p><?php echo $assoc['price'] ?></p>
  </div></a>
<?php } ?>
<button onclick="redirect('http://test.html')"></button>
</div>

<?php
include dirname(__FILE__).'/../templates/PageTemplateEnd.php';
?>
