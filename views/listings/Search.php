<?php 
include dirname(__FILE__).'/../../controllers/ListingController.php';
include dirname(__FILE__).'/../templates/PageTemplateStart.php';
?>

<div id="sidebar">
	<h2>Filter Results</h2>
	<form id="filterForm" action="" method="GET">
		<table>
			<tr>
				<td colspan="2"><h3>Price</h3></td>
			</tr>
			<tr>
				<td><p>Min:</p></td>
				<td><input type="text" name="minPrice" placeholder="£0"/></td>
			</tr>
			<tr>
				<td><p>Max:</p></td>
				<td><input type="text" name="maxPrice" placeholder="£0"/></td>
			</tr>
			<tr>
				<td colspan="2"><h3>Distance</h3></td>
			</tr>
			<tr>
				<td><p>Max:</p></td>
				<td><input type="text" name="maxDistance" placeholder="0 Miles"/></td>
			</tr>
		</table>
		<td colspan="2"><input id="submitButton" type="submit" value="Apply" /></td>
	</form>
</div>
<div id="listings">
<?php
$listings = getListings();
foreach($listings as $listing) {
  $rowid = $listing->getRowid();
  $page = "./View.php?id=$rowid";
  ?>
  <a href='<?php echo $page ?>'><div class='listing'>
    <h3><?php echo $listing->title ?></h3>
    <p><?php echo $listing->description ?></p>
    <p><?php echo $listing->price ?></p>
  </div></a>
<?php } ?>
<button onclick='redirect("http://test.html")'></button>
</div>

<?php
include dirname(__FILE__).'/../templates/PageTemplateEnd.php';
?>
