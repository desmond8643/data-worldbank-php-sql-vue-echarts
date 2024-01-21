<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, X-Requested-With, Accept");

$pdo = new PDO('sqlite:gdp.db');
$statement = $pdo->query("SELECT * FROM gdp");
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json'); 

echo json_encode($rows); 