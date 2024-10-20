<?php
include 'config_2.php';

// Fetch the idArtikel values from the database    
$sql = "SELECT idArtikel FROM Artikel";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sql = "SELECT * FROM Artikel
    Left join Voorraad on Artikel.idArtikel = Voorraad.Artikel_idArtikel
    left join Locatie on Voorraad.Locatie_idLocatie = Locatie.idLocatie;";
    
    if (isset($_POST['submit'])) {
        // Get form data
        $ID = $_POST["id"];
        $Locatie = $_POST["locatie"];
        $Aantal = $_POST["aantal"];

        // Prepare the SQL query with placeholders
        $sql = "UPDATE Voorraad SET Aantal = ? WHERE Artikel_idArtikel = ? AND Locatie_idLocatie = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing the query: " . $conn->error);
        }

        // Bind the parameters 
        $stmt->bind_param("iss", $ID, $Locatie, $Aantal);

        // Execute the query
        if ($stmt->execute()) {
            // After form submission, redirect to avoid resubmission on reload
            header("Location: ToolsChange.php");
            exit(); // Ensure no further code is executed after the redirect
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>

<link rel="stylesheet" href="stylesheet.css">
<p>Voorraad</p>
<div class="mid">
    <form action="ToolsChange.php" method="POST">
        <label for="id">ID</label>
        <select name="id">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    foreach ($row as $iets) {
                        echo "<option value='$iets'>$iets</option>";
                    }
                }
            }
            ?>
        </select>
        <label for="locatie">Locatie</label>
        <select name="locatie">
            <option value="Amsterdam">Amsterdam</option>
            <option value="Rotterdam">Rotterdam</option>
            <option value="Utrecht">Utrecht</option>
            <option value="Almere">Almere</option>
        </select>
        <label for="aantal">Aantal</label>
        <input type="number" id="aantal" name="aantal" placeholder="Hoeveelheid" required>
        <button name="submit" type="submit">Submit</button>
    </form>
</div>
