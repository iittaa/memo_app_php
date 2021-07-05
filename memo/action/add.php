<?php
require("../../common/auth.php");
require("../../common/database.php");

if (!isLogin()) {
  header("Location: ../../login/index.php");
  exit;
}

$user_id = getLoginUserId();
$pdo = getDatabaseConnection();

try {
  $title = "新規メモ";
  if ($stmt = $pdo->prepare("INSERT INTO memos (user_id, title, content) VALUES(:user_id, :title, null)")) {
    $stmt->bindParam(":user_id", $user_id);
    $stmt->bindParam(":title", $title);
    $stmt->execute();
  }
  $_SESSION["select_memo"] = [
    "id" => $pdo->lastInsertId(),
    "title" => $title,
    "content" => ""
  ];
} catch (Throwable $e) {
  echo $e->getMessage();
  exit;
}
header("Location: ../index.php");

?>