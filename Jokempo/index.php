<?php

$jogador = "";
$computador = "";
$resultado = "";

function verificarResultado($jogador, $computador)
{

    if ($jogador == $computador) {
        return "Empate";
    }

    if (
        ($jogador == "Pedra" && $computador == "Tesoura") ||
        ($jogador == "Papel" && $computador == "Pedra") ||
        ($jogador == "Tesoura" && $computador == "Papel")
    ) {
        return "Você venceu!";
    }

    return "Computador venceu!";

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $jogador = $_POST["jogada"];

    $rand = rand(1, 3);

    switch ($rand) {

        case 1:
            $computador = "Pedra";
            break;

        case 2:
            $computador = "Papel";
            break;

        case 3:
            $computador = "Tesoura";
            break;

    }

    $resultado = verificarResultado($jogador, $computador);

}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <title>Jokempô</title>

    <style>
        body {
            font-family: Arial;
            background: #eef2f5;
            text-align: center;
        }

        .container {
            width: 500px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        button {
            padding: 10px 20px;
            margin: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .pedra {
            background: #aaa;
        }

        .papel {
            background: #4CAF50;
            color: white;
        }

        .tesoura {
            background: #ff5252;
            color: white;
        }

        .resultado {
            margin-top: 20px;
            font-size: 20px;
            font-weight: bold;
        }

        img {
            width: 120px;
        }
    </style>

</head>

<body>

    <div class="container">

        <h1>Jogo Jokempô</h1>

        <form method="POST">

            <button class="pedra" name="jogada" value="Pedra">🪨 Pedra</button>

            <button class="papel" name="jogada" value="Papel">📄 Papel</button>

            <button class="tesoura" name="jogada" value="Tesoura">✂️ Tesoura</button>

        </form>

        <?php if ($jogador != "") { ?>

            <div class="resultado">

                <p><b>Jogador:</b>
                    <?php echo $jogador ?>
                </p>

                <p><b>Computador:</b>
                    <?php echo $computador ?>
                </p>

                <p>Resultado:
                    <?php echo $resultado ?>
                </p>

            </div>

            <form>
                <button onclick="location.reload()">Jogar novamente</button>
            </form>

        <?php } ?>

    </div>

</body>

</html>