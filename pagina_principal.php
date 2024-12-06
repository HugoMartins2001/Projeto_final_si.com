
<?php

 $conn=new mysqli("localhost", "root", "", "8230273");
    if($conn->connect_error){
        die("Ligação falhou:". $conn->connect_error); exit;
    }
		
        if(isset($_POST['btn'])){
			
            if($_POST['nome']!="" or $_POST["psw"]!=""){
				$erro=1;
			
			$pass=md5($_POST['psw']);
			$email=addslashes($_POST['email']);
			$sql_entra=$conn->query("SELECT * from utilizadores where name='".$name."' AND password='".$pass."' ") or die("<meta http-equiv=\"refresh\" content=\"0; url=404.html\" >");
			
			if($sql_entra->num_rows>0){
				$row=$sql_entra->fetch_assoc();
				$_SESSION['nome']=$row['nome'];
				$_SESSION['id']=$row['id'];
				$_SESSION['id_tipo']=$row['tipo'];
				echo "<script>alert('Login Realizado com sucesso');</script>";
				if($_SESSION['id_tipo'] == 0){
					echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\" >";
				}
				else{
					
					echo "<meta http-equiv=\"refresh\" content=\"0; url=admin/index.php?id_ad=".$_SESSION['id']."\" >";
					}
			}
			else{
				echo '<script>alert("Nome ou password incorretos!");</script>';
				$erro_login="Palavra-Passe incorreta ou utilizador não existe";
			}
		  }
			
        }
    ?>
			<!--contact-->
			<div class="content">
 <div class="main-1">
		<div class="container">
<div class="login-page">
			   <div class="account_grid">
			   <div class="col-md-6 login-left">
			  	 <!--<h3><?php if($_SESSION['idioma']=='pt'){ ?>NOVOS CLIENTES<?php }else{ ?>NEW CUSTOMERS<?php } ?></h3>-->
					<p></p>
				 <a class="acount-btn" href="?pg=3"><?php if($_SESSION['idioma']=='pt'){ ?>Crie uma conta<?php }else{ ?>Create an Account<?php } ?></a>
			   </div>
			   <div class="col-md-6 login-right">
			  	<h3><?php if($_SESSION['idioma']=='pt'){ ?>CLIENTES REGISTADOS<?php }else{ ?>REGISTERED CUSTOMERS<?php } ?></h3>
				<form method="post">
				  <div>
					<span><?php if($_SESSION['idioma']=='pt'){ ?>Nome<?php }else{ ?>Name<?php } ?><label>*</label></span>
					<input type="name" name="nome"> 
				  </div>
				  <div>
					<span><?php if($_SESSION['idioma']=='pt'){ ?>Palavra pass<?php }else{ ?>Password<?php } ?><label>*</label></span>
					<input type="password" name="psw"> 
				  </div>
				  <input type="submit" name="btn" value="Login">
			    </form>
			   </div>	
			   <div class="clearfix"> </div>
			 </div>
		   </div>
		   </div>
	</div>
	</div>
<!-- login -->
</div>

	