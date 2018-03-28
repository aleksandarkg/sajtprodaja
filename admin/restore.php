<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/sajtprodaja/core/init.php';
		if(!is_logged_in()){
		login_error_redirect();
	}
	include 'includes/head.php';
	include 'includes/navigation.php';
	
	if(isset($_GET['restore'])){
		$idrestore = sanitize($_GET['restore']);
		$db->query("UPDATE products SET deleted = 0 WHERE id = '$idrestore'");
		header ('Location: restore.php');
	}
	
?>

<?php

$sql = "SELECT * FROM products WHERE deleted = 1";
$p_result = $db->query($sql);

?>


<br>
<h2 class="text-center">Archived products</h2>
<hr>
<table class="table table-bordered table-condensed table-striped">
	<thead>
		<th>Restore</th>
		<th>Product</th>
		<th>Price</th>
		<th>Category</th>
		<th>Featured</th>
		<th>Sold</th>
	</thead>
			<tbody>
			<?php 
				while($product = mysqli_fetch_assoc($p_result)):
				
				$childID = $product['categories'];
				$catsql = "SELECT * FROM categories WHERE id = '$childID'";
				$cat_result = $db->query($catsql);
				$child = mysqli_fetch_assoc($cat_result);
				
				$parentID = $child['parent'];
				$p_sql = "SELECT * FROM categories WHERE id = '$parentID'";
				$presult = $db->query($p_sql);
				$parent = mysqli_fetch_assoc($presult);
				
				$category = $parent['category'].'-'.$child['category'];
			?>
				<tr>
					<td>
					<a href="restore.php?restore=<?=$product['id'];?>" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-repeat"></span></a>					
					</td>
					<td><?= $product['title']; ?></td>
					<td><?= $product['price']; ?></td>
					<td><?= $category ?></td>
					<td>
					<a href="products.php?featured=<?= (($product['featured'] == 0)?'1':'0'); ?>&id=<?php echo $product['id']; ?>" class="btn btn-xs btn-<?php echo (($product['featured'] == 1)?'warning':'success'); ?>">
						<span class="glyphicon glyphicon-<?php echo (($product['featured'] == 1)?'minus':'plus'); ?>"></span>
						</a>&nbsp; <?php echo (($product['featured'] == 1)?'Remove Featured':'Add Featured'); ?>
					</td>
					
					<td>0</td>
				</tr>
				<?php 
					endwhile;
				?>
			</tbody>	
</table>

<?php
	include 'includes/footer.php';
?>