<div class="header">
			<div class="header-top">
			<div class="container">
				 <div class="lang_list">	 
				 <form method="post" tabindex="4" class="dropdown1" style="width:45px; margin-top:-5px; height:auto;">
                            <button name="pt" style="padding: 10px 20px;border-radius:4px;  background-position: center; background-size: cover; cursor: pointer; align-items: flex-start; box-sizing: border-box; border-width: -0px; border-style: outset; ">PT</button>
                        </form>
   			</div>
			 <div class="lang_list">	 
				 <form method="post" tabindex="4" class="dropdown1" style="width:45px; margin-top:-5px; height:auto;">
                           <button name="eng" style="padding: 10px 14px;border-radius:4px;  background-position: center; background-size: cover; cursor: pointer; align-items: flex-start; box-sizing: border-box; border-width: -0px; border-style: outset;   ">ENG</button>
                        </form>
   			</div>
			<?php
			if(isset($_POST['pt'])){
				$_SESSION['idioma']='pt';
			}
			if(isset($_POST['eng'])){
				$_SESSION['idioma']='eng';
			}
			?>
				<div class="top-right">
				<ul>
				<?php
				if(ISSET($_SESSION['nome'])){
								$nome = $_SESSION['nome'];
								echo $nome;
						}
						?>
				<?php if(!isset($_SESSION['nome'])){ ?>
					<li class="text"><a href="?pg=2"><?php if($_SESSION['idioma']=='pt'){ ?>Entrar<?php }else{ ?>Login<?php } ?></a></li>
				<?php }
				
				else{
				?>
					<li class="text"><a href="logout.php"><?php if($_SESSION['idioma']=='pt'){ ?>Sair<?php }else{ ?>Logout<?php } ?></a></li>
				<?php } ?>
				</ul>
				</div>
				<div class="clearfix"></div>
			</div>
			</div>
			<div class="header-bottom">
					<div class="container">
<!--/.content-->
<div class="content white">
	<nav class="navbar navbar-default" role="navigation">
	    <div class="navbar-header">
	        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
	        </button>
	        <div> 
					<h1><a href="?pg=0" ><img src="images/logo.png" alt="" width="170px" height="150px"></a></h1>
				</div>
	    </div>
	    <!--/.navbar-header-->
	
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	        <ul class="nav navbar-nav">
			<li><a href="index.php?pg=2"><?php if($_SESSION['idioma']=='pt'){ ?>Página principal<?php }else{ ?>Home<?php } ?></a></li>
		        <li class="dropdown">
		            <ul class="dropdown-menu multi-column columns-3">
			            <div class="row">
				            <div class="col-sm-4">
				            </div>
							<div class="col-sm-4">
					            <ul class="multi-column-dropdown">
					            </ul>
				            </div>
			            </div>
		            </ul>
		        </li>
	        </ul>
	    </div>
	    <!--/.navbar-collapse-->
	</nav>
	<!--/.navbar-->
</div>
<!-- search-scripts -->
					<script src="js/classie.js"></script>
					<script src="js/uisearch.js"></script>
						<script>
							new UISearch( document.getElementById( 'sb-search' ) );
						</script>
					<!-- //search-scripts -->
					<div class="clearfix"></div>
					</div>
				</div>
		</div>