<?php
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
    <head>
        <title>chat based on firebase</title>
        <script src="library/js/jquery.min.js" type="text/javascript"></script>
        <script src="library/js/bootstrap.min.js" type="text/javascript"></script>
        <link href="library/css/myCss06.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>

        <div id="frame">
            <div id="sidepanel">
                <div id="profile">
                    <div class="wrap">
                        <p ><a href = 'page07.php'><?= $user_name ?></a></p>
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
        <script>
            firebase.initializeApp(firebase_config);
            var users = <?= json_encode($users) ?>;
            var from_id = 0;
            var to_id = 0;
            $(document).ready(function () {
                from_id = <?=$_SESSION['logged_user']?>;
                $(".message-input input").attr('disabled', 'disabled');
            });
            $.each(users, function (id, row) {
                $(document).on("click", "#user_" + id, function () {
                    to_id = id;
                    var from_id = <?= $_SESSION['logged_user'] ?>;
                    $(".message-input input").removeAttr('disabled');
                    user_name = row['username'];
                    $("#chatTo").html(row['username']);
                    $(".messages ul").html("");
                    if (to_id != 0 && from_id != 0) {
                        var toRef = firebase.database().ref().child('chats').orderByChild("to_id").equalTo('2');
                        toRef.on("child_added", function (snap) {
                            var rec = snap.val();
                            console.log("-----toRef-------");
                            console.log(rec);
                            console.log("-----toRef-------");
                            $("<li class='replies'>"
                                    + "<p>" + rec['message'] + "</p></li>")
                                    .appendTo($('.messages ul'));
                            $.ajax({
                                    type: 'POST',
                                    url: "page06Ajax.php",
                                    data: {'row': row},
                                    async: false,
                                    success: function (result) {
                                        if (result.status == 1) {
                                            var remRef = firebase.database().ref().child('chats').orderByKey().equalTo(apiKey);
                                            remRef.on('child_added', function (snapshot) {
                                                snapshot.ref.remove();
                                            })
                                        }
                                    }
                                });
                        });
                        var fromRef = firebase.database().ref().child('chats').orderByChild("from_id").equalTo(from_id);
                        fromRef.on("value", function (snap) {
                            snap = snap.val();
                            console.log("-----fromRef------");
                            console.log(snap);
                            console.log("-----fromRef------");
                            $.each(snap, function (apiKey, row) {
                                console.log(snap);
                                console.log(row);
                                $("<li class='sent'>"
                                        + "<p>" + row['message'] + "</p></li>")
                                        .appendTo($('.messages ul'));
                            });
                        });
                    }
                });
            });

            $('.submit').click(function () {
                newMessage();
            });

            $(window).on('keydown', function (e) {
                if (e.which == 13) {
                    newMessage();
                    return false;
                }
            });
            function newMessage() {
                message = $(".message-input input").val();
                var ip = '<?= $_SERVER['REMOTE_ADDR'] ?>';
                var newPostKey = firebase.database().ref().child('chats').push().key;
                var idArr = [from_id, to_id];
                idArr = idArr.sort();
                var combine_id = idArr[0] + "_" + idArr[1];
                var x1 = firebase.database().ref('chats/' + newPostKey).set({
                    'message': message,
                    'ip': ip,
                    'from_id': from_id,
                    'to_id': to_id,
                    'from_to_combine_id': combine_id,
                    'current_time': $.now()
                });
                if ($.trim(message) == '') {
                    return false;
                }
                $('.message-input input').val(null);
            }
        </script>

    </body>

</html>