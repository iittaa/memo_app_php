<?php
const DB_HOST = "mysql:host=db;dbname=memo_app;charset=utf8mb4";
const DB_USER = "root";
const DB_PASSWORD = "password";


function getDatabaseConnection(){
  try {
    // データベース接続処理
    $pdo = new PDO(DB_HOST, DB_USER, DB_PASSWORD);
  } catch (PDOException $e) {
    // 失敗時の処理
    echo "DBの接続に失敗しました。" . PHP_EOL;
    echo $e->getMessage();
    exit;
  };
  return $pdo;
}


?>