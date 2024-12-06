
<!DOCTYPE HTML>

<?php if(!isset($_SESSION)){session_start();} 
$conn=new mysqli("localhost", "root", "", "8230273");
if(!isset($_SESSION['idioma']))$_SESSION['idioma']='pt';
    if($conn->connect_error){
        die("Ligação falhou:". $conn->connect_error); exit;
}
?>
<html>

<head>
<title>Projeto Final Segurança Informática</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all"/>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/owl.carousel.css" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta  charset="utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<script src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap-3.1.1.min.js"></script>

	<!-- cart -->
		<script src="js/simpleCart.min.js"> </script>
	<!-- cart -->
	<!-- the jScrollPane script -->
<script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>
		<script type="text/javascript" id="sourcecode">
			$(function()
			{
				$('.scroll-pane').jScrollPane();
			});
		</script>
<!-- //the jScrollPane script -->
<link href="css/form.css" rel="stylesheet" type="text/css" media="all" />
		<!-- the mousewheel plugin -->
		<script type="text/javascript" src="js/jquery.mousewheel.js"></script>
		<script type="text/javascript" src="js/bootstrap-3.1.1.min.js"></script>
<script src="js/imagezoom.js"></script>

						<!-- FlexSlider -->
  <script defer src="js/jquery.flexslider.js"></script>
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />
<script type="text/javascript" src="js/bootstrap-3.1.1.min.js"></script>
<script src="js/imagezoom.js"></script>

<script>
// Can also be used with $(document).ready()
$(window).load(function() {
  $('.flexslider').flexslider({
    animation: "slide",
    controlNav: "thumbnails"
  });
});
</script>


</head>

<body>
<?php if(isset($_SESSION['id_tipo'])){ 
		if($_SESSION['id_tipo'] == 1){ 
?>
<div class="wrapper_admin" >
	<a href="admin/index.php?pg=0" class="button_admin" ><b>ADMIN</b></a>
</div>
<?php
		}
	}
?>

					
	<!--header-->
		<?php require "header.php"; ?>
	<!--header-->
	

		<?php require "paginas.php"; ?>
		
	<!--footer-->
		<?php require "footer.php"; ?>
	<!--footer-->
		
</body>
</html>