<?php
header('Access-Control-Allow-Origin: *'); // Zezwala na dostęp z dowolnej domeny
header('Access-Control-Allow-Methods: GET, POST'); // Zezwala na metody GET i POST
header('Access-Control-Allow-Headers: Content-Type'); // Zezwala na nagłówek Content-Type

$mysql_server = "mysql8";
$mysql_pass = "Alfa8Demo6";
$mysql_admin = "39278584_panel";
$mysql_db = "39278584_panel";


try {
    $pdo = new PDO("mysql:host=$mysql_server;dbname=$mysql_db", $mysql_admin, $mysql_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['browser'], $data['operating_system'])) {
  $browser = $data['browser'];
  $operating_system = $data['operating_system'];

  // Przygotowanie zapytania SQL do dodania danych do bazy
  $sql = "INSERT INTO user_data (browser, operating_system) VALUES (:browser, :operating_system)";
  $stmt = $pdo->prepare($sql);
  
  // Wstawianie danych do bazy
  $stmt->bindParam(':browser', $browser);
  $stmt->bindParam(':operating_system', $operating_system);
  $stmt->execute();

  // Odpowiedź sukcesu
  echo json_encode(['status' => 'success', 'message' => 'Dane zostały zapisane']);
} else {
  // W przypadku braku danych
  echo json_encode(['status' => 'error', 'message' => 'Brak wymaganych danych']);
}