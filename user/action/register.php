<?php

session_start();
require("../../common/validation.php");
$_SESSION["errors"] = validation($_POST);

// DBファイル読み込み
require("../../common/database.php");

// パラメータ取得
$user_name = $_POST["user_name"];
$user_email = $_POST["user_email"];
$user_password = $_POST["user_password"];

// バリデーション
// $_SESSION['errors'] = [];

// - 空チェック
// emptyCheck($_SESSION['errors'], $user_name, "ユーザー名を入力してください。");
// emptyCheck($_SESSION['errors'], $user_email, "メールアドレスを入力してください。");
// emptyCheck($_SESSION['errors'], $user_password, "パスワードを入力してください。");

// // - 文字数チェック
// stringMaxSizeCheck($_SESSION['errors'], $user_name, "ユーザー名は255文字以内で入力してください。");
// stringMaxSizeCheck($_SESSION['errors'], $user_email, "メールアドレスは255文字以内で入力してください。");
// stringMaxSizeCheck($_SESSION['errors'], $user_password, "パスワードは255文字以内で入力してください。");
// stringMinSizeCheck($_SESSION['errors'], $user_password, "パスワードは8文字以上で入力してください。");

// if(!$_SESSION['errors']) {
//   // - メールアドレスチェック
//   mailAddressCheck($_SESSION['errors'], $user_email, "正しいメールアドレスを入力してください。");

//   // - ユーザー名・パスワード半角英数チェック
//   halfAlphanumericCheck($_SESSION['errors'], $user_name, "ユーザー名は半角英数字で入力してください。");
//   halfAlphanumericCheck($_SESSION['errors'], $user_password, "パスワードは半角英数字で入力してください。");

//   // - メールアドレス重複チェック
//   mailAddressDuplicationCheck($_SESSION['errors'], $user_email, "既に登録されているメールアドレスです。");
// }

if (!empty($_SESSION["errors"])) {
  header('Location: ../../user/index.php');
  exit;
}

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

    $_SESSION["user"] = [
      "name" => $user_name,
      "id" => $pdo->lastInsertId()
    ];

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