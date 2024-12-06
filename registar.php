<?php
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';


        $conn = new mysqli("localhost", "root", "", "8230273");

        if ($conn->connect_error) {
            die("Ligação falhou: " . $conn->connect_error);
        }


        function Encriptar_texto($texto, $chave) {
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
            $encriptado = openssl_encrypt($texto, 'aes-256-cbc', $chave, 0, $iv);
            return base64_encode($iv . $encriptado);
        }

        function gerarToken() {
            return bin2hex(random_bytes(50));//Corresponde a 400 bits
        }

        function gerarChaveDeEncriptacao() {
            return bin2hex(random_bytes(32));//Corresponde a 256 bits
        }

        if(isset($_POST['btn'])){
            // Verificar se as senhas coincidem
            if($_POST['psw'] === $_POST['pswc']){
                // Verificar se todos os campos estão preenchidos
                if($_POST['nome'] != "" and $_POST['email'] != "" and $_POST['psw'] != ""){
                    // Verificar se o email já está registado
                    $stmt_check_email = $conn->prepare("SELECT * FROM utilizadores WHERE email=?");
                    $stmt_check_email->bind_param("s", $_POST['email']);
                    $stmt_check_email->execute();
                    $result_check_email = $stmt_check_email->get_result();

                    if ($result_check_email->num_rows > 0) {
                        echo "<script>alert('Este email já está registado. Por favor, escolha outro.');</script>";
                    } else {
                        $password = $_POST['psw'];
                        if (strlen($password) < 8 && !preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password)) {
                            echo "<script>alert('A senha deve ter pelo menos 8 caracteres e incluir pelo menos um caractere especial.');</script>";
                        }else{
                        $chave_de_encriptacao = gerarChaveDeEncriptacao();
                        $verificacao_token = gerarToken();

                        $password_encriptada = Encriptar_texto($_POST['psw'], $chave_de_encriptacao);

                        $stmt_insert_user = $conn->prepare("INSERT INTO utilizadores (nome, email, password, chave, verificacao_token, verificado, estado) VALUES (?, ?, ?, ?, ?, 0, 1)");
                        $stmt_insert_user->bind_param("sssss", $_POST['nome'], $_POST['email'], $password_encriptada, $chave_de_encriptacao, $verificacao_token);
                        $stmt_insert_user->execute();

                        if ($stmt_insert_user->affected_rows > 0) {
                                $link_de_verificacao = "http://localhost/Projeto_final_si/verify.php?token=$verificacao_token";
                                $subject = "Verificação do Email";
                                $message = '
                                <html>
                                <head>
                                    <title>Verificação do Email</title>
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

                                        .btn-container {
                                            text-align: center;
                                            margin-top: 30px;
                                        }

                                        .btn {
                                            display: inline-block;
                                            padding: 12px 24px;
                                            background-color: #4CAF50;
                                            color: #fff;
                                            text-decoration: none;
                                            border-radius: 5px;
                                            transition: background-color 0.3s;
                                        }

                                        .btn:hover {
                                            background-color: #45a049;
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
                                        <h1>Verificação da conta</h1>
                                        <p>Olá, '.$_POST['nome'].',</p>
                                        <p>Obrigado por se registar! Para concluir o processo de registo, por favor clique no botão abaixo para verificar a sua conta</p>
                                        <div class="btn-container">
                                            <a class="btn" href="' . $link_de_verificacao . '">Verificar Conta</a>
                                        </div>
                                        <p class="note">Por favor, não partilhe a sua chave de desencriptação com mais ninguém: <strong>' . $chave_de_encriptacao . '</strong></p>
                                        <p class="note">Nunca clique em links suspeitos ou forneça as suas informações de login a alguêm.</p>
                                    </div>
                                </body>
                                </html>
                            ';

                                $mail = new PHPMailer(true);
                                try {
                                    // Configurações do servidor
                                    $mail->isSMTP();
                                    $mail->Host = 'smtp.gmail.com';
                                    $mail->SMTPAuth = true;
                                    $mail->Username = 'hugolm280@gmail.com';
                                    $mail->Password = 'uvvm fjvd mabz qegu'; 
                                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                    $mail->Port = 587;
            
                                    // Configurações do email
                                    $mail->setFrom('seu_email@gmail.com', 'No-Reply@projetofinal.pt');
                                    $mail->addAddress($_POST['email']);
                                    $mail->isHTML(true); 
                                    $mail->CharSet = 'UTF-8'; 
                                    $mail->Subject = $subject;
                                    $mail->Body    = $message;
            
                                    $mail->send();
                                    echo "<script>alert('Registo criado com sucesso. Verifique a sua conta para ativá-la.');
                                        </script>";
                                } catch (Exception $e) {
                                    echo "<script>alert('Erro ao enviar o email de verificação. Mailer Error: {$mail->ErrorInfo}');</script>";
                                }
                            echo "<meta http-equiv=\"refresh\" content=\"0; url=?pg=2\">";
                        } else {
                            echo "<script>alert('Erro ao criar o registo');</script>";
                        }

                        $stmt_insert_user->close();
                    }

                }
                    $stmt_check_email->close();
                    $conn->close();
                } else {
                    echo "<script>alert('Dados não preenchidos, por favor preencha todos os campos');</script>";
                }
            } else {
                echo "<script>alert('As senhas não coincidem');</script>";
            }
        }
