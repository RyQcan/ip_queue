<?php
/**
 * Created by PhpStorm.
 * User: zrq
 * Date: 17-12-23
 * Time: 上午10:05
 */

header("Content-type: text/html; charset=utf-8");
$servername = "localhost";
$username = "root";
$password = "13723926068";
$dbname = "ipbase";

$conn = new mysqli($servername, $username, $password, $dbname);// 创建连接

// 检测连接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$finished_id=$_GET['finished'];
if($finished_id!=null){
    if(mysqli_query($conn,"UPDATE iptable SET task_finished=1 WHERE id=$finished_id"))
        echo json_encode(array($finished_id=> "1"));//ok
    else
        echo json_encode(array($finished_id=> "0"));//failed
}else{
    echo"you should provide a finished id";
}

