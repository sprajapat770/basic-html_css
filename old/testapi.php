<?php

// Create connection
$conn = new mysqli("localhost", "a92c734d_vikram", "GrantSlylyFlukyWolf","a92c734d_vikram");
// Check connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM `admin_user`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result-> fetch_all();
  /*  while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]."<br>";
    }*/
echo json_encode($row);
} else {
    echo "0 results";
}
$conn->close();



