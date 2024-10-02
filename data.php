<?php

session_start();
include 'config.php';

// Delete function 
if (isset($_POST["delete"])) {
 
    $id = $_SESSION['id'];

    $sql = "DELETE FROM register WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if($stmt->execute()){
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }else{
        echo"er is iets fout gegaan";
}

}
// Change function
if (isset($_POST["change"])) {
    $updates = [];
    $params = [];
    $types = "";

// Fields
    $fields = ['username' => 's', 'email' => 's', 'password' => 's'];

    foreach ($fields as $field => $type) {
        if (!empty($_POST[$field])) {
            if ($field === 'password') {

                $hashed_password = password_hash($_POST[$field], PASSWORD_DEFAULT);
                $updates[] = "$field = ?";
                $params[] = $hashed_password;
            } else {
                $updates[] = "$field = ?";
                $params[] = $_POST[$field];
            }
            $types .= $type;
        }
    }

    if (!empty($updates)) {
        $params[] = $_SESSION['id'];
        $types .= "i";
        $sql = "UPDATE register SET " . implode(", ", $updates) . " WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            header("Location: start.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}

$row = array();
if (isset($_SESSION["id"])) {
    $id = $_SESSION["id"];

    // Fetch the user's data from the database
    $sql = "SELECT * FROM register WHERE id = '$id'";
    $result = $conn->query($sql);

    // Display the table only for the logged-in user
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Username</th><th>Email</th><th>Password</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<td>" . $row["username"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } 
 }else {
    echo "error";
}
 $conn->close();

 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Table</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th,td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
           
        }
        label{
            padding: 8px;
            text-align: right;

        }
        .Grid{
            display: grid;
            grid-template-columns: 33%, 33%, 33%;
            grid-template-rows: 33%, 33%, 33%;
            grid-gap: 10px;
            padding: 10px;
        }   
       .Einde{
        padding:5px;
        grid-row: 1;
        grid-columns 2;
       }
       .mooi{
              padding: 10px;
              text-align: center;   
              margin-top : 50px;
       }
    </style>
</head>
<body>

<form action="data.php" method = "POST">
<div class = "mooi">
    <label for="username">Username</label>
    <input type="text" name="username" id="username" >
<br>
<br>
    <label for="email">E-mail</label>
    <input type="email" name="email" id="email">
<br>
<br>
    <label for="password">Password</label>
    <input type="password" name="password" id="password" value = "">
<br>
<br>
<p>Choose what to change</p>
<button type="submit" name="change" value="change" class="Einde">Change</button>
<button type="submit" name="delete" value="delete" class="Einde">Delete</button>

    </div>
</form>
</body>
</html>
</script>
</body>
</html>