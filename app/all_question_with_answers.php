<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./img/bars-progress-solid.svg" type="image/svg+xml">
    <title>Detailed List</title>
    <link rel="stylesheet" href="./css/php_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <header><a href="index.php" class="back"><i class="fa-solid fa-arrow-left"></i></a></header>
    <section>
        <?php
        require "db_connect_conf.php";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        $conn->query("SET NAMES 'utf8'");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_GET["id"])) {

            // get form fields
            $id = $conn->real_escape_string($_GET["id"]);

            $sql_query = "UPDATE answers SET votes= votes+1 WHERE id_answer='$id';";

            if (!($conn->query($sql_query))) {
                echo "Error: " . $sql_query . "<br>" . $conn->error;
            }
        }
        ?>

        <?php

        $sql_query = "SELECT q.id_question, q.text as q_text, a.id_answer, a.text as answer_text, a.votes FROM questions q join answers a on a.id_question=q.id_question ;";


        $conn->query("SET NAMES 'utf8'");

        if ($result = $conn->query($sql_query) or die($conn->error)) {
            echo "<dl>";
            $title = 1;
            while ($line = $result->fetch_array(MYSQLI_ASSOC)) {
                if ($title === (int) $line["id_question"]) {
                    echo "<dt>" . $line["q_text"] . "</dt>";
                    $title++;
                }

                echo "<dd>" . $line["answer_text"] .
                    " <a href='all_question_with_answers.php?id=" . $line["id_answer"] . "'><i class='fa-solid fa-thumbs-up'></i> "
                    . $line["votes"] . "</a></dd>";
            }
            echo "</dl>";
        } else {
            echo "Error: " . $sql_query . "<br>" . $conn->error;
        }

        $result->free_result();
        $conn->close();
        ?>
    </section>
</body>

</html>