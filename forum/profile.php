
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile</title>
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
      display: flex;
      align-items: center;
      justify-content: center;
      background-image: linear-gradient(
        to right top,
        #0390fc,
        #ffc781,
        #fffefc
      );
    }
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .profile {
      width: 100%;
      max-width: 50rem;
      border-radius: 10px;
      background-color: white;
      padding: 8rem 3.5rem;
      display: block;
    }
    .profile-picture {
      height: 200px;
      width: 200px;
      display: block;
      margin: 0 auto;
      transform: translate(0, -50px);
      border-radius: 50%;
      overflow: hidden;
      border: 1px solid #eee;
    }
    #picture {
      height: 100%;
      width: 100%;
    }
    #upload-picture {
      display: none;
    }
    #uploadBtn {
      height: 60px;
      width: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      text-align: center;
      color: black;
      background-color: grey;
      font-family: "Poppins", sans-serif;
      font-size: 1rem;
      cursor: pointer;
    }
    .form-profile {
      border-radius: 1rem;
      text-align: center;
      display: flex;
      justify-content: center;
      align-items: center;
      width: 100%;
      margin: 2.5rem 0;
      padding: 1.5rem;
      font-size: 1.5rem;
      font-weight: 500;
      outline: none;
      cursor: pointer;
      font-family: "Poppins", sans-serif;
    }
    #return:hover {
      outline: transparent;
    }
    #logout:hover {
      background-color: #0390fc;
      color: black;
    }
    #delete-user:hover {
      background-color: #cc2e23;
      color: black;
    }
  </style>
  <body>
    <div class="container">
      <div class="profile">
        <div class="profile-picture form-group">
          <?php if (isset($_SESSION['username']) && file_exists('avatar/avatar-'.$_SESSION['username'].'.png')){ ?>
          <img src="avatar/avatar-<?=$_SESSION['username']?>.png" id="picture" />
          <?php }else{ ?>
          <img src="" id="picture" />
          <?php } ?>
          <form id="profile-form" enctype="multipart/form-data">
            <input type="hidden" name="page" value="picture">
            <input type="file" id="upload-picture" name="picture">
            <label for="upload-picture" id="uploadBtn">Choose Photo</label>
          </form>
          <div><?php echo isset($_SESSION['username']) ? "username: " . $_SESSION['username'] : "no account" ;?></div>
        </div>

        <form class="form-horizontal profile-form">
          <input type='hidden' name='page' value='Profile'>
          <div class="return form-group">
            <button type="button" class='btn form-profile' id="return">Return</button> 
          </div>
          <div class="logout form-group">
            <button type="button" class='btn form-profile' id="logout" name="command" value="LogOut">Log Out</button>
          </div>
          <div class="form-group">
            <hr />
          </div>
          <div class="delete-user form-group">
            <button type="button" class='btn form-profile' id="delete-user">Delete Account</button>
          </div>
        </form>
      </div>
    </div>

    <script>
      $('#return').click(function() {
        $.post("controller.php", {page: "Profile", command:"Return"}, function(data){
          $('body').html(data);
      });
      });

      $('#logout').click(function() {
        $('.profile-form').submit();
      });

      $('#delete-user').click(function() {
        $.post("controller.php", {page: "Profile", command:"DeleteAccount"}, function(data){
          $('body').html(data);
      });
      });

    // Avatar
    $('#upload-picture').change(function(){
      if(document.getElementById('upload-picture').files.length != 0){
            var formData = new FormData(document.getElementById('profile-form'));
            $.ajax({
              url: 'controller.php',
              type: 'POST',
              data: formData,
              processData: false,
              contentType:false,
              success: function(data){  
                setTimeout(function(){
                  location.reload();
                  location.reload();
                }, 1000);    
              }
            })
      }
      })

    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#picture').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);

        // upload picture file
        var formData = new FormData();
        formData.append('page', 'picture');
        formData.append('picture', $('#upload-picture')[0].files[0]);

        $.ajax({
              url : 'controller.php',
              type : 'POST',
              data : formData,
              processData: false,  // tell jQuery not to process the data
              contentType: false,  // tell jQuery not to set contentType
              success : function(data) {
                  console.log(data);
              }
        });
      }
    }
    </script>
    
  </body>
</html>