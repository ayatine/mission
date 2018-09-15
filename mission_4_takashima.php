<?php
header('Content-Type: text/html; charset=UTF-8');

$dsn='database-name';
$user='user-name';
$password='password';
$pdo=new PDO($dsn,$user,$password);
?>

<!DOCTYPE html>
<html lang='ja'>
<head><meta charset='utf-8'></head>

<body>
<?php

if(!empty($_POST["delete"])){

$sql="SELECT* FROM chat1 WHERE id={$_POST['delete']}";
$results=$pdo->query($sql);
foreach($results as $row){
$password=$row['password'];
}
//削除
	if($_POST["delPass"]==$password){
	$id=$_POST["delete"];
	$sql="delete from chat1 where id=$id;"
	."ALTER TABLE chat1 AUTO_INCREMENT = 1;";
	$result=$pdo->query($sql);
	}else{
	echo "パスちゃうよ";
	}
}

if(!empty($_POST["edit"])){

$sql="SELECT* FROM chat1 WHERE id={$_POST['edit']}";
$results=$pdo->query($sql);
foreach($results as $row){
$password=$row['password'];
}
//編集選択
	if($_POST["editPass"]==$password){

$sql="SELECT* FROM chat1 WHERE id={$_POST['edit']}";
$results=$pdo->query($sql);

foreach($results as $row){
echo $_POST['edit'].'番の投稿を編集します((+_+))'.'<br>';
$editName=$row['name'];
$editComment=$row['comment'];
}
	}else{
	echo "パスちゃうよ";
	}
}

if(!empty($_POST["accedit"])){
//編集実行
	$id=$_POST["accedit"];
	$nm=$_POST["name"];
	$kome=$_POST["comment"].'【編集済み】';
	$sql="update chat1 set name='$nm',comment='$kome' where id=$id";
	$result=$pdo->query($sql);
}

?>

<form action="mission_4_takashima.php" method="post">

<?php
echo "<input type='text' name='name' value='{$editName}' placeholder='名前'>";
?>
<br>
<?php
echo "<textarea name='comment' placeholder='コメント'>{$editComment}</textarea>";
?>

<?php
echo "<input type='hidden' name='accedit' value='{$_POST[edit]}'>";
?>

<br>

<?php
if(!empty($_POST["edit"]) && !empty($_POST["editPass"])){
echo "<input type='hidden' name='password'>";
}else{
echo "<input type='text' name='password' placeholder='書き込みのパスワード設定'>";
}
?>

<input type="submit">

</form>

<br>

<form action="mission_4_takashima.php" method="post">
<p>
<input type='text' name="delete" placeholder='削除番号' size='4'>
<input type='text' name='delPass' placeholder='パスワード'>
<input type="submit" value="削除">
</p>
</form>

<form action="mission_4_takashima.php" method="post">
<p>
<input type='text' name="edit" placeholder='編集番号' size='4'>
<input type='text' name='editPass' placeholder='パスワード'>
<input type="submit" value="編集">
</p>
</form>

<?php
//入力
$sql=$pdo->prepare("INSERT INTO chat1(name,comment,password) VALUES(:name,:comment,:password)");
$sql->bindParam(':name',$name,PDO::PARAM_STR);
$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
$sql->bindParam(':password',$password,PDO::PARAM_STR);

if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password"])){
$name=$_POST["name"];
$comment=$_POST["comment"];
$password=$_POST["password"];
$sql->execute();
}elseif(!empty($_POST["delete"]) || !empty($_POST["edit"]) || !empty($_POST["accedit"])){
}else{
echo '名前・コメント・パスを設定してください'.'<br>'.'<br>';
}

//表示
$sql='SELECT* FROM chat1';
$results=$pdo->query($sql);

foreach($results as $row){
echo $row['id'].',';
echo $row['name'].',';
echo $row['comment'].'<br>';
}

?>

</body>
</html>
