<?php ob_start();?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Reel It In</title>
        <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    </head>
    <body>
      <h1>Reel It In</h1>
      <h3>Enter the name of a movie you like to get some recommendations</h3>
      <form name="myForm" method="post"><br><br>
        <input class="movieInput" type="text" name="movie">
        <br><br>
        <input class="submit" type="submit" name="submit" value="GO">
      </form>
      <p>
        Please Note:
        This website uses TMDB to access film information, and as a result all data<br>
        retrieved is based on content from TMDB. The information presented is restricted<br>
        by what is available from TMDB.<br>
        Credit given to <a href="https://www.themoviedb.org/?language=en" target="_blank">The Movie Database</a>
      </p>
<?php
    if(isset($_POST["submit"])){
      $movie = $_POST["movie"];
      if ($movie === "" || $movie === undefined) {
        //Do Nothing
      }else{
      session_start();
      $_SESSION['movie'] = $movie;
      header('Location: recommend.php');
      ob_end_flush();
    }
    }
?>

    </body>
</html>
