<?php 
require '../db_conn.php';

global $mysqli;

$idFood = $_GET['idFood'];
$sql = "UPDATE userdb SET nameFood=?, priceFood = ?, foodType = ? WHERE idFood = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $idFood);
$stmt->execute();
header('location: menu.php');