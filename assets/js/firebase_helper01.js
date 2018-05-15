var mainText = $("#mainText");
var submitBtn = $("#submitBtn");
var fireHeading = $("#fireHeading");
$(document).ready(function(){
    fireHeading.val("abcd");
});
var fireHeadingRef = firebase.database().ref().child("pageHeading");
fireHeadingRef.on('value',function(dataSnapShot){
    fireHeading.html(dataSnapShot.val());
});
$(document).on("click","#submitBtn",function(){
    var firebaseRef = firebase.database().ref();
    firebaseRef.push().set(mainText.val());
    mainText.val("");
});