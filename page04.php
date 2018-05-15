<?php include'header.php'  ?>
<?php include'massagePageHeader.php'  ?>

<br />

<!--user data form-->
<div class="container" id="formDiv ">
<div class="row">
<form id="idFormUser" style="margin:auto" class="form-inline" action="#">

  <label for="email" style="color:#FFF">Username</label>&nbsp;
  <input type="text" autocomplete="on" required placeholder="type Username" class="form-control" id="userID">&nbsp;
   <button type="submit" class="btn btn-primary">Start Chat</button>&nbsp;&nbsp;&nbsp;
   <span style="color:#F63" id="userError">Oops! Some Error here.</span>
</form>
</div>
</div>
<br />
<br />
<br />

<!-- chat iframe  Start---->

<div id="frame">
  <div id="sidepanel">
    <div id="profile">
      <div class="wrap"> 
        <p>Mike Ross</p>
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
      <ul>
        <li class="contact">
          <div class="wrap"> <span class="contact-status online"></span> 
            <div class="meta">
              <p class="name">Louis Litt</p>
              <p class="preview">You just got LITT up, Mike.</p>
            </div>
          </div>
        </li>
        <li class="contact active">
          <div class="wrap"> <span class="contact-status busy"></span> 
            <div class="meta">
              <p class="name">Harvey Specter</p>
              <p class="preview">Wrong. You take the gun, or you pull out a bigger one. Or, you call their bluff. Or, you do any one of a hundred and forty six other things.</p>
            </div>
          </div>
        </li>
        <li class="contact">
          <div class="wrap"> <span class="contact-status away"></span> 
            <div class="meta">
              <p class="name">Rachel Zane</p>
              <p class="preview">I was thinking that we could have chicken tonight, sounds good?</p>
            </div>
          </div>
        </li>
        <li class="contact">
          <div class="wrap"> <span class="contact-status online"></span> 
            <div class="meta">
              <p class="name">Donna Paulsen</p>
              <p class="preview">Mike, I know everything! I'm Donna..</p>
            </div>
          </div>
        </li>
        <li class="contact">
          <div class="wrap"> <span class="contact-status busy"></span> 
            <div class="meta">
              <p class="name">Jessica Pearson</p>
              <p class="preview">Have you finished the draft on the Hinsenburg deal?</p>
            </div>
          </div>
        </li>
        <li class="contact">
          <div class="wrap"> <span class="contact-status"></span> 
            <div class="meta">
              <p class="name">Harold Gunderson</p>
              <p class="preview">Thanks Mike! :)</p>
            </div>
          </div>
        </li>
        <li class="contact">
          <div class="wrap"> <span class="contact-status"></span> 
            <div class="meta">
              <p class="name">Daniel Hardman</p>
              <p class="preview">We'll meet again, Mike. Tell Jessica I said 'Hi'.</p>
            </div>
          </div>
        </li>
        <li class="contact">
          <div class="wrap"> <span class="contact-status busy"></span> 
            <div class="meta">
              <p class="name">Katrina Bennett</p>
              <p class="preview">I've sent you the files for the Garrett trial.</p>
            </div>
          </div>
        </li>
        <li class="contact">
          <div class="wrap"> <span class="contact-status"></span> 
            <div class="meta">
              <p class="name">Charles Forstman</p>
              <p class="preview">Mike, this isn't over.</p>
            </div>
          </div>
        </li>
        <li class="contact">
          <div class="wrap"> <span class="contact-status"></span> 
            <div class="meta">
              <p class="name">Jonathan Sidwell</p>
              <p class="preview"><span>You:</span> That's bullshit. This deal is solid.</p>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <div id="bottom-bar">
      <button id="addcontact"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> <span>Add contact</span></button>
      <button id="settings"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>Settings</span></button>
    </div>
  </div>
  <div class="content">
    <div class="contact-profile"> 
      <p>Harvey Specter</p>
      <div class="social-media"> <i class="fa fa-facebook" aria-hidden="true"></i> <i class="fa fa-twitter" aria-hidden="true"></i> <i class="fa fa-instagram" aria-hidden="true"></i> </div>
    </div>
    <div class="messages">
      <ul>
        <li class="sent"> 
          <p>How the hell am I supposed to get a jury to believe you when I am not even sure that I do?!</p>
        </li>
        <li class="replies"> 
          <p>When you're backed against the wall, break the god damn thing down.</p>
        </li>
        <li class="replies">
          <p>Excuses don't win championships.</p>
        </li>
        <li class="sent"> 
          <p>Oh yeah, did Michael Jordan tell you that?</p>
        </li>
        <li class="replies">
          <p>No, I told him that.</p>
        </li>
        <li class="replies">
          <p>What are your choices when someone puts a gun to your head?</p>
        </li>
        <li class="sent">
          <p>What are you talking about? You do what they say or they shoot you.</p>
        </li>
        <li class="replies"> 
          <p>Wrong. You take the gun, or you pull out a bigger one. Or, you call their bluff. Or, you do any one of a hundred and forty six other things.</p>
        </li>
      </ul>
    </div>
    <div class="message-input">
      <div class="wrap">
        <input type="text" placeholder="Write your message..." />
        <i class="fa fa-paperclip attachment" aria-hidden="true"></i>
        <button class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
      </div>
    </div>
  </div>
</div>

<?php include'massagePageFooter.php'  ?>
<?php include'footer.php' ?>

