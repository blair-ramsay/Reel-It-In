<?php session_start();?>
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
    </head>
    <body>
      <?php
      $movie = $_SESSION['movie'];
      echo "<h1>Recommendations Based On '$movie'</h1>";
      ?>

<center>
      <hr>
      <div class="rec" id="rec1">
          <h2 id="header1"></h2>
      </div>
      <!-- <hr> -->
      <div class="rec" id="rec2">
          <h2 id="header2"></h2>
      </div>
      <!-- <hr> -->
      <div class="rec" id="rec3">
          <h2 id="header3"></h2>
      </div>
      <!-- <hr> -->
      <div class="rec" id="rec4">
          <h2 id="header4"></h2>
      </div>
      <!-- <hr> -->
      <div class="rec" id="rec5">
          <h2 id="header5"></h2>
      </div>
      <!-- <hr> -->
      <div class="rec" id="rec6">
          <h2 id="header6"></h2>
      </div>
      <!-- <hr> -->
      <div class="rec" id="rec7">
          <h2 id="header7"></h2>
      </div>
</center>

        <script>
                var apikey = "902cec564338c2cfee10aaacef81033c";

                function getData(movie){
                  movie = movie.toLowerCase();
                  var Director = ["", ""];
                  var Writer = ["", ""];
                  var Composer = ["", ""];
                  var Cinematographer = ["", ""];
                  var Editor = ["", ""];
                  var Lead1 = ["", ""];
                  var Lead2 = ["", ""];
                  //Get the IMDb id of the movie
                  $.getJSON('https://api.themoviedb.org/3/search/movie?api_key=' + apikey + '&query=' + movie).then(function(response){
                      var movieID = response.results[0].id;
                      //Get the credits of the movie
                      $.getJSON('https://api.themoviedb.org/3/movie/' + movieID + '/credits?api_key=' + apikey).then(function(movieCredits){
                          //console.log(movieCredits);
                          for(var i=0; i<movieCredits.crew.length; i++){
                            var job = movieCredits.crew[i].job;
                            if(job === "Director" && Director[0] === ""){
                              Director[0] = movieCredits.crew[i].name;
                              Director[1] = movieCredits.crew[i].id;
                            }
                            if((job === "Screenplay" || job === "Writer" || job==="Author") && Writer[0] === ""){
                              Writer[0] = movieCredits.crew[i].name;
                              Writer[1] = movieCredits.crew[i].id;
                            }
                            if(job === "Original Music Composer" && Composer[0] === ""){
                              Composer[0] = movieCredits.crew[i].name;
                              Composer[1] = movieCredits.crew[i].id;
                            }
                            if(job === "Director of Photography" && Cinematographer[0] === ""){
                              Cinematographer[0] = movieCredits.crew[i].name;
                              Cinematographer[1] = movieCredits.crew[i].id;
                            }
                            if(job === "Editor" && Editor[0] === ""){
                              Editor[0] = movieCredits.crew[i].name;
                              Editor[1] = movieCredits.crew[i].id;
                            }
                          }
                          Lead1[0] = movieCredits.cast[0].name;
                          Lead1[1] = movieCredits.cast[0].id;
                          Lead2[0] = movieCredits.cast[1].name;
                          Lead2[1] = movieCredits.cast[1].id;

                          //Director
                          if(Director[0] !== ""){
                          $.getJSON('https://api.themoviedb.org/3/person/' + Director[1] + '/movie_credits?api_key=' + apikey).then(function(dir){
                            document.getElementById("header1").innerHTML = "Films Also Directed By " + Director[0];
                            var count = 0;
                                for(var i=0; i<dir.crew.length; i++){
                                  var job = dir.crew[i].job;
                                  var popularity = dir.crew[i].popularity;
                                  var rating = dir.crew[i].vote_average;
                                  var title = dir.crew[i].title;
                                  var poster = dir.crew[i].poster_path;
                                  var id = dir.crew[i].id;
                                  if(job === "Director" && popularity > 10.0 && rating >= 6.0 && title.toLowerCase() !== movie && count < 6){
                                    //Recommend Movie
                                    document.getElementById("rec1").innerHTML += '<a href="https://www.themoviedb.org/movie/' + id + '" target="_blank"><div id="1'+title+'" class="movie"></div></a>';
                                    document.getElementById("1"+title).innerHTML += "<img src='https://image.tmdb.org/t/p/w500/" + poster + "' style='width:101px;height:150px;'>";
                                    document.getElementById("1"+title).innerHTML += "<p>" + title + "</p>";
                                    count++;
                                  }
                                }
                                if(count === 0){
                                  document.getElementById("rec1").innerHTML += "<p>Sorry, we couldn't find any results</p>";
                                }
                            });
                            document.getElementById("rec1").innerHTML += "<hr>";
                          }

                          //Writer
                          if(Writer[0] !== ""){
                          $.getJSON('https://api.themoviedb.org/3/person/' + Writer[1] + '/movie_credits?api_key=' + apikey).then(function(writ){
                            document.getElementById("header2").innerHTML = "Films Also Written By " + Writer[0];
                            var count = 0;
                                for(var i=0; i<writ.crew.length; i++){
                                  var job = writ.crew[i].job;
                                  var popularity = writ.crew[i].popularity;
                                  var rating = writ.crew[i].vote_average;
                                  var title = writ.crew[i].title;
                                  var poster = writ.crew[i].poster_path;
                                  var id = writ.crew[i].id;
                                  if((job === "Writer" || job === "Screenplay") && popularity > 10.0 && rating >= 6.0 && title.toLowerCase() !== movie && count < 6){
                                    //Recommend Movie
                                    document.getElementById("rec2").innerHTML += '<a href="https://www.themoviedb.org/movie/' + id + '" target="_blank"><div id="2'+title+'" class="movie"></div></a>';
                                    document.getElementById("2"+title).innerHTML += "<img src='https://image.tmdb.org/t/p/w500/" + poster + "' style='width:101px;height:150px;'>";
                                    document.getElementById("2"+title).innerHTML += "<p>" + title + "</p>";
                                    count++;
                                  }
                                }
                                if(count === 0){
                                  document.getElementById("rec2").innerHTML += "<p>Sorry, we couldn't find any results</p>";
                                }
                            });
                            document.getElementById("rec2").innerHTML += "<hr>";
                          }

                          //Composer
                          if(Composer[0] !== ""){
                          $.getJSON('https://api.themoviedb.org/3/person/' + Composer[1] + '/movie_credits?api_key=' + apikey).then(function(comp){
                            document.getElementById("header3").innerHTML = "Films With Music Composed By " + Composer[0];
                            var count = 0;
                                for(var i=0; i<comp.crew.length; i++){
                                  var job = comp.crew[i].job;
                                  var popularity = comp.crew[i].popularity;
                                  var rating = comp.crew[i].vote_average;
                                  var title = comp.crew[i].title;
                                  var poster = comp.crew[i].poster_path;
                                  var id = comp.crew[i].id;
                                  if(job === "Original Music Composer" && popularity > 10.0 && rating >= 6.0 && title.toLowerCase() !== movie && count < 6){
                                    //Recommend Movies
                                    document.getElementById("rec3").innerHTML += '<a href="https://www.themoviedb.org/movie/' + id + '" target="_blank"><div id="3'+title+'" class="movie"></div></a>';
                                    document.getElementById("3"+title).innerHTML += "<img src='https://image.tmdb.org/t/p/w500/" + poster + "' style='width:101px;height:150px;'>";
                                    document.getElementById("3"+title).innerHTML += "<p>" + title + "</p>";
                                    count++;
                                  }
                                }
                                if(count === 0){
                                  document.getElementById("rec3").innerHTML += "<p>Sorry, we couldn't find any results</p>";
                                }
                            });
                            document.getElementById("rec3").innerHTML += "<hr>";
                          }

                          //Cinematographer
                          if(Cinematographer[0] !== ""){
                          $.getJSON('https://api.themoviedb.org/3/person/' + Cinematographer[1] + '/movie_credits?api_key=' + apikey).then(function(cin){
                            document.getElementById("header4").innerHTML = "Films With Cinematography By " + Cinematographer[0];
                            var count = 0;
                                for(var i=0; i<cin.crew.length; i++){
                                  var job = cin.crew[i].job;
                                  var popularity = cin.crew[i].popularity;
                                  var rating = cin.crew[i].vote_average;
                                  var title = cin.crew[i].title;
                                  var poster = cin.crew[i].poster_path;
                                  var id = cin.crew[i].id;
                                  if(job === "Director of Photography" && popularity > 10.0 && rating >= 6.0 && title.toLowerCase() !== movie && count < 6){
                                    //Recommend Movie
                                    document.getElementById("rec4").innerHTML += '<a href="https://www.themoviedb.org/movie/' + id + '" target="_blank"><div id="4'+title+'" class="movie"></div></a>';
                                    document.getElementById("4"+title).innerHTML += "<img src='https://image.tmdb.org/t/p/w500/" + poster + "' style='width:101px;height:150px;'>";
                                    document.getElementById("4"+title).innerHTML += "<p>" + title + "</p>";
                                    count++;
                                  }
                                }
                                if(count === 0){
                                  document.getElementById("rec4").innerHTML += "<p>Sorry, we couldn't find any results</p>";
                                }
                            });
                            document.getElementById("rec4").innerHTML += "<hr>";
                          }

                          //Editor
                          if(Editor[0] !== ""){
                          $.getJSON('https://api.themoviedb.org/3/person/' + Editor[1] + '/movie_credits?api_key=' + apikey).then(function(ed){
                            document.getElementById("header5").innerHTML = "Films Also Edited By " + Editor[0];
                            var count = 0;
                                for(var i=0; i<ed.crew.length; i++){
                                  var job = ed.crew[i].job;
                                  var popularity = ed.crew[i].popularity;
                                  var rating = ed.crew[i].vote_average;
                                  var title = ed.crew[i].title;
                                  var poster = ed.crew[i].poster_path;
                                  var id = ed.crew[i].id;
                                  if(job === "Editor" && popularity > 10.0 && rating >= 3.0 && title.toLowerCase() !== movie && count < 6){
                                    //Recommend Movie
                                    document.getElementById("rec5").innerHTML += '<a href="https://www.themoviedb.org/movie/' + id + '" target="_blank"><div id="5'+title+'" class="movie"></div></a>';
                                    document.getElementById("5"+title).innerHTML += "<img src='https://image.tmdb.org/t/p/w500/" + poster + "' style='width:101px;height:150px;'>";
                                    document.getElementById("5"+title).innerHTML += "<p>" + title + "</p>";
                                    count++;
                                  }
                                }
                                if(count === 0){
                                  document.getElementById("rec5").innerHTML += "<p>Sorry, we couldn't find any results</p>";
                                }
                            });
                            document.getElementById("rec5").innerHTML += "<hr>";
                          }

                          //Lead 1
                          if(Lead1[0] !== ""){
                          $.getJSON('https://api.themoviedb.org/3/person/' + Lead1[1] + '/movie_credits?api_key=' + apikey).then(function(lead1){
                            document.getElementById("header6").innerHTML = "Films Also Featuring " + Lead1[0];
                            var count = 0;
                                for(var i=0; i<lead1.cast.length; i++){
                                  var popularity = lead1.cast[i].popularity;
                                  var rating = lead1.cast[i].vote_average;
                                  var title = lead1.cast[i].title;
                                  var poster = lead1.cast[i].poster_path;
                                  var id = lead1.cast[i].id;
                                  if(popularity > 10.0 && rating >= 6.0 && title.toLowerCase() !== movie && count < 6){
                                    //Recommend Movie
                                    document.getElementById("rec6").innerHTML += '<a href="https://www.themoviedb.org/movie/' + id + '" target="_blank"><div id="6'+title+'" class="movie"></div></a>';
                                    document.getElementById("6"+title).innerHTML += "<img src='https://image.tmdb.org/t/p/w500/" + poster + "' style='width:101px;height:150px;'>";
                                    document.getElementById("6"+title).innerHTML += "<p>" + title + "</p>";
                                    count++;
                                  }
                                }
                                if(count === 0){
                                  document.getElementById("rec6").innerHTML += "<p>Sorry, we couldn't find any results</p>";
                                }
                            });
                            document.getElementById("rec6").innerHTML += "<hr>";
                          }

                          //Lead 2
                          if(Lead2[0] !== ""){
                          $.getJSON('https://api.themoviedb.org/3/person/' + Lead2[1] + '/movie_credits?api_key=' + apikey).then(function(lead2){
                            document.getElementById("header7").innerHTML = "Films Also Featuring " + Lead2[0];
                            var count = 0;
                                for(var i=0; i<lead2.cast.length; i++){
                                  var popularity = lead2.cast[i].popularity;
                                  var rating = lead2.cast[i].vote_average;
                                  var title = lead2.cast[i].title;
                                  var poster = lead2.cast[i].poster_path;
                                  var id = lead2.cast[i].id;
                                  if(popularity > 10.0 && rating >= 6.0 && title.toLowerCase() !== movie && count < 6){
                                    //Recommend Movie
                                    document.getElementById("rec7").innerHTML += '<a href="https://www.themoviedb.org/movie/' + id + '" target="_blank"><div id="7'+title+'" class="movie"></div></a>';
                                    document.getElementById("7"+title).innerHTML += "<img src='https://image.tmdb.org/t/p/w500/" + poster + "' style='width:101px;height:150px;'>";
                                    document.getElementById("7"+title).innerHTML += "<p>" + title + "</p>";
                                    count++;
                                  }
                                }
                            if(count === 0){
                              document.getElementById("rec7").innerHTML += "<p>Sorry, we couldn't find any results</p>";
                            }
                            });
                            document.getElementById("rec7").innerHTML += "<hr>";
                          }

                      });
                  });

                }

        </script>
        <?php

        echo "<script>getData('$movie');</script>";

        ?>
    </body>
</html>
