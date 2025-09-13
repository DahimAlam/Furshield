<?php
if (session_status() === PHP_SESSION_NONE) session_start();

define('BASE', '/furshield'); 

$DB_HOST = '127.0.0.1';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'furshield';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
$conn->set_charset('utf8mb4');

if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
}

if (!function_exists('rows')) {
  function rows($conn, $query, $params = []) {
    if (empty($params)) {
      $res = $conn->query($query);
    } else {
      $stmt = $conn->prepare($query);
      if (!$stmt) throw new Exception("Prepare failed: ".$conn->error);
      $types = str_repeat("s", count($params));
      $stmt->bind_param($types, ...$params);
      $stmt->execute();
      $res = $stmt->get_result();
    }

    $data = [];
    if ($res) {
      while ($row = $res->fetch_assoc()) {
        $data[] = $row;
      }
    }
    return $data;
  }
}

if (!function_exists('row')) {
  function row($conn, $query, $params = []) {
    $all = rows($conn, $query, $params);
    return $all[0] ?? null;
  }
}
