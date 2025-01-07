<?php

include 'config_2.php';

error_reporting(0);

$search = $_POST['searchQuery'];

if(!empty($search)){
$sql = "SELECT * FROM Artikel
Left join Voorraad on Artikel.idArtikel = Voorraad.idArtikel
left join Locatie on Voorraad.idLocatie = Locatie.idLocatie
WHERE LocatieNaam = ?;";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $search);
$stmt->execute();
$result = $stmt->get_result();
}else{
$sql = "SELECT * FROM Artikel
Left join Voorraad on Artikel.idArtikel = Voorraad.idArtikel
left join Locatie on Voorraad.idLocatie = Locatie.idLocatie;";

$result = $conn->query($sql);
}
  // Start the table and header row with CSS class

  echo "<table class='styled-table'>";
  echo "<thead>";
  echo "<tr>
          <th>Naam</th>
          <th>Type</th>
          <th>Fabriek</th>
          <th>Waarde Inkoop</th>
          <th>Waarde Verkoop</th>
          <th>Locatie</th>
          <th>Aantal</th>
            </tr>";
  echo "</thead>";
  echo "<tbody>";
    // Display the table only for the logged-in user
    if ($result->num_rows > 0) {
    echo "<form action='Tools.php' method= 'POST'>";
        while ($row = $result->fetch_assoc()){
          
    ?>
  
      
      <tr>

     <td><input type = 'text' name = 'naam' id = 'naam'  value= '<?php echo $row["naam"] ?>' disabled></td>
     <td><input type = 'text' name = 'type' id = 'type' value= '<?php echo $row["type"] ?>' disabled></td>
      <td><input type = 'text' name = 'fabriek'id = 'fabriek'  value= '<?php echo $row["fabriek"] ?>' disabled></td>
        <td><input type = 'text' name = 'waarde_inkoop'id = 'waarde_inkoop'  value= '<?php echo $row["waarde_inkoop"] ?>' disabled></td>
          <td><input type = 'text' name = 'waarde_verkoop'id = 'waarde_verkoop'  value= '<?php echo $row["waarde_verkoop"] ?>' disabled></td>
          <td><input type = 'text' name = 'locatie' value= '<?php echo $row["locatieNaam"] ?>' disabled></td>
            <td><input type = 'text' name = 'aantal' value= '<?php echo $row["aantal"] ?>' disabled></td>    
     </tbody>
     <?php
    }

   echo "</form>";
       echo "</table>";
    }else {
    echo "error";
}

 $conn->close();  

?>

