<?php

require("../../common/auth.php");
require("../../common/database.php");

if (!isLogin()) {
  header("Location: ../../login/index.php");
  exit;
}

$edit_id = $_POST["edit_id"];
$edit_title = $_POST["edit_title"];
$edit_content = $_POST["edit_content"];

$user_id = getLoginUserId();

$pdo = getDatabaseConnection();

try {
  // 更新処理
  if ($stmt = $pdo->prepare("UPDATE memos SET title = :title, content = :content, updated_at = NOW() WHERE id = :edit_id AND user_id = :user_id")) {
    $stmt->bindParam(":title", htmlspecialchars($edit_title));
    $stmt->bindParam(":content", htmlspecialchars($edit_content));
    $stmt->bindParam(":edit_id", $edit_id);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();
  }

  // 更新したデータを取得する
  if ($stmt = $pdo->prepare("SELECT id, title, content FROM memos WHERE id = :edit_id AND user_id = :user_id")) {
    $stmt->bindParam(":edit_id", $edit_id);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();
  }
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  // セッションに格納する
  $_SESSION["select_memo"] = [
    "id" => $result["id"],
    "title" => $result["title"],
    "content" => $result["content"]
  ];

} catch (Throwable $e) {
  echo $e->getMessage();
  exit;
}

header("Location: ../index.php");
exit;


?>