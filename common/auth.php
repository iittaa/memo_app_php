<?php
if (!isset($_SESSION)) {
  session_start();
}

function isLogin() {
  if (isset($_SESSION["user"])) {
    return true;
  }
  return false;
}

// ログインしているユーザー名を取得する
function getLoginUserName() {
  if (isset($_SESSION["user"])) {
    $name = $_SESSION["user"]["name"];

    if (7 < mb_strlen($name)) {
      $name = mb_substr($name, 0, 7). "...";
    }
    return $name;
  }
  return "";
}

// ログインしているユーザーのIDを取得する
function getLoginUserId() {
  if (isset($_SESSION["user"])) {
    $id = $_SESSION["user"]["id"];
    return $id;
  }
  return null;
}


?>