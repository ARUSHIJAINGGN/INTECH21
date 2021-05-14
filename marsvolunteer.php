<?php
    if (isset($_POST['name']) && isset($_POST['email']) &&
        isset($_POST['phone']) && isset($_POST['age']) &&
        isset($_POST['gender']) && isset($_POST['country'])) {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $country= $_POST['country'];

        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "mysql";

        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT email FROM volunteer WHERE email = ? LIMIT 1";
            $Insert = "INSERT INTO volunteer(name, email, phone, age, gender, country) values(?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $stmt->close();

                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("ssiiss",$name, $email, $phone, $age, $gender, $country);
                if ($stmt->execute()) {
                    header( "refresh:5;url=http://localhost/INTECH-IT/nasa-home.html" );
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this email.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }

?>
