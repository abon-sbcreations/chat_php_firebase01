<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'chat01';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$record = "";
foreach ($_POST['totalChats'] as $row) {
    $record .= "INSERT INTO `chat` ( `from_id`, `to_id`, `txt_msg`, `time1`, `ip`, `is_valid`) VALUES ('{$row['from_id']}','{$row['to_id']}','{$row['message']}','{$row['current_time']}','{$row['ip']}','1');";
}

if ($conn->multi_query($record) === TRUE) {
    echo json_encode(['status'=>1,'msg'=>'record saved successfully','sql'=>$sql]);
} else {
    echo json_encode(['status'=>0,'msg'=>$conn->error,'sql'=>$sql]);
}
$conn->close();
?>