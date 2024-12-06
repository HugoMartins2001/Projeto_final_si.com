<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function enviarCodigoDeVerificacao($email, $codigo, $nome) {
    $subject = "Código de Verificação de Login";
    $message = '
    <html>
    <head>
        <title>Código de Verificação de Login</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f9f9f9;
                margin: 0;
                padding: 0;
            }
            .container {
                max-width: 600px;
                margin: 20px auto;
                padding: 40px;
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            }
            h1 {
                color: #333;
                text-align: center;
                font-size: 28px;
                margin-bottom: 20px;
            }
            p {
                color: #666;
                line-height: 1.6;
                margin-bottom: 20px;
            }
            .code {
                display: block;
                width: fit-content;
                margin: 20px auto;
                padding: 10px 20px;
                font-size: 24px;
                font-weight: bold;
                color: #4CAF50;
                background-color: #f0f0f0;
                border: 1px dashed #4CAF50;
                border-radius: 5px;
            }
            .note {
                text-align: center;
                margin-top: 20px;
                font-size: 14px;
                color: #999;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Código de Verificação de Login</h1>
            <p>Olá, '. htmlspecialchars($nome) .',</p>
            <p>Seu código de verificação é:</p>
            <div class="code">' . $codigo . '</div>
            <p>Por favor, insira este código para completar o login.</p>
            <p class="note">Se você não solicitou este código, por favor ignore este e-mail.</p>
        </div>
    </body>
    </html>';

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hugolm280@gmail.com';
        $mail->Password = 'uvvm fjvd mabz qegu';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('seu_email@gmail.com', 'No-Reply@projetofinal.pt');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
    } catch (Exception $e) {
        echo "<script>alert('Erro ao enviar o código de verificação. Mailer Error: {$mail->ErrorInfo}');</script>";
    }
}

function Desencriptar_texto($texto, $chave) {
    // Desencriptar o texto criptografado em base64
    $texto_descodificado = base64_decode($texto);
    // Recuperar o IV a partir do texto desencriptado
    $iv_length = openssl_cipher_iv_length('aes-256-cbc');
    $iv = substr($texto_descodificado, 0, $iv_length);
    // Recuperar o texto criptografado sem o IV
    $texto_encriptado = substr($texto_descodificado, $iv_length);
    // Descriptografar o texto usando o IV e a chave
    $texto_desincriptado = openssl_decrypt($texto_encriptado, 'aes-256-cbc', $chave, 0, $iv);
    return $texto_desincriptado;
}


// Conectar com a base de dados
$conn = new mysqli("localhost", "root", "", "8230273");

// Verificar a conexão
if ($conn->connect_error) {
    die("Ligação falhou: " . $conn->connect_error);
}

if (isset($_POST['btn'])) {

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['psw'];


    if (!empty($email) && !empty($password)) {

        $stmt = $conn->prepare("SELECT * FROM utilizadores WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar se encontrou um utilziador com o email fornecido
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $chave_de_encriptacao = $row['chave'];

            $password_desincriptada = Desencriptar_texto($row['password'], $chave_de_encriptacao);

            if ($password === $password_desincriptada) {
                if ($row['verificado'] == 1) {

                    $codigo_de_verificacao = rand(100000, 999999);

                    // Armazenar o código de verificação e o email na atual sessão
                    $_SESSION['codigo_de_verificacao'] = $codigo_de_verificacao;
                    $_SESSION['email_verificacao'] = $email;
                    $_SESSION['nome_verificacao'] = $row['nome'];
                    
                    enviarCodigoDeVerificacao($email, $codigo_de_verificacao, $row['nome']);

                    echo "<script>alert('Código de verificação enviado para seu e-mail.');
                    window.location.href='verify_login.php';</script>";

                $_SESSION['nome'] = $row['nome'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['id_tipo'] = $row['tipo'];
            }else{
                echo '<script>alert("Conta não foi verificado");</script>';
            }
            } else {
                echo '<script>alert("Palavra-pass incorreta!");</script>';
            }
        } else {
            echo '<script>alert("E-mail não encontrado!");</script>';
        }

        $stmt->close();
    } else {
        echo '<script>alert("Por favor, preencha o e-mail e a senha!");</script>';
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
                        <h3><?php if ($_SESSION['idioma'] == 'pt') { ?>NOVOS CLIENTES<?php } else { ?>NEW CUSTOMERS<?php } ?></h3>
                        <p></p>
                        <a class="acount-btn" href="?pg=3"><?php if ($_SESSION['idioma'] == 'pt') { ?>Crie uma conta<?php } else { ?>Create an Account<?php } ?></a>
                    </div>
                    <div class="col-md-6 login-right">
                        <h3><?php if ($_SESSION['idioma'] == 'pt') { ?>CLIENTES REGISTADOS<?php } else { ?>REGISTERED CUSTOMERS<?php } ?></h3>
                        <form method="post">
                            <div>
                                <span><?php if ($_SESSION['idioma'] == 'pt') { ?>Email<?php } else { ?>Email<?php } ?><label>*</label></span>
                                <input type="email" name="email"> 
                            </div>
                            <div>
                                <span><?php if ($_SESSION['idioma'] == 'pt') { ?>Palavra pass<?php } else { ?>Password<?php } ?><label>*</label></span>
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

