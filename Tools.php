<?php
include 'config_2.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['submit'])) {
        // Get form data
        $Naam = $_POST["naam"];
        $Type = $_POST["type"];
        $Fabriek = $_POST["fabriek"];
        $Waarde_inkoop = $_POST["waarde_inkoop"];
        $Waarde_verkoop = $_POST["waarde_verkoop"];

        // Prepare the SQL query with placeholders
        $sql = "INSERT INTO Artikel (naam, type, fabriek, waarde_inkoop, waarde_verkoop) VALUES (?,?,?,?,?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing the query: " . $conn->error);
        }

        // Bind the parameters (sssdd -> string, string, string, double, double)
        $stmt->bind_param("sssdd", $Naam, $Type, $Fabriek, $Waarde_inkoop, $Waarde_verkoop,);

        // Execute the query
        if ($stmt->execute()) {
            // After form submission, redirect to avoid resubmission on reload
            header("Location: Tools.php");
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







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="stylesheet.css">

    <p>ToolsforEver - Product Form</p>
    <a href="">Bestelling</a>
    <?php include 'search.php' ?>
</head>
<body>
   <div class="grid-container">
        
   <div class = 'mid'>
<?php include 'TableProducten.php' ?>

</div>



  <div class = "links">
       <form action="Tools.php" method="POST">
        
    
           <label for="naam">Naam</label>
           <input type="text" id="naam" name="naam" placeholder="Enter product name" required>

           <label for="type">Type</label>
           <input type="text" id="type" name="type" placeholder="Enter product type" required>

           <label for="fabriek">Fabriek</label>
           <input type="text" id="fabriek" name="fabriek" placeholder="Enter fabriek name" required>

           <label for="waarde inkoop">Waarde inkoop</label>
           <input type="number" step="0.01" id="waarde_inkoop" name="waarde_inkoop" placeholder="Enter purchase value" required>

           <label for="waarde verkoop">Waarde verkoop</label>
           <input type="number" step="0.01" id="waarde_verkoop" name="waarde_verkoop" placeholder="Enter selling value" required>


           <button name = "submit" type="submit">Submit</button>
       </form>
       </div>

       <div class= 'rechts'>
        <form action = "deleteButton.php" method = "POST">
            <label for="Naam">Verwijderen</label>
            <input type="text" id="Naam" name="Naam" placeholder="Product name" required>
            <input type="text" id = "Locatie" name = "Locatie" placeholder = "Product locatie">
            <input name = "delete" type = "submit" id = "delete" value="Delete">
         </form>
         </div>
        

</body>
</html>
