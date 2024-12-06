<?php
session_start();

if (isset($_POST['verify'])) {
    $userCode = $_POST['code'];
    $storedCode = $_SESSION['codigo_de_verificacao'];

    if ($userCode == $storedCode) {
        // Limpe o código de verificação da sessão após o uso
        unset($_SESSION['codigo_de_verificacao']);

        // Proceda com o login ou outra ação necessária
        echo "<script>alert('Verificação bem-sucedida!');</script>";
        echo "<meta http-equiv=\"refresh\" content=\"0; url=admin/index.php?id_ad=" . $_SESSION['user_id'] . "\" >";
    } else {
        echo '<script>alert("Código de verificação incorreto.");</script>';
    }
}
?>

<!-- Formulário de verificação -->
<div class="content">
    <div class="main-1">
        <div class="container">
            <div class="login-page">
                <div class="account_grid">
                    <div class="col-md-6 login-right">
                        <h3>Verificação de Dois Fatores</h3>
                        <form method="post">
                            <div>
                                <span>Código de Verificação<label>*</label></span>
                                <input type="text" name="code" required> 
                            </div>
                            <input type="submit" name="verify" value="Verificar">
                        </form>
                    </div>	
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
    </div>
</div>
