<?php
$titulo = "";
$premio = "";
$valor = "";
$qtd = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $premio = $_POST["premio"];
    $valor = $_POST["valor"];
    $qtd = $_POST["quantidade"];
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Gerador de Rifas</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f6f8;
            text-align: center;
        }

        .container {
            width: 900px;
            margin: auto;
        }

        form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        input {
            padding: 10px;
            margin: 10px;
            width: 200px;
        }

        button {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        .bilhetes {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .bilhete {
            width: 200px;
            border: 2px dashed #333;
            margin: 10px;
            padding: 10px;
            background: white;
        }

        .numero {
            font-size: 22px;
            font-weight: bold;
        }

        .print {
            margin-top: 20px;
            background: green;
        }

        @media print {

            form,
            .print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <h1>Gerador de Rifas</h1>

        <form method="POST">

            <input type="text" name="titulo" placeholder="Nome da Campanha" required>

            <input type="text" name="premio" placeholder="Prêmio" required>

            <input type="number" step="0.01" name="valor" placeholder="Valor do Bilhete" required>

            <input type="number" name="quantidade" placeholder="Quantidade de Bilhetes" required>

            <br>

            <button type="submit">Gerar Rifas</button>

        </form>

        <div class="bilhetes">

            <?php

            for ($i = 1; $i <= $qtd; $i++) {

                $numero = str_pad($i, 3, "0", STR_PAD_LEFT);

                echo "
<div class='bilhete'>

<h3>$titulo</h3>

<p><b>Prêmio:</b> $premio</p>

<p><b>Valor:</b> R$ $valor</p>

<div class='numero'>$numero</div>

</div>
";

            }

            ?>

        </div>

        <?php if ($qtd > 0) { ?>

            <button class="print" onclick="window.print()">Imprimir Bilhetes</button>

        <?php } ?>

    </div>

</body>

</html>