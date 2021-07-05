<?php

require("../../common/auth.php");
require("../../common/database.php");

if (!isLogin()) {
  header("Location: ../../login/index.php");
  exit;
}

$edit_id = $_POST["edit_id"];
$user_id = getLoginUserId();


$pdo = getDatabaseConnection();

try {
  if ($stmt = $pdo->prepare("DELETE FROM memos WHERE id = :edit_id AND user_id = :user_id")) {
    $stmt->bindParam(":edit_id", $edit_id);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();
  }
} catch (Throwable $e) {
  echo $e->getMessage();
  exit;
}

unset($_SESSION["select_memo"]);

header("Location: ../index.php");
exit;
?>