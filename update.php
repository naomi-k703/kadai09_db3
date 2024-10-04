<?php
//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//   POSTデータ受信 → DB接続 → SQL実行 → 前ページへ戻る
//2. $id = POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更
//1. POSTデータ取得
// $name   = $_POST["name"];
// $email  = $_POST["email"];
// $naiyou = $_POST["naiyou"];
// $age    = $_POST["age"];
// $id    = $_POST["id"];

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
$id    = isset($_POST["id"])? $_POST["id"] : '';


//2. DB接続します
include("funcs.php"); //外部ファイル読み込み
$pdo = db_conn();

//３．データ登録SQL作成
$sql = "UPDATE gs_an_table SET name=:name,email=:email,age=:age,naiyou=:naiyou WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':employee_number', $employee_number, PDO::PARAM_INT);
$stmt->bindValue(':department', $department, PDO::PARAM_STR);
$stmt->bindValue(':position', $position, PDO::PARAM_STR);
$stmt->bindValue(':gender', $gender, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':naiyou', $naiyou, PDO::PARAM_STR);
$stmt->bindValue(':options', $options, PDO::PARAM_STR);
$stmt->bindValue(':id',     $id,    PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行

//４．データ登録処理後
if($status==false){
    //*** function化する！*****************
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}else{
    //*** function化する！*****************
    header("Location: select.php");
    exit();
}

