<?php
$id = $_GET["id"];
//１．PHP
//select.phpのPHPコードをマルっとコピーしてきます。
//※SQLとデータ取得の箇所を修正します。
include("funcs.php");
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT * FROM gs_an_table WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id',$id,PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//３．データ表示
$values = "";
if($status==false) {
  sql_error($stmt);
}

//全データ取得
$v =  $stmt->fetch(); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
//$json = json_encode($values,JSON_UNESCAPED_UNICODE);

?>
<!--
２．HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
理由：入力項目は「登録/更新」はほぼ同じになるからです。
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み"
-->

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ更新</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="POST" action="update.php">
  <div class="jumbotron">
   <fieldset>
    <legend>所属情報（基本情報）</legend>
     <label>名前：<input type="text" name="username" value="<?=$v["username"]?>"></label><br>
     <label>社員番号：<input type="text" name="employee_number"  value="<?=$v["employee_number"]?>"></label><br>
     <label>部署：<input type="text" name="department"  value="<?=$v["department"]?>"></label><br>
     <label>役職:<input type="text" name="position"  value="<?=$v["position"]?>"></label><br>
     <label>性別:<input type="text" name="gender"  value="<?=$v["gender"]?>"></label><br>
     <label>メールアドレス:<input type="text" name="email"  value="<?=$v["email"]?>"></label><br>
     <label>備考:<textArea name="naiyou" rows="4" cols="40"><?=$v["naiyou"]?></textArea></label><br>
     <label>モチベーションの源泉:<input type="checkbox" name="options[]"  value="<?=$v["options[]"]?>"></label><br>
     <input type="hidden" name="id" value="<?=$v["id"]?>">
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>



