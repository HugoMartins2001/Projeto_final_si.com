
<div class="banner-section">

			<div class="container">
				<div class="banner-grids">
					<div class="col-md-6 banner-grid">
					</div>
					<?php
$sql=$conn->query("SELECT * FROM banner WHERE id_categoria='4' and estado='1'") or die("<meta http-equiv=\"refresh\" content=\"0; url=404.php?erro=0001\" >");
if($sql->num_rows>0){	
while($row=$sql->fetch_assoc()){
?>
				<div class="col-md-6 banner-grid1">
						<img src="admin/fotosbanner/<?php echo $row['foto1'];" "?>"/>
				</div>
				<?php
}
}
?>
				<div class="clearfix"></div>
			</div>
		</div>
		
		</div>
		
		<div class="banner-bottom">
			<input type=""
		<div class="gallery-cursual">
		<!--requried-jsfiles-for owl-->
		<script src="js/owl.carousel.js"></script>
			<script>
				$(document).ready(function() {
					$("#owl-demo").owlCarousel({
						items : 3,
						lazyLoad : true,
						autoPlay : true,
						pagination : false,
					});
				});
			</script>
		<!--requried-jsfiles-for owl -->
		<!--start content-slider-->
		<!--sreen-gallery-cursual-->
		<div id="owl-demo" class="owl-carousel text-center">
			<!--	<?php
$sql=$conn->query("SELECT * FROM banner WHERE id_categoria='2' and estado='1'") or die("<meta http-equiv=\"refresh\" content=\"0; url=404.php?erro=0001\" >");
if($sql->num_rows>0){	
while($row=$sql->fetch_assoc()){
?>
			<div class="item">
				<img alt="name" class="lazyOwl" src="admin/fotosbanner/<?php echo $row['foto1'];" "?>"/>
				<div class="item-info">
					<h5><?php echo $row['descricao']?></h5>
				</div>
			</div>	
			<?php
}
}--!>
?>

		</div>
		<!--sreen-gallery-cursual-->
		<div class="subscribe">
		<div class="container">	
		</div>
		</div>
				<div class="clearfix"></div>