<?php
ob_start();
session_start();
if (empty($_SESSION)) {
    header("Location: page05.php");
}
require_once 'ConnectDb.php';
$sql = "SELECT * from user";
$db = ConnectDb::getInstance();
$mysqli = $db->getConnection();
$result = $mysqli->query($sql);
$users = [];
$user_name = '';
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        if ($_SESSION['logged_user'] != $row['id']) {
            $users[$row['id']] = ['username' => $row['username']];
        } else {
            $user_name = $row['username'];
        }
    }
} else {
    echo "0 results";
}
?>
<html>
    <link rel="stylesheet" href="assets/css/headercss.css">
    <link rel="stylesheet" href="library/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/custom.css?v=2" type="text/css" />
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'>
    <link rel="stylesheet" href="assets/css/massagepagecustom.css?v=2"/>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
    </style>
    <body>
        <div class="fixeddivnav">
            <div class="underfixdiv">
                <div class="manupart"> <a class="manu-link" href="#">HOME</a> <a class="manu-link" href="#">ABOUT US</a> <a class="manu-link" href="#hdiw">HOW IT WORKS</a> <a class="manu-link " href="#">BLOG</a> <a class="manu-link " href="#">CONTACT</a> </div>
                <div class="profilepart"> <a href="#" class="facebooklogin"><i style="font-size:26px" class="fab fa-facebook fa-lg"></i> <span class="fbtext">Log in with Facebook</span></a> </div>
            </div>
        </div>
        <div class="gapremover">&nbsp;</div>


        <!--user data form-->
        <div class="container" id="formDiv ">
            <div class="row">
                <form id="idFormUser" style="margin:auto" class="form-inline" action="#">
                    <label for="email" style="color:#FFF">Username</label>
                    &nbsp;
                    <input type="text" autocomplete="on" required placeholder="type Username" class="form-control" id="userID">
                    &nbsp;
                    <button type="submit" class="btn btn-primary">Start Chat</button>
                    &nbsp;&nbsp;&nbsp; <span style="color:#F63" id="userError">Oops! Some Error here.</span>
                </form>
            </div>
        </div>
        <br />

        <!-- chat iframe  Start---->

        <div id="frame">
            <div id="sidepanel">
                <div id="profile">
                    <div class="wrap"> 
                        <p><a href="#"><?= $user_name ?></a></p>
                        <i class="fa fa-chevron-down expand-button" aria-hidden="true"></i>
                        <div id="status-options">
                            <ul>
                                <li id="status-online" class="active"><span class="status-circle"></span>
                                    <p>Online</p>
                                </li>
                                <li id="status-away"><span class="status-circle"></span>
                                    <p>Away</p>
                                </li>
                                <li id="status-busy"><span class="status-circle"></span>
                                    <p>Busy</p>
                                </li>
                                <li id="status-offline"><span class="status-circle"></span>
                                    <p>Offline</p>
                                </li>
                            </ul>
                        </div>
                        <div id="expanded">
                            <label for="twitter"><i class="fa fa-facebook fa-fw" aria-hidden="true"></i></label>
                            <input name="twitter" type="text" value="mikeross" />
                            <label for="twitter"><i class="fa fa-twitter fa-fw" aria-hidden="true"></i></label>
                            <input name="twitter" type="text" value="ross81" />
                            <label for="twitter"><i class="fa fa-instagram fa-fw" aria-hidden="true"></i></label>
                            <input name="twitter" type="text" value="mike.ross" />
                        </div>
                    </div>
                </div>
                <div id="search">
                    <label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
                    <input type="text" placeholder="Search contacts..." />
                </div>
                <div id="contacts">
                    <ul id="contact_list"></ul>
                </div>
                <div id="bottom-bar">
                    <button id="addcontact"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> <span>Add contact</span></button>
                    <button id="settings"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>Settings</span></button>
                </div>
            </div>
            <div class="content">
                <div class="contact-profile">  
                    <p id="contactProfileName"></p>
                    <div class="social-media"> <i class="fa fa-facebook" aria-hidden="true"></i> <i class="fa fa-twitter" aria-hidden="true"></i> <i class="fa fa-instagram" aria-hidden="true"></i> </div>
                </div>
                <div class="messages"><ul></ul></div>
                <div class="message-input">
                    <div class="wrap">
                        <input type="text" placeholder="Write your message..." />
                        <i class="fa fa-paperclip attachment" aria-hidden="true"></i>
                        <button class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <script src="library/js/jquery.min.js" type="text/javascript"></script>
        <script src="library/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="library/js/5.0.1/firebase-app.js" type="text/javascript"></script>
        <script src="library/js/5.0.1/firebase-database.js" type="text/javascript"></script>
        <script src="assets/js/myfirebase_confs.js" type="text/javascript"></script>
        <script src="assets/js/mycustom09.js"></script>
        <script>
            firebase.initializeApp(firebase_config);
            var totChat = [];
            $(document).ready(function () {
                $(".message-input input").attr('disabled', 'disabled');
            });
            var logged_id;
            var current_id;
            $.each(<?= json_encode($users) ?>, function (id, row) {
                $("#contact_list").append("<li class='contact' id='user_" + id + "'><div class='wrap'>"
                        + "<span class='contact-status online'></span>"
                        + "<div class='meta'><p class='name'>" + row['username'] + "</p></div></div></li>");
                $(document).on('click', '#user_' + id, function () {
                    current_id = id;
                    totChat = [];
                    logged_id = <?= $_SESSION['logged_user'] ?>;
                    $(".message-input input").removeAttr('disabled');
                    $("#contactProfileName").html(row['username']);

                    var logRef = firebase.database().ref().child('chats').orderByChild("from_id").equalTo(parseInt(logged_id));
                    var curRef = firebase.database().ref().child('chats').orderByChild("from_id").equalTo(parseInt(current_id));
                    logRef.on("child_added", function (snap) {                        
                        snap = snap.val();
                        if(snap['to_id']==current_id){
                            totChat.push(snap);
                            showChat();
                        }                        
                    });
                    curRef.on("value", function (snap) {
                        
                    });
                    curRef.on("child_added", function (snap) {
                        snap = snap.val();
                        if(snap['to_id']==logged_id){
                            totChat.push(snap);
                             $.ajax({type: "POST",async: "false",
                                 url: "page09Ajax.php",data:{row:snap},
                                 success: function(html) {
                                     var arr=$.parseJSON(html);
                                     console.log(arr);
                                     if(arr.status == 1) {
                                         console.log("delRef remove 1");
                                        var rem1 = firebase.database().ref().child('chats')
                                                 .orderByChild("current_time").equalTo(snap['current_time']);
                                        rem1.on('value',function(x){
                                              console.log("delRef remove 3");
                                              x = x.val();
                                              $(document).each(x,function(key,val){
                                                  firebase.database().ref().child('chats').remove(key);
                                              });
                                              console.log("delRef remove 4");
                                        });
                                         console.log("delRef remove 2");
                                     } 
                                 }
                             });
                            showChat();
                            
                            
                        }
                    });
                   
                });
            });
            function showChat() {
                $('.messages ul').html("");
                 totChat.sort(function (a, b) {
                        if (a.current_time > b.current_time) {
                            return 1
                        }
                        if (a.current_time < b.current_time) {
                            return -1
                        }
                        return 0;
                    });
                $.each(totChat, function (key, snap) {
                    if (snap['from_id'] == logged_id) {
                        $("<li class='sent'>"
                                + "<p>to-" + snap['message'] + "-log to</p></li>")
                                .appendTo($('.messages ul'));
                    } else {
                        $("<li class='replies'>"
                                + "<p>to-" + snap['message'] + "-log to</p></li>")
                                .appendTo($('.messages ul'));
                    }
                });
                scrollBottom(".messages",10);   
            }
            function scrollBottom(identifier,sec){
            $(identifier).animate({
                        scrollTop: $(identifier)[0].scrollHeight - $(identifier)[0].clientHeight
                    }, sec);
            }
            function newMessage() {
                message = $(".message-input input").val();
                if ($.trim(message) == '') {
                    return false;
                }
                var ip = '<?= $_SERVER['REMOTE_ADDR'] ?>';
                $('.message-input input').val(null);
                $('.contact.active .preview').html('<span>You: </span>' + message);
                $(".messages").animate({scrollTop: $(document).height()}, "fast");
                var newPostKey = firebase.database().ref().child('chats').push().key;
                var x1 = firebase.database().ref('chats/' + newPostKey).set({
                    'message': message,
                    'ip': ip,
                    'from_id': parseInt(logged_id),
                    'to_id': parseInt(current_id),
                    'current_time': $.now()
                });
            }

            $('.submit').click(function () {
                newMessage();
            });

            $(window).on('keydown', function (e) {
                if (e.which == 13) {
                    newMessage();
                    return false;
                }
            });
            function removeAll() {
                var chatRef = firebase.database().ref().child('chats');
                //chatRef.remove();
                chatRef.on("value", function (snap) {
                    console.log("--chatRef--");
                    snap = snap.val();
                    console.log(snap);
                    console.log("--chatRef--");
                });
            }
        </script>
    </body>
</html>
