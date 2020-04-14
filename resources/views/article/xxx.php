<?
include('connect.php');

$userName = $_POST['userName'];         // 取用户名的值
$numberName = $_POST['numberName'];     // 取手机号的值
$password = $_POST['pwdName'];           // 取密码的值
$pwd = $_POST['pwdName2'];         // 取确认密码的值
$email = $_POST['emailName'];       // 取邮箱的值

//用户信息判断
if(!preg_match('/^[\w\x80-\xff]{3,15}$/',$userName)){
    exit('错误：用户名不符合规定');
}

//密码长度判断
if(strlen($password<6)){
    exit('错误：密码长度不符合规定');
}
//检查密码是否相同
if($password == $pwd){
    //相同的话就执行如下操作   判断用户名 是否存在
    $che = mysql_query("select userName from register where userName='$userName' limit 1 ");
    if (mysql_fetch_array($che)){
        echo '错误：用户名',$userName,'已经存在';
        exit;
    }
    //判断该手机号 是否已经注册
    $sjh = mysql_query("select numberName from register where numberName='$numberName' limit 1 ");
    if (mysql_fetch_array($sjh)){
        echo '错误：该手机号：',$numberName,'已经注册。';
        exit;
    }

    // 写入数据
    $password = md5($password);
    $pwd = md5($pwd);
    $sql = "INSERT INTO register(userName,numberName,password,pwd,email) VALUES('{$userName}','{$numberName}','{$password}','{$pwd}','{$email}')";
    $is = mysql_query($sql);
    var_dump($is);//返回true就成功，反false之失败
}else{
    echo '密码不一致，请重新输入';
}

?>
