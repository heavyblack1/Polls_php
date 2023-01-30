<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    require "db_connect_conf.php";
    if (isset($_POST["text"])) {


        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        //echo "Connected successfully";

        // get form fields
        $text = $conn->real_escape_string($_POST["text"]);
        $id = $conn->real_escape_string($_GET["id"]);

        $sql_query = "INSERT INTO answers (text, votes, id_question) VALUES('$text', 0, '$id');";

        $conn->query("SET NAMES 'utf8'"); // Data will be send to db server as utf-8

        if ($conn->query($sql_query)) {
            echo "New record created successfully";
        } else {
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

    // get id from url
    $id = $conn->real_escape_string($_GET["id"]);

    $sql_query = "SELECT id_answer, a.text as answer_text, votes, a.id_question,q.text as q_text  FROM answers a left join questions as q ON a.id_question = q.id_question WHERE a.id_question = '$id';";

    $conn->query("SET NAMES 'utf8'");

    if ($result = $conn->query($sql_query) or die($conn->error)) {
        $title= 0;
        while ($line = $result->fetch_array(MYSQLI_ASSOC)) {
            if ($title === 0) {
                echo "<h1>Question ". $id . " : " . $line["q_text"] . "</h1>";
                $title++;
            }
            echo "<p>" . $line["answer_text"] . "</p>";
        }
    } else {
        echo "Error: " . $sql_query . "<br>" . $conn->error;
    }
    $conn->close();
    ?>
    <section>
        <h2>Answer:</h2>
        <form method="POST" class="form-block">
            <label for="text-answer">Write answer:</label>
            <textarea name="text" id="text-answer"></textarea>
            <input type="submit" value="Insert">
        </form>
    </section>

    <a href="index.php">Back</a>
</body>

</html>