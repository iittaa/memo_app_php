<?php
session_start();

require("../../common/database.php");
require("../../common/validation.php");

$user_email = $_POST["user_email"];
$user_password = $_POST["user_password"];

// バリデーション
// $_SESSION["errors"] = validation($_POST);

// if (!empty($_SESSION["errors"])) {
//   header("Location: ../../login/index.php");
//   exit;
// }

// ログイン処理
$pdo = getDatabaseConnection();
if ($stmt = $pdo->prepare("SELECT id, name, password FROM users WHERE email = :user_email")) {
  $stmt->bindParam(":user_email", $user_email);
  $stmt->execute();

  // カラム名のみ取得？
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$user) {
    $_SESSION["errors"] = [
      "メールアドレスもしくはパスワードが間違っています。"
    ];
    header("Location: ../index.php");
    exit;
  }

  $name = $user["name"];
  $id = $user["id"];
  $password = $user["password"];

  if (password_verify($user_password, $password)) {
    $_SESSION["user"] = [
      "name" => $name,
      "id" => $id
    ];
    header("Location: ../../memo/index.php");
    exit;
  } else {
    $_SESSION["errors"] = [
      "メールアドレスもしくはパスワードが間違っています。"
    ];
    header("Location: ../index.php");
    exit;
  }




}


?>