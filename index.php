<?php
require_once 'core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerfull.php';
include 'includes/leftbar.php';

$sql = "SELECT * FROM products WHERE featured = 1";
$featured = $db->query($sql);
?>
	<!-- main content -->


	fafdasdfasdf
	<div class="col-md-8">
		<div class="row">
			<h2 class="text-center"><br>Feature Products</h2><br><br>
			<?php 
				while($product = mysqli_fetch_assoc($featured)): 
				
			?>
				<div class="col-sm-3 text-center">
				<br>
					<h4>
					<?= $product['title'];	?>
					</h4>
				<br>
				<?php $photos = explode(',', $product['image']); ?>
					<img src="<?= $photos[0]; ?>" alt="<?= $product['title'];?>" class="img-thumb" />
					<p class="list-price text-danger">List Price: <s>$<?= $product['list_price'];?></s> </p><br>
					<p class="price">Our Price: $<?= $product['price']; ?> </p><br>
					<button type="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?= $product['id'];?>)">Details</button>
				</div>
				<?php 
					endwhile;
				?>
		</div>	
	</div>
		
<?php
include 'includes/rightbar.php';		
include 'includes/footer.php';	

?>