var name = "";
$(document).on("click","#submitBtn",function(){
    name = $("#name").val();
    alert(name);
    $("#name_prompt_parent").fadeOut();
    $("#name").val("");
});
var name="abon duttaroy";
$(document).on('click','#send_button',function(){
    var message = $("#message").val();
    firebase.database().ref('chat/'+Date.now()).set({
        name:name,
        message:message
    });
});
firebase.database().ref("chat/").on('child_added',function(snapshot){
    var postEntry = "<div id='m'>"
            +"<p class='name'>"+snapshot.child("name").val()+"</p>"
            +"<p class='message'>"+snapshot.child("message").val()+"</p>"
            +"</div>";
    $("#messages #m").append(postEntry);
    
});