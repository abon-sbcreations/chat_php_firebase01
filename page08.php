<?php
ob_start();
require_once 'ConnectDb.php';
if($_POST){
    $db = ConnectDb::getInstance();
    $mysqli = $db->getConnection(); 
    $sql = "select * from user where username ='{$_POST['username']}'";
    $result = $mysqli->query($sql);
   $row =  $result->fetch_assoc();
   if(isset($row)){
       session_start();
       $_SESSION["logged_user"] = $row["id"];
         header("Location: page09.php");
   }
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Login Page 08
        </title>
        <link href="library/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/myCss05.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="container">
            <form class="form-horizontal"  method="post">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">User Name:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter User Name">
                    </div>
                </div>              
                <div class="form-group"> 
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>    
        </div>

    </body>
</html>
