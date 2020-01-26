<?php
include('../config/dbconf.php');

function encrypt($user, $pass) {
  $user = strtoupper($user);
  $pass = strtoupper($pass);
  return sha1($user.':'.$pass);
}

$username = $_POST['user'];
$password = encrypt($username, $_POST['pass']);
$email = $_POST['email'];
$exp = $_POST['exp'];

$count = 0;

$stmt = $conn->prepare("SELECT * FROM account WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
if($stmt->num_rows > 0) {
  $count = 1;
}

if($count == 0) {
  $sql = "INSERT INTO account (username,sha_pass_hash,email,expansion) VALUES(?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssi",$username, $password, $email, $exp);
  if($stmt->execute()) {
    echo "registered";
  }else{
    echo "Failed to register<br>" . $stmt->error;
  }
}else{
  echo "1";
}
?>