?>
<!--header-->
<div class="content">
    <!-- registration -->
    <div class="main-1">
        <div class="container">
            <div class="register">
                <form method="post" > 
                    <div class="register-top-grid">
                        <h3><?php if ($_SESSION['idioma'] == 'pt') { ?>Registar<?php } else { ?>Register<?php } ?></h3>
                        <br>
                        <div class="wow fadeInLeft" data-wow-delay="0.4s">
                            <span><?php if ($_SESSION['idioma'] == 'pt') { ?>Nome<?php } else { ?>Name<?php } ?><label>*</label></span>
                            <input type="text" name="nome" required> 
                        </div>
                        <br>
                        <br>
                        <div class="wow fadeInleft" data-wow-delay="0.4s">
                            <span><?php if ($_SESSION['idioma'] == 'pt') { ?>Endereço de e-mail<?php } else { ?>Email Address<?php } ?><label>*</label></span>
                            <input type="email" name="email" required> 
                        </div>
                        <div class="clearfix"> </div>
                        <a class="news-letter" >
                        </a>
                    </div>
                    <div class="register-bottom-grid">

                        <div class="wow fadeInLeft" data-wow-delay="0.4s">
                            <span><?php if ($_SESSION['idioma'] == 'pt') { ?>Palavra pass<?php } else { ?>Password<?php } ?><label>*</label></span>
                            <input type="password" name="psw" id="password" onkeyup="checkPasswordStrength()" required>
                            <div id="password-strength">
                                <div id="strength-bar"></div>
                            </div>
                        </div>
                        <div class="wow fadeInRight" data-wow-delay="0.4s">
                            <span><?php if ($_SESSION['idioma'] == 'pt') { ?>Confirmar palavra pass<?php } else { ?>Confirm Password<?php } ?><label>*</label></span>
                            <input type="password" name="pswc" required> 
                        </div>
                    </div>

                    <div class="clearfix"> </div>
                    <div class="register-but">
                        <input class="subscribe1" type="submit" name="btn" value="submit">
                        <div class="clearfix"> </div>
                </form>
            </div>
        </div>
        <style>
    #password-strength {
        width: 100%;
        background-color: #ddd;
        margin-top: 5px;
        border-radius: 5px;
        overflow: hidden;
    }
    #strength-bar {
        width: 0;
        height: 10px;
        background-color: red;
        border-radius: 5px;
        transition: width 0.3s ease, background-color 0.3s ease;
    }
</style>
    </div>
</div>
<script>
    function checkPasswordStrength() {
        var password = document.getElementById('password').value;
        var strengthBar = document.getElementById('strength-bar');
        var strength = 0;

        if (password.length >= 8) strength += 1;
        if (password.match(/[a-z]+/)) strength += 1;
        if (password.match(/[A-Z]+/)) strength += 1;
        if (password.match(/[0-9]+/)) strength += 1;
        if (password.match(/[\W]+/)) strength += 1;

        switch(strength) {
            case 0:
                strengthBar.style.width = '0%';
                strengthBar.style.backgroundColor = 'red';
                break;
            case 1:
                strengthBar.style.width = '20%';
                strengthBar.style.backgroundColor = 'red';
                break;
            case 2:
                strengthBar.style.width = '40%';
                strengthBar.style.backgroundColor = 'orange';
                break;
            case 3:
                strengthBar.style.width = '60%';
                strengthBar.style.backgroundColor = 'yellow';
                break;
            case 4:
                strengthBar.style.width = '80%';
                strengthBar.style.backgroundColor = 'lightgreen';
                break;
            case 5:
                strengthBar.style.width = '100%';
                strengthBar.style.backgroundColor = 'green';
                break;
        }
    }
</script>

<!-- registration -->
</div>