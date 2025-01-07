<?php
error_reporting(0);
require 'config_2.php';

$Besteldatum = $_POST['Besteldatum'];
$Leverdatum = $_POST['Leverdatum'];
$locatie = $_POST['locatie'];
$Afgeleverd = $_POST['Afgeleverd'];

if(isset($Besteldatum) && isset($Leverdatum) && isset($locatie) && isset($Afgeleverd)){
  $stmt = $conn->prepare("INSERT INTO Bestelling (BestelDatum, LeverDatum, idLocatie, Afgelevered) values (?, ?, ?, ?)");
  $stmt->bind_param("ssis", $Besteldatum, $Leverdatum, $locatie, $Afgeleverd);
  $stmt->execute();
  $stmt->close();
  $conn->close();
}
?>
<a href="Tools.php">EXIT</a>
<link rel="stylesheet" href="stylesheet.css">

<form action="Bestelijst.php" method="POST">
  <label for="Besteldatum">Besteldatum</label>
  <input type="date" id="Besteldatum" name="Besteldatum" required>

  <label for="Leverdatum">Leverdatum</label>
  <input type="date" id="Leverdatum" name="Leverdatum" required>

  <label for="locatie">Locatie</label>
  <select name="locatie">
    <option value="">-</option>
    <option value="13">Amsterdam</option>
    <option value="3">Rotterdam</option>
    <option value="2">Eindhoven</option>
    <option value="1">Almere</option>
  </select>

  <label for="Afgeleverd">Afgeleverd</label>
  <Select name="Afgeleverd">
    <option value="">-</option>
    <option value="nee">Nee</option>
    <option value="ja">Ja</option>
  </Select>

  <button name="submit" type="submit">Submit</button>
</form>

<form action="Bestelijst.php" method="POST">
  <label for="BestelingID">Select Besteling ID</label>
  <select name="BestelingID" required>
    <option value="">-</option>
    <?php
    $bestellingResult = $conn->query("SELECT idBestelling FROM Bestelling");
    while ($bestellingRow = $bestellingResult->fetch_assoc()) {
      echo "<option value='" . $bestellingRow['idBestelling'] . "'>" . $bestellingRow['idBestelling'] . "</option>";
    }
    ?>
  </select><br>

  <label for="BestelProduct">ID van Product</label>
  <select name="BestelProduct" required>
    <option value="">-</option>
    <?php
    $productResult = $conn->query("SELECT idArtikel, naam FROM Artikel");
    while ($productRow = $productResult->fetch_assoc()) {
      echo "<option value='" . $productRow['idArtikel'] . "'>" . $productRow['idArtikel'] . " - " . $productRow['naam'] . "</option>";
    }
    ?>
  </select><br>

  <label for="BestelAantal">BestelAantal</label>
  <input type="number" name="BestelAantal" required><br>
  <button name="submit" type="submit">Submit</button>
</form>

<?php
$bestelID = $_POST['BestelingID'];
$BestelProduct = $_POST['BestelProduct'];
$BestelAantal = $_POST['BestelAantal'];

if(isset($bestelID) && isset($BestelProduct) && isset($BestelAantal)){
  $stmt = $conn->prepare("INSERT INTO Bestelling_has_Artikel (Bestelling_idBestelling, Artikel_idArtikel, aantal) values (?, ?, ?)");
  $stmt->bind_param("iii", $bestelID, $BestelProduct, $BestelAantal);
  $stmt->execute();
  $stmt->close();
  $conn->close();
}
?>

<?php
require 'config_2.php'; // Reopen the connection

$sql = "SELECT * FROM Bestelling
LEFT JOIN Locatie on Bestelling.idLocatie = Locatie.idLocatie
LEFT JOIN Bestelling_has_Artikel on Bestelling.idBestelling = Bestelling_has_Artikel.Bestelling_idBestelling
LEFT JOIN Artikel on Bestelling_has_Artikel.Artikel_idArtikel = Artikel.idArtikel
ORDER BY Bestelling.idBestelling";

$result = $conn->query($sql);

$currentBestelling = null;

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    if ($currentBestelling !== $row['idBestelling']) {
      if ($currentBestelling !== null) {
        echo "</tbody></table>";
      }
      $currentBestelling = $row['idBestelling'];
      echo "<h2>Bestelling: " . $currentBestelling . "</h2>";
      echo "<table class='styled-table'>";
      echo "<thead>";
      echo "<tr>
          <th>Naam</th>
          <th>Type</th>
          <th>Fabriek</th>
          <th>Besteldatum</th>
          <th>Leverdatum</th>
          <th>Locatie</th>
          <th>Aantal</th>
          <th>Afgeleveerd</th>
          </tr>";
      echo "</thead>";
      echo "<tbody>";
    }
    ?>
    <tr>
      <td><input type='text' name='naam' value='<?php echo $row["naam"] ?>' disabled></td>
      <td><input type='text' name='type' value='<?php echo $row["type"] ?>' disabled></td>
      <td><input type='text' name='fabriek' value='<?php echo $row["fabriek"] ?>' disabled></td>
      <td><input type='text' name='BestelDatum' value='<?php echo $row["BestelDatum"] ?>' disabled></td>
      <td><input type='text' name='LeverDatum' value='<?php echo $row["LeverDatum"] ?>' disabled></td>
      <td><input type='text' name='locatie' value='<?php echo $row["locatieNaam"] ?>' disabled></td>
      <td><input type='text' name='aantal' value='<?php echo $row["aantal"] ?>' disabled></td>
      <td><input type='text' name='Afgeleverd' value='<?php echo $row["Afgelevered"] ?>' disabled></td>
    </tr>
    <?php
  }
  echo "</tbody></table>";
} else {
  echo "No records found.";
}

$conn->close();
?>