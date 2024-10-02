<?php
require_once 'config_2.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $naam = $_POST['Naam'];

        $stmt = $conn->prepare("DELETE FROM Artikel WHERE Naam = ?");
       
            $stmt->bind_param("s", $naam);

            // Execute the prepared statement
            $stmt->execute();

                header("Location: Tools.php");
                exit();
    $conn->close();
    $stmt->close(); 
}
?>