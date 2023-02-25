<?php 
    // Session Required to get api key
    session_start();
    // This will be set at login
    // DEV PURPOSES ONLY
    $_SESSION["API_KEY"] = "validAPIkeyTest";
    $_SESSION['LOGGED_IN'] = false;
?>

<script>
    // Translates PHP variables into js as js more convenient to format document
    var loggedIn_js = 
    <?php 
        if (isset($_SESSION['LOGGED_IN']) && $_SESSION['LOGGED_IN']){
            echo "true"; 
        }else{
            echo "false";
        }
    ?>;
    // Debug
    console.log("Logged in JS: "+loggedIn_js);
</script>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood Tracker Home Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/picnic">
    <link rel="stylesheet" href="./css/mystyles.css">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <!-- script to display mood -->
    <script src = "./js/displayMoodEntries.js"></script>

    <script>
        /* 
        If logged in display personalised banner, else request login
        Only if logged in Load and Display Moods if logged in
        (loggedin is a session variable set at login (along with api-key))
        */
        if(loggedIn_js){
            // Set Banner
            // Load and Display Moods for this user (user id found from session variable set at login, through api-key verification)
            $.ajax({
                url: "http://localhost/Project/src/api/src/getUserMoodEntriesapi.php",
                beforeSend: function(request) {
                    // Setting x-api-key is crucial to access database and find user_id
                    request.setRequestHeader("X-API-KEY", "<?php echo $_SESSION['API_KEY']?>");
                },
                type: "GET",
                dataType: "json",
                success: function (res) {displayMoodEntries(res);},
                error: function (res) {console.log(res);}}) 
        }else{
            // Set Banner
            console.log("Not Logged in")
        }

        </script>
    </script>
</head>
<body>
    <nav>
        <a href="#" class="brand">
          <img class="logo" src="./media/logo.png"/>
          <span>Mood tracker</span>
        </a>
        
        <input id="bmenub" type="checkbox" class="show">
        <label for="bmenub" class="burger success button">Menu</label>
      
        <div class="menu">
           <a href="#" class="pseudo button">Shop</a>
           <a href="#" class="pseudo button">Sign In</a>
           <a href="#" class="pseudo button">Support</a>       
        </div>
    </nav>

    <div id="jumbo">
    </div>

    <div id="container">   
        <div id="dynamic"></div>   
        <div class="flex two three-600 four-1200" id="newrows"></div>
    </div>

</body>
</html>