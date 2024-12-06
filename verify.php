<?php
$conn = new mysqli("localhost", "root", "", "8230273");

if ($conn->connect_error) {
    die("Ligação falhou: " . $conn->connect_error);
}

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $conn->prepare("SELECT id FROM utilizadores WHERE verificacao_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $stmt->close();

        $stmt = $conn->prepare("UPDATE utilizadores SET verificado = 1, verificacao_token = NULL WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Conta verificada com sucesso.');
            setTimeout(function() {
                window.close();
                }, 500);</script>";
        } else {
            echo "<script>alert('Erro ao verificar a Conta.');
            setTimeout(function() {
                window.close();
                }, 500);
            </script>";
        }
    } else {
        echo "<script>alert('Token inválido ou expirado.');
        setTimeout(function() {
            window.close();
            }, 500);
            </script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Token não fornecido.');
    setTimeout(function() {
        window.close();
        }, 500);
    </script>";
}
?>
