<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detailed List</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

<?php
    require "db_connect_conf.php";
    if (isset($_GET["id"])) {


        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        //echo "Connected successfully";

        // get form fields
        $id = $conn->real_escape_string($_GET["id"]);

        $sql_query = "UPDATE answers SET votes= votes+1 WHERE id_answer='$id';";

        $conn->query("SET NAMES 'utf8'"); // Data will be send to db server as utf-8
        if (!($conn->query($sql_query))) { 
            echo "Error: " . $sql_query . "<br>" . $conn->error;
        }
        $conn->close();
    }
    ?>

    <?php
    require "db_connect_conf.php";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql_query = "SELECT id_question, text FROM questions;        ";

    
    $conn->query("SET NAMES 'utf8'");

    if ($result = $conn->query($sql_query) or die($conn->error)) {
        //echo "<table>";
        while ($line = $result->fetch_array(MYSQLI_ASSOC)) {
            echo "<h3>" . $line["text"] . "</h3>";
            $id_question = $line["id_question"];
            $sql_query_answers = "SELECT id_answer, text, votes, id_question FROM answers where id_question = '$id_question' ";
            if (!($result_answer = $conn->query($sql_query_answers) or die($conn->error))) {
                echo "Error: " . $sql_query . "<br>" . $conn->error;
            }
            while ($item = $result_answer->fetch_array(MYSQLI_ASSOC)) {
                echo "<p>" . $item["text"] . " <a href='all_question_with_answers.php?id=". $item["id_answer"] ."'>Votes ". $item["votes"] . "</a></p>";
            }
        }
        //echo "</table>";
    } else {
        echo "Error: " . $sql_query . "<br>" . $conn->error;
    }


    $result->free_result();
    $conn->close();
    ?>
    <a href=""></a>
</body>
</html>