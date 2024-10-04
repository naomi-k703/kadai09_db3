<?php
//1. POSTデータ取得
// $name   = $_POST["name"];
// $email  = $_POST["email"];
// $naiyou = $_POST["naiyou"];
// $age    = $_POST["age"];

$username = isset($_POST["username"]) ? $_POST["username"] : '';
$employee_number = isset($_POST["employee_number"]) ? $_POST["employee_number"] : '';
$department = isset($_POST["department"]) ? $_POST["department"] : '';
$position = isset($_POST["position"]) ? $_POST["position"] : '';
$gender = isset($_POST["gender"]) ? $_POST["gender"] : '';
$email = isset($_POST["email"]) ? $_POST["email"] : '';

// optionsのチェック
if (isset($_POST['options'])) {
    $options = implode(",", $_POST['options']); // コンマで結合して文字列に変換
} else {
    $options = ''; // チェックが何も選択されなかった場合
}

// naiyouの取得（フォームに含まれている場合）
$naiyou = isset($_POST['naiyou']) ? $_POST['naiyou'] : ''; // POSTデータからnaiyouを取得

//2. DB接続します
include("funcs.php"); //外部ファイル読み込み
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO gs_an_table_TEST(username,employee_number,department,position,gender,email,naiyou,options,indate)VALUES((:username,:employee_number,:department,:position,:gender,:email,:naiyou,:options,sysdate())");

$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':employee_number', $employee_number, PDO::PARAM_INT);
$stmt->bindValue(':department', $department, PDO::PARAM_STR);
$stmt->bindValue(':position', $position, PDO::PARAM_STR);
$stmt->bindValue(':gender', $gender, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':naiyou', $naiyou, PDO::PARAM_STR);
$stmt->bindValue(':options', $options, PDO::PARAM_STR);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if($status==false){
    //*** function化する！*****************
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}else{
    //*** function化する！*****************
    header("Location: index.php");
    exit();
}
?>
