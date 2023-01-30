<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
<?php
require "db_connect_conf.php";
if (isset($_POST["question"])) {
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";

// get form fields
$question = $conn->real_escape_string($_POST["question"]);

$sql_query ="INSERT INTO questions (text) VALUES('$question')";

$conn->query("SET NAMES 'utf8'"); // Data will be send to db server as utf-8

if (!($conn->query($sql_query))) {
  echo "Error: " . $sql_query . "<br>" . $conn->error;
}

$conn->close(); 
}
?>
    <section>
        <h1>Polls System</h1>
        <hr>
    </section>

    <section>
        <h2>Polls List</h2>
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
            while ($line = $result->fetch_array(MYSQLI_ASSOC)) {
                echo "<h3>" . $line["text"] . "</h3>";
            }
        } else {
            echo "Error: " . $sql_query . "<br>" . $conn->error;
        }


        $result->free_result();
        $conn->close();
        ?>

        <a href="all_question_with_answers.php">Detailed List</a>
    </section>
    <section>
        <h2>ADD Poll question</h2>
        <form method="POST" class="form-block">
            <label for="text-question">Question:</label>
            <textarea name="question" id="text-question"></textarea>
            <input type="submit" value="Insert">
        </form>
    </section>


    <section>
        <h2>Questions List</h2>
        <?php
        require "db_connect_conf.php";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql_query = "SELECT id_question, text FROM questions;";

        $conn->query("SET NAMES 'utf8'");

        if ($result = $conn->query($sql_query) or die($conn->error)) {
            while ($line = $result->fetch_array(MYSQLI_ASSOC)) {
                echo "<h3>" . $line["text"] . "</h3>";
                echo "<p><a href='question_detail.php?id=" . $line["id_question"] . "'>Answers</a></p>";
            }
        } else {
            echo "Error: " . $sql_query . "<br>" . $conn->error;
        }


        $result->free_result();
        $conn->close();
        ?>
    </section>

</body>

</html>