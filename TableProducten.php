<?php

include 'config_2.php';

$sql = "SELECT * FROM Artikel
Left join Voorraad on Artikel.idArtikel = Voorraad.Artikel_idArtikel
left join Locatie on Voorraad.Locatie_idLocatie = Locatie.idLocatie;";

$result = $conn->query($sql);
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
          <th>Submit</th>
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
          <td><input type = 'text' name = 'locatie' value= '<?php echo $row["locatie"] ?>' disabled></td>
            <td><input type = 'text' name = 'aantal' value= '<?php echo $row["aantal"] ?>' disabled></td>
            <td>
              <!-- <button name = 'update' type = 'submit' id = 'update' onclick = "update()"  value= '<?php echo $row["idArtikel"] ?>'>Update</button> -->
              <button name = 'delete' type = 'submit' id = 'delete' value= '<?php echo $row["idArtikel"] ?>'>Delete</button>
            </td>    
          </tr>
  
         </tr>
     </tbody>
     <?php
    }

   echo "</form>";
       echo "</table>";
    }else {
    echo "error";
}

 $conn->close();


 
 ?>`
 <button name = 'update' type = 'submit' id = 'update' onclick = "update()"  value= '<?php echo $row["idArtikel"] ?>'>Update</button>
 <script>
                function update() {
                    document.getElementById('naam').disabled = false;
                    document.getElementById('type').disabled = false;
                    document.getElementById('fabriek').disabled = false;
                    document.getElementById('waarde_inkoop').disabled = false;
                    document.getElementById('waarde_verkoop').disabled = false;
                }
              </script>