<?php
// DBファイル読み込み
require("../../common/database.php");

// パラメータ取得
$user_name = $_POST["user_name"];
$user_email = $_POST["user_email"];
$user_password = $_POST["user_password"];



// DB接続
$pdo = getDatabaseConnection();

try {
  // ユーザーの登録処理
  if ($stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)")) {
    $password = password_hash($user_password, PASSWORD_DEFAULT);

    $stmt->bindParam(":name", htmlspecialchars($user_name));
    $stmt->bindParam(":email", $user_email);
    $stmt->bindParam(":password", $password);
    $stmt->execute();
  }
} catch (Throwable $e) {
  echo $e->getMessage();
  // header("Location: ../../test2.php");
  exit;
}

// メモ投稿画面にリダイレクト
header("Location: ../../memo/index.php");
exit;

?>