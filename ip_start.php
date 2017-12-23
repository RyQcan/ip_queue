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

function get_next_id($conn){
    $sql = "SELECT next_id FROM next_id_start";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["next_id"];//获取需要请求的id
    } else{
        echo "next_id not exit!";
    }
}
function return_ip($conn, $id){
    $sql = "SELECT id, ip, task_start, task_finished FROM iptable WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // 输出数据
        $row = $result->fetch_assoc();
        echo "<br> id: ". $row["id"]. " - ip: ". $row["ip"]. " " . $row["task_start"]. " " . $row["task_finished"];
        //返回被获取的id
    } else {
        echo "0 results";
    }
}

function update($conn, $id){
    if(mysqli_query($conn,"UPDATE iptable SET task_start=1 WHERE id=$id")) //将被获取ip的task_start标志位置1
        echo "<br>set task_start ok";
    else
        echo "<br>set task_start failed";
    $id+=1;//标示下一个将要被获取的id
    if(mysqli_query($conn,"UPDATE next_id_start SET next_id=$id"))//更新next_id_start表
        echo "<br>set next_id ok";
    else
        echo "<br>set next_id failed";
}

$if_find=$_GET['queue'];
if ($if_find=="find"){
    $id=get_next_id($conn);
    return_ip($conn, $id);
    update($conn,$id);
}

$conn->close();

