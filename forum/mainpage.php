<?php
    if(empty($_SESSION['signedin']))
    {
      $display_modal_window = 'signin';
      include('startpage.php');
      exit();
    }

?>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Main Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>
  <style>
    html {
      font-size: 75%;
      font-family: "Poppins", sans-serif;
    }
    * {
      box-sizing: border-box;
    }
    body {
      width: 100%;
      height: 100vh;
      background-color: white;
    }
    .heading {
      text-align: center;
      font-size: 4rem;
      margin-bottom: 1rem;
      font-weight: bold;
      margin: 50px 0;
    }
    .heading2{
      text-align: center;
      font-size: 3rem;
      margin-bottom: 1rem;
      font-weight: bold;
      margin: 50px 0;
    }
    .content {
      height: 100vh;
    }
    .menu-icon {
      background-color: #0390fc;
      font-size: 500;
      height: 5rem;
      width: 5rem;
      padding: 1rem;
      border: none;
      color: black;
      position: fixed;
      top: 20px;
      right: 20px;
      transition: transform 0.3s ease-in-out;
    }
    .menu-icon.active {
      transform: translate(-360px);
    }
    .navbar {
      background-color: #0390fc;
      height: 100vh;
      position: fixed;
      top: 0;
      right: 0;
      transform: translate(100%);
      transition: transform 0.3s ease-in-out;
    }
    .navbar.active {
      transform: translate(0);
    }
    .forum-text {
      background-color: yellow;
    }
    .form-input {
      color: black;
      font-family: "Poppins", sans-serif;
      padding: 1.5rem;
      border-radius: 1rem;
      font-size: 1.3rem;
      border: 1px solid #eee;
      background-color: #eee;
      transition: 0.25s linear;
    }
    .label {
      font-size: 2.5rem;
      font-weight: 500;
    }
    .btn {
      border-radius: 1rem;
      text-align: center;
      display: flex;
      justify-content: center;
      align-items: center;
      width: 100%;
      margin: 4rem 0;
      padding: 1.5rem;
      font-size: 1.5rem;
      font-weight: 500;
      cursor: pointer;
      font-family: "Poppins", sans-serif;
      outline: none;
    }
    .profile {
      margin: 0 auto;
      padding: 10px 0 0 0;
    }
    .navbtn {
      transform: translate(60px);
    }
    .profile-nav {
      height: 100px;
      width: 100px;
      display: block;
      margin: 0 auto;
      border-radius: 50%;
      overflow: hidden;
      border: 1px solid #eee;
    }
    .username {
      font-size: 2rem;
      text-align: center;
    }
    #profile-picture {
      width: 100%;
      height: 100%;
    }
    #post-forum-modal, #reply-forum-modal, #edit-forum-modal, #edit-reply-modal{
    display: none;
    position: absolute;
    left: calc(50% - 275px);
    top: 150px;
    z-index: 5;
    width: 600px;
    height: 600px;
    background-color: white;
    border: 2px solid Black;
    text-align: center;
    border-radius: 10px;
    }
    #content, #reply-content, #edit-content, #edit-reply-content{
    width: 80%;
    overflow-wrap: break-word;
    min-height: 25vh;
    border-radius: 10px;
    font-size: medium;
    }
  </style>

  <body>
    <div class="row">
      <div class="content container-fluid">
        <h2 class="heading">Forum</h2>
        <div class="container result-pane" id="result-pane">
        </div>
      </div>

      <div class="menu">
        <button type="button" class="menu-icon" id="hamburgerBtn"></button>
      </div>

      <div class="navbar" id="navbar">
        <div class="container-fluid">
          <form class="form-horizontal profile">
            <div class="profile-nav form-group">
              <?php if (isset($_SESSION['username']) && file_exists('avatar/avatar-'.$_SESSION['username'].'.png')){ ?>
              <img src="avatar/avatar-<?=$_SESSION['username']?>.png" id="profile-picture" />
              <?php } ?>
            </div>
            <br />
            <div class="username font-weight-bold form-group"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : "no account" ;?></div>
          </form>
        </div>

        <div class="container-fluid">
          <form class="form-horizontal navbtn">
            <input type='hidden' name='page' value='MainPage'>
            <div class="form-group home">
              <button type="button" class="btn homeBtn" id="homeBtn">Home</button>  
            </div>

            <div class="form-group">
              <label for="search">Search forum:</label>
              <input
                type="text"
                name="search"
                class="form-control form-input"
                id="search-input"
                placeholder="Please input the term"
              />
              <button
                type="button"
                id="search-button"
                style="
                  text-align: center;
                  margin: 10px auto;
                  border-radius: 10px;
                  padding: 5px 10px;
                  display: flex;
                  justify-content: center;
                  align-items: center;
                "
              >
                Search
              </button>
            </div>

            <div class="form-group">
              <button id="post" class="btn postBtn" type="button">Post Forum</button>
            </div>

            <div class="form-group">
              <button id="display-all" type="button" class="btn sortBtn">Display Forum</button>
            </div>
          </form>
        </div>
      </div>

      <div id='post-forum-modal'>
      <h2 class="heading2">Post Forum!</h2>
      
      <form class="form-horizontal">
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-12">
              <input type="hidden" name="page" value="MainPage">
              <textarea id="content"></textarea>
            </div>  
          </div>
        </div>
        
          <div class="form-group">
            <div class="form-row">
                  <div class="col-md-6 text-left">
                            <input id="backPost" type="button" class="btn" value="Back">
                  </div>
              
                  <div class="col-md-6 text-right">
                             <input id="submitPost" type="button" class="btn" value="Submit">  
                  </div>          
            </div>
          </div>
      </form>
      </div>

      <div id='reply-forum-modal'>
      <h2 class="heading2">Reply</h2>
      
      <form class="form-horizontal">
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-12">
              <input type="hidden" name="page" value="MainPage">
              <input type="hidden" name="id-forums" id="id-forums-reply" value="">
              <input type="hidden" name="id-reply" id="id-reply" value="">
              <textarea id="reply-content"></textarea>
            </div>  
          </div>
        </div>
        
          <div class="form-group">
            <div class="form-row">
                  <div class="col-md-6 text-left">
                            <input id="backReply-" type="button" class="btn" value="Back" onclick="backReply()">
                  </div>
              
                  <div class="col-md-6 text-right">
                             <input id="submitReply-" type="button" class="btn" value="Submit" onclick="submitReply()">  
                  </div>          
            </div>
          </div>
      </form>
      </div>

      <div id='edit-forum-modal'>
      <h2 class="heading2">Edit</h2>
      
      <form class="form-horizontal">
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-12">
              <input type="hidden" name="page" value="MainPage">
              <input type="hidden" name="id" id="id-forums" value="">
              <textarea id="edit-content"></textarea>
            </div>  
          </div>
        </div>
        
          <div class="form-group">
            <div class="form-row">
                  <div class="col-md-6 text-left">
                            <input id="backEdit-" type="button" class="btn" value="Back" onclick="backEdit()">
                  </div>
              
                  <div class="col-md-6 text-right">
                             <input id="submitEdit-" type="button" class="btn" value="Submit" onclick="submitEdit()">  
                  </div>          
            </div>
          </div>
      </form>
      </div>

      <div id='edit-reply-modal'>
      <h2 class="heading2">Edit Reply</h2>
      
      <form class="form-horizontal">
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-12">
              <input type="hidden" name="page" value="MainPage">
              <textarea id="edit-reply-content"></textarea>
            </div>  
          </div>
        </div>
        
          <div class="form-group">
            <div class="form-row">
                  <div class="col-md-6 text-left">
                            <input id="backReplyEdit" type="button" class="btn" value="Back">
                  </div>
              
                  <div class="col-md-6 text-right">
                             <input id="submitReplyEdit" type="button" class="btn" value="Submit">  
                  </div>          
            </div>
          </div>
      </form>
      </div>
    </div>
  </body>
 
  <script>
    var hamBtn = document.getElementById("hamburgerBtn");
    var navbar = document.getElementById("navbar");

    hamBtn.addEventListener("click", displayMenu);

    function displayMenu() {
      navbar.classList.toggle("active");
      hamBtn.classList.toggle("active");
    }


    // Home button

    $("#homeBtn").click(function(){
      $.post("controller.php", {page: "MainPage", command:"Home"}, function(data){
        $('body').html(data);
      });
    });


    // Post function

    $("#post").click(function(){
      $("#post-forum-modal").css("display", "block");
    });

    $("#backPost").click(function(){
      $("#post-forum-modal").css("display", "none");
    });

    $("#submitPost").click(function(){
      $("#post-forum-modal").css("display", "none");
      
      $.post("controller.php", {page: "MainPage", question: $('#content').val(), command:"PostForums"}, function(data, status){
            if(data != "Error")
            { 
                var rows = JSON.parse(data);
                 
                 t = $('#result-pane').html();
                 t += "<br>"
                 t += "<div class='card'>"
                 t += "<div class='card-header insert-name text-left'>"
                 t += "<div style='font-size: 2.5rem; font-weight: 500;'>Username: <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : "no account" ;?></div>"
                 t += "</div>"
     
                 t += "<div class='card-body'>"
                 t += "<table class='table'>"
                 for(var h in rows[0])
                       t += "<th scope='row'>" + h + "</th>"
                 for(var i = 0; i < rows.length; i++){
                       t += "<tr id='" + rows[i]['Id'] +"' scope='row'>";
                       for (var p in rows[i])
                        t += "<td scope='row'>" + rows[i][p] + "</td>";
                      t += "</tr>";
                   }
                 t += "</table>";
                 t += "</div>"
     
                 t += "<div class='card-footer insert-button text-right' style='padding-right: 5rem;'>"
                 t += "<button class='replyBtn' type='button' onclick='addReplyForums(this)'>Reply</button>" + " " + "<button class='editBtn' type='button' onclick='editForums(this)'>Edit</button>" + " " + "<button class='deleteBtn' type='button' onclick='deleteForums(this)'>Delete</button>"
                 t += "</div></div>"
                 t += "<div class='reply' id='reply-"+rows[0]['Id']+"'>"
                 t += "</div>"
                 
                 $('#result-pane').html(t);
            }
            else{
              alert("Forum already existed");
            }
            });
    });

    // Search
    $('#search-button').click(function() {
      $.ajax({
        method: "POST",
        type: "POST", url: "controller.php",
        data: {
          page: 'MainPage',
          search: $("#search-input").val(),
          command: 'SearchForums'
        },
        success: function(result){
          $('#result-pane').html(result);
        }
      });
    });

    // display all
    $('#display-all').click(function() {
      $.ajax({
        method: "POST",
        type: "POST", url: "controller.php",
        data: {
          page: 'MainPage',
          command : 'DisplayAllForums'
        },
        success: function(result){
          $('#result-pane').html(result);
        }
      });
    });

    // reply forum
    function addReplyForums(e){
      var id = $(e).parent().parent().find('td').eq(0).text();
      $("#id-forums-reply").val(id);
      $("#reply-forum-modal").css("display", "block");
    }
    function editReply(id_reply, reply, id_forums_reply){
      $("#id-forums-reply").val(id_forums_reply);
      $("#id-reply").val(id_reply);
      reply = $('#card-reply-'+id_reply).find('td').eq(1).text();
      $("#reply-content").val(reply);
      $("#reply-forum-modal").css("display", "block");
    }
    function backReply(){
      $("#id-forums-reply").val("");
      $("#id-reply").val("");
      $("#reply-content").val("");
      $("#reply-forum-modal").css("display", "none");
    }
    function submitReply(){
      var id_forums = $("#id-forums-reply").val();
      var id_reply = $("#id-reply").val();
      var reply = $("#reply-content").val();
      $.ajax({
        method: "POST",
        type: "POST", url: "controller.php",
        data: {
          page: 'MainPage',
          id_forums: id_forums,
          id_reply: id_reply,
          reply: reply,
          command: 'EditReplyForums'
        },
        success: function(result){
          if(id_reply == ''){
            $('#reply-'+id_forums).append(result);
          }else{
            $('#card-reply-'+id_reply).find('td').eq(1).html(reply);
          }
          backReply();
        }
      });
    }

    // edit forum
    function editForums(e){
      var id = $(e).parent().parent().find('td').eq(0).text();
      $("#id-forums").val(id);
      var forums = $(e).parent().parent().find('td').eq(1).text();
      $("#edit-content").val(forums);
      //edit-content
      $("#edit-forum-modal").css("display", "block");
    }
    function backEdit(){
      $("#id-forums").val("");
      $("#edit-content").val("");
      $("#edit-forum-modal").css("display", "none");
    }
    function submitEdit(){
      var id = $("#id-forums").val();
      var forums = $("#edit-content").val();
      $.ajax({
        method: "POST",
        type: "POST", url: "controller.php",
        data: {
          page: 'MainPage',
          id: id,
          forums: forums,
          command: 'EditForums'
        },
        success: function(result){
          $('#'+id).find('td').eq(1).html(forums);
          backEdit();
        }
      });
    }

    // delete forum
    function deleteForums(e){
      var id = $(e).parent().parent().find('td').eq(0).text();
      $.ajax({
        method: "POST",
        type: "POST", url: "controller.php",
        data: {
          page: 'MainPage',
          id: id,
          command: 'DeleteForums'
        },
        success: function(result){
          $(e).parent().parent().remove();
          $('#reply-'+id).remove();
        }
      });
    }

    // delete reply
    function deleteReply(id_reply){
      $.ajax({
        method: "POST",
        type: "POST", url: "controller.php",
        data: {
          page: 'MainPage',
          id: id_reply,
          command: 'DeleteReplyForums'
        },
        success: function(result){
          $('#card-reply-'+id_reply).remove();
        }
      });
    }

  </script>
</html>