<?php
require("../../common/auth.php");
require("../../common/database.php");

if (!isLogin()) {
  header("Location: ../../login/index.php");
  exit;
}

$id = $_GET["id"];
$user_id = getLoginUserId();

$pdo = getDatabaseConnection();
if ($stmt = $pdo->prepare("SELECT id, title, content FROM memos WHERE id = :id AND user_id = :user_id")) {
  $stmt->bindParam(":id", $id);
  $stmt->bindParam(":user_id", $user_id);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);
}

$_SESSION["select_memo"] = [
  "id" => $result["id"], // 選択したメモのID
  "title" => $result["title"], // 選択したメモのタイトル
  "content" => $result["content"] // 選択したメモの本文
];

// echo "<pre>";
// var_dump($_SESSION["select_memo"]);
// echo "<pre>";

header("Location: ../index.php");
exit;




?>