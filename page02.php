<?php
session_start();

$session_id = session_id();
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'chat01';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    die('Could not connect: ' . mysqli_error());
}

$sql = "SELECT * from user";
$result = mysqli_query($conn, $sql);
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



<!------ Include the above in your HEAD tag ---------->


<!DOCTYPE html><html class=''>
    <head>
        <script src="library/js/jquery.min.js" type="text/javascript"></script>
        <script src="library/js/bootstrap.bundle.min.js" type="text/javascript"></script>

        <link href="library/css/myCss01.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>

        <div id="frame">
            <div id="sidepanel">
                <div id="profile">
                    <div class="wrap">
                        <p ><?= $user_name ?></p>
                        <i class="fa fa-chevron-down expand-button" aria-hidden="true"></i>
                        <div id="status-options">
                            <ul>
                                <li id="status-online" class="active"><span class="status-circle"></span> <p>Online</p></li>
                                <li id="status-away"><span class="status-circle"></span> <p>Away</p></li>
                                <li id="status-busy"><span class="status-circle"></span> <p>Busy</p></li>
                                <li id="status-offline"><span class="status-circle"></span> <p>Offline</p></li>
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
                    <ul>
                        <li class="contact">
                            <div class="wrap">
                                <span class="contact-status online"></span>
                        <?php foreach ($users as $k => $usr) { ?>
                                    <div id="user_<?= $k ?>" class="meta">
                                        <p class="name"><?= $usr['username'] ?></p>
                                    </div>
                        <?php } ?>
                            </div>
                        </li>

                    </ul>
                </div>

            </div>
            <div class="content">
                <div class="contact-profile">
                    <p id="chatTo">Select One</p>
                    <div class="social-media">
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                        <i class="fa fa-twitter" aria-hidden="true"></i>
                        <i class="fa fa-instagram" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="messages">
                    <ul>
                       
                    </ul>
                </div>
                <div class="message-input">
                    <div class="wrap">
                        <input type="text" placeholder="Write your message..." />
                        <
                        <i class="fa fa-paperclip attachment" aria-hidden="true"></i>
                        <button class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <script src="library/js/5.0.1/firebase-app.js" type="text/javascript"></script>
        <script src="library/js/5.0.1/firebase-database.js" type="text/javascript"></script>


        <script src="assets/js/myfirebase_confs.js" type="text/javascript"></script>
        <script >
            var user_id = "";
            var user_name = "";
            var present_chat = "";
            var combine_id = '';
             var idleState = false;
        var idleTimer = null;
            firebase.initializeApp(firebase_config);
            $(document).ready(function () {
                $(".message-input input").attr('disabled','disabled');
               
        $('*').bind('mousemove click mouseup mousedown keydown keypress keyup submit change mouseenter scroll resize dblclick', function () {
            clearTimeout(idleTimer);
            idleState = false;
            idleTimer = setTimeout(function () { 
                var totalChats = [];
                var chatIds = [];
                    var fromRef = firebase.database().ref().child('chats').orderByChild("from_id").equalTo(<?=$_SESSION['logged_user']?>);
                    var toRef = firebase.database().ref().child('chats').orderByChild("to_id").equalTo('<?=$_SESSION['logged_user']?>');
               var callFrom = function(){
                       // console.log('callFrom');
                        fromRef.on("value",function(snap){
                          //  console.log(1);
                           var snaps = snap.val();
                           // console.log(snaps);
                           $.each(snaps, function( key, row ) {
                             //  console.log(2+" "+key);
                               chatIds.push(key);
                               totalChats.push(row);
                           });
                            
                        });
                    };    
                  var callTo = function(){
                       // console.log('callTo');
                        toRef.on("value",function(snap){
                            //console.log(3);
                           var snaps = snap.val();                           
                          // console.log(snaps);
                           $.each(snaps, function( key, row ) {
                               //console.log(4+" "+key);
                               chatIds.push(key);
                               totalChats.push(row);
                           });
                        });
                    };
                   var sendToSql = function(){
                      // console.log('sendToSql');
                       if(totalChats.length > 0){
                       // console.log(5);
                        $.ajax({
                            type: 'POST',
                            url: "page02Ajax.php",
                            data: {'totalChats':totalChats},  
                            async:false,
                            success: function(result){
                                if(result.length > 0 ){
                                   // console.log(6);
                                    console.log(result);
                                }
                            }                            
                        });
                       }
                        // console.log(7);  
                    };
                   var dfd = $.Deferred();
                        dfd
                        // .done() can take any number of functions or arrays of functions
                            .done( [ callFrom, callTo ], sendToSql ); 
                    dfd.resolve( "and" );
                        //console.log("chat ROW = "+totalChats.length);
                        
                        //console.log(chatIds);
                    idleState = true; }, 5000);
                });
                $("body").trigger("mousemove");
            });
            
            $(".messages").animate({scrollTop: $(document).height()}, "fast");

            $("#profile-img").click(function () {
                $("#status-options").toggleClass("active");
            });

            $(".expand-button").click(function () {
                $("#profile").toggleClass("expanded");
                $("#contacts").toggleClass("expanded");
            });

            $("#status-options ul li").click(function () {
                $("#profile-img").removeClass();
                $("#status-online").removeClass("active");
                $("#status-away").removeClass("active");
                $("#status-busy").removeClass("active");
                $("#status-offline").removeClass("active");
                $(this).addClass("active");

                if ($("#status-online").hasClass("active")) {
                    $("#profile-img").addClass("online");
                } else if ($("#status-away").hasClass("active")) {
                    $("#profile-img").addClass("away");
                } else if ($("#status-busy").hasClass("active")) {
                    $("#profile-img").addClass("busy");
                } else if ($("#status-offline").hasClass("active")) {
                    $("#profile-img").addClass("offline");
                } else {
                    $("#profile-img").removeClass();
                }
                ;

                $("#status-options").removeClass("active");
            });
            
            
            function newMessage() {
                message = $(".message-input input").val();
                var ip = '<?= $_SERVER['REMOTE_ADDR'] ?>';
                var from_id = <?= $_SESSION['logged_user'] ?>;
                var to_id = user_id;
                var newPostKey = firebase.database().ref().child('chats').push().key;
                var idArr = [from_id,to_id];
                idArr = idArr.sort();
                var combine_id = idArr[0]+"_"+idArr[1];
                
                var x1 = firebase.database().ref('chats/' + newPostKey).set({
                    'message': message,
                    'ip': ip,
                    'from_id': from_id,
                    'to_id': to_id,
                    'current_time': $.now()
                });
                if ($.trim(message) == '') {
                    return false;
                }
                $('.message-input input').val(null);
                $('.contact.active .preview').html('<span>You: </span>' + message);
                $(".messages").animate({scrollTop: $(document).height()}, "fast");
            }
            ;
            idleTimer = null;
            idleState = false;
            idleWait = 1000;
             
            if (idleState == true) { 
                
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

            var users = <?= json_encode($users) ?>;
            $.each(users, function (id, row) {
                $(document).on("click", "#user_" + id, function () {
                    user_id = id;
                    var from_id = <?= $_SESSION['logged_user'] ?>;
                    $(".message-input input").removeAttr('disabled');  
                    combine_id = from_id > user_id ? user_id+"_"+from_id : from_id+"_"+user_id;
                   user_name = row['username'];
                    $("#chatTo").html(row['username']);
                    $(".messages ul").html("");
                    var chatRef = firebase.database().ref().child('chats').orderByChild("from_to_combine_id").equalTo(combine_id);
                        chatRef.on("child_added",function(snap){
                            var rec = snap.val();
                            if(rec['from_id']==from_id){
                                
                                $("<li class='sent'>"
                        + "<p>" + rec['message'] + "</p></li>")
                        .appendTo($('.messages ul'));
                            }else{
                                $("<li class='replies'>"
                                    + "<p>" + rec['message'] + "</p></li>")
                                    .appendTo($('.messages ul'));
                            }
                        });
                });
            });
        </script>
    </body></html>


