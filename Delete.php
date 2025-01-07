<?php
include 'config_2.php';

$ProductID = $_POST['productID'];
$locatie = $_POST['locatie'];

if (in_array($locatie, [1, 2, 3, 13])) {
    $stmt = $conn->prepare("DELETE FROM Voorraad WHERE idArtikel = ? AND idLocatie = ?");
    $stmt->bind_param("ii", $ProductID, $locatie);
    $stmt->execute();
    $stmt->close();
}

if ($locatie == 0) {
    $sql = "DELETE FROM Voorraad WHERE idArtikel = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ProductID);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM Artikel WHERE idArtikel = ?");
    $stmt->bind_param("i", $ProductID);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: Tools.php");
exit();
?>
