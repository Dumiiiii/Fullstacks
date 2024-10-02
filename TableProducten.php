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
          <th>Actions</th>
        </tr>";
  echo "</thead>";
  echo "<tbody>";
    // Display the table only for the logged-in user
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()){

        echo "<tr>";
        echo "<td>" . $row["naam"] . "</td>";
        echo "<td>" . $row["type"] . "</td>";
        echo "<td>" . $row["fabriek"] . "</td>";
        echo "<td>" . $row["waarde_inkoop"] . "</td>";
        echo "<td>" . $row["waarde_verkoop"] . "</td>";
        echo "<td>" . $row["locatie"] . "</td>";
        echo "<td>" . $row["aantal"] . "</td>";
        echo "<td>
        <a href='editButton.php?idArtikel=".$row['idArtikel']."'>Edit</a></td>
    </td>";
        echo "</tr>";
        echo "</tbody>";
    }

        
        echo "</table>";
    }else {
    echo "error";
}
 $conn->close();
 ?>