<?php
session_start();

if (isset($_POST['verify_btn'])) {
    $codigo_digitado = $_POST['verification_code'];
    $codigo_sessao = $_SESSION['codigo_de_verificacao'];
    $email_sessao = $_SESSION['email_verificacao'];

    if ($codigo_digitado == $codigo_sessao) {
        echo "<script>alert('Login realizado com sucesso');</script>";
                if ($_SESSION['id_tipo'] == 0) {
                    echo "<meta http-equiv=\"refresh\" content=\"0; url=admin/index.php?id_ad=" . $_SESSION['id'] . "\" >";
                } else {
                    echo "<meta http-equiv=\"refresh\" content=\"0; url=outra_pagina.php\">";
                }
    } else {
        // O código está incorreto
        echo "<script>alert('Código de verificação incorreto!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verificação de Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        label {
            display: block;
            color: #666;
            margin-bottom: 10px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="post" action="verify_login.php">
            <h2>Verificação de Login</h2>
            <label for="verification_code">Código de Verificação:</label>
            <input type="text" name="verification_code" id="verification_code" required>
            <br>
            <input type="submit" name="verify_btn" value="Verificar">
        </form>
    </div>
</body>
</html>
