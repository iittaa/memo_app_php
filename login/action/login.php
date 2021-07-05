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
    
    // 最新更新のメモの情報を保持する
    if ($stmt = $pdo->prepare("SELECT id, title, content FROM memos WHERE user_id = :user_id ORDER BY updated_at DESC LIMIT 1")) {
      $stmt->bindParam(":user_id", $id);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($result) {
        $_SESSION["select_memo"] = [
          "id" => $result["id"],
          "title" => $result["title"],
          "content" => $result["content"]
        ];
      }
    }
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