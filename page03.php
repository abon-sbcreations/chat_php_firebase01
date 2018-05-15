<htm>
    <head>
        <title>
            firebase basic 
        </title>
        <link href="library/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="container-fluid">
                <input type="text" id="userid" name="userid">
                <button id="btnAdd" class="btn btn-info" type="submit">Add</button>
            
        </div>
        <script src="library/js/jquery.min.js" type="text/javascript"></script>
        <script src="library/js/bootstrap.bundle.min.js" type="text/javascript"></script>
        <script src="library/js/5.0.1/firebase-app.js" type="text/javascript"></script>
        <script src="library/js/5.0.1/firebase-database.js" type="text/javascript"></script>
        <script src="assets/js/myfirebase_confs.js" type="text/javascript"></script>
        <script>
            var chatArr = [];
            firebase.initializeApp(firebase_config);
            /*var oneRef = firebase.database().ref().child('chats').child(1); ////
            oneRef.on('value',function(snap){
                console.log(snap.val());
            });*/
            /*var twoRef = firebase.database().ref().child('chats').orderByChild("from_id").equalTo(1);
            twoRef.on('value',function(snap){
               console.log(snap.val()); 
            });*/
            /*var threeRef = firebase.database().ref().child('chats')
                    .orderByKey().limitToFirst(3);
            threeRef.on('value',function(snap){
              console.log(snap.val());
            });*/
            var fourRef = firebase.database().ref().child('chats');//.orderByChild('message').startAt('M')
            fourRef.on('value',function(snap){
              console.log(snap.val());
            });
    
            $(document).on('click','#btnAdd',function(event){
                 var retVal = firebase.database().ref('chats2/4').set({
                     'username':$('#userid').val(),
                     'attr2':'123'
                 });
                 
                console.log(retVal);
               event.preventDefault();
            });
        </script>
    </body>
</htm>