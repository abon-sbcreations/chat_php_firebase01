<?php
ob_start();
if ($_POST) {
     $dbhost = 'localhost';
   $dbuser = 'root';
   $dbpass = '';
   $dbname = 'chat01';
   $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);
   
   if(! $conn ) {
      die('Could not connect: ' . mysqli_error());
   }
   echo 'Connected successfully<br>';
   $sql = "SELECT * from user where username='{$_POST['inputUser']}'";
   $result = mysqli_query($conn, $sql);

   if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
         session_start();
         
         $_SESSION["logged_user"] = $row["id"];
         header("Location: page02.php");
         
      }
   } else {
      echo "0 results";
   }
   mysqli_close($conn);
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Signin Template for Bootstrap</title>

        <link href="library/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="library/css/myCss01.css" rel="stylesheet" type="text/css"/>
    </head>

    <body class="text-center">
        <form class="form-signin" method="post">
            <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
            <label for="inputUser" class="sr-only">User Name</label>
            <input name="inputUser" type="text" id="inputUser" class="form-control" placeholder="User Name" required autofocus>
            <div class="checkbox mb-3"></div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
        </form>
    </body>
</html>
