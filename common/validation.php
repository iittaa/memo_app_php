<?php 

function validation($request) {
  $errors = [];

  if (empty($request["user_name"]) || 20 < mb_strlen($request["user_name"])) {
    $errors[] = "「ユーザー名」は必須です。20文字以内で入力してください。";
  }

  if (empty($request["user_email"]) || !filter_var($request["user_email"], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "「メールアドレス」は必須です。正しい形式で入力してください。";
  }

  if (empty($request["user_password"]) || 8 > mb_strlen($request["user_password"])) {
    $errors[] = "「パスワード」は必須です。8文字以上で入力してください。";
  }

  return $errors;
}

// function emptyCheck(&$errors, $check_value, $message){
//   if (empty(trim($check_value))) {
//     array_push($errors, $message);
//   }
// }

// function stringMinSizeCheck(&$errors, $check_value, $message){
//   if (mb_strlen($check_value) < 8) {
//     array_push($errors, $message);
//   }
// }

// function stringMaxSizeCheck(&$errors, $check_value, $message) {
//   if (255 < mb_strlen($check_value)) {
//     array_push($errors, $message);
//   }   
// } 


// function mailAddressCheck(&$errors, $check_value, $message) {
//   if (filter_var($check_value, FILTER_VALIDATE_EMAIL) == false) {
//     array_push($errors, $message);
//   }
// } 

// function halfAlphanumericCheck(&$errors, $check_value, $message) {
//   if (preg_match("/^[a-zA-Z0-9]+$/", $check_value) == false) {
//     array_push($errors, $message);
//   }
// }

// function mailAddressDuplicationCheck(&$errors, $check_value, $message) {
//   $pdo = getDatabaseConnection();
//   if ($statement = $pdo->prepare('SELECT id FROM users WHERE email = :user_email')) {
//     $statement->bindParam(':user_email', $check_value);
//     $statement->execute();
//   }

//   $result = $statement->fetch(PDO::FETCH_ASSOC);
//   if ($result) {
//     array_push($errors, $message);
//   }
// } 

?>