<!DOCTYPE html>
<html lang="en" xmlns:xlink="http://www.w3.org/1999/xlink">
    
     <div id='cssmenu'>
      <ul>
        <li><a href='network.html'><span>Network</span></a></li>
       <li class='active'><a href='lattice.html'><span>Brain Lattice</span></a></li>
       <li><a href='authors.html'><span>Authors</span></a></li>
       <li class='last'><a href='about.html'><span>About</span></a></li>
       <li class="right"><form id ="searchForm" action="author.php" method="get">
       <input id="searchField" name="uid">
       <input type="submit">
       </form></li>
      </ul>
    </div>

    <head>
        <meta charset="utf-8">
        <title>AuthorSynth Brain Lattice</title>
        <script type="text/javascript" src="js/d3.v3.js"></script>
        <script type="text/javascript" src="js/tipsy.js"></script>
        <script type="text/javascript" src="js/jquery-1.11.0.js"></script>

        <!-- Bootstrap for Styling -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script src="js/modernizr.custom.js"></script>
        <script src="js/canvasXpress.min.js"></script>

        <!-- CSS concatenated and minified via ant build script-->
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <!-- end CSS-->

       <!-- Jquery -->
       <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
       <script src="//code.jquery.com/jquery-1.10.2.js"></script>
       <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>

        <!-- Custom Styling -->
        <style type="text/css">

            text {
                font-family: sans-serif;
                font-size: 10px;
                fill: black;
            }

            h1 {
                color: #666;
                padding-top:30px;
                padding-bottom:30px;

            }
            h6 {
                color: #fff;
            }
            .boxes {
                text-align: center;
                color: #fff;
                margin-top:30px;
                font-weight: bold;
                padding-top:5px;
                padding-bottom:5px;
            }

            .container {
                margin-left: 80px;
            }

            .d3-tip {
              line-height: 1;
              font-weight: bold;
              padding: 12px;
              background: rgba(0, 0, 0, 0.8);
              color: #fff;
              border-radius: 2px;
            }

            /* Creates a small triangle extender for the tooltip */
            .d3-tip:after {
              box-sizing: border-box;
              display: inline;
              font-size: 10px;
              width: 100%;
              line-height: 1;
              color: rgba(0, 0, 0, 0.8);
              content: "\25BC";
              position: absolute;
              text-align: center;
            }

            /* Style northward tooltips differently */
            .d3-tip.n:after {
              margin: -1px 0 0 0;
              top: 100%;
              left: 0;
            }

           /* Here is for the mouse over effect */
           ul.enlarge {
              list-style-type:none; /*remove the bullet point*/
           }
           ul.enlarge li {
             display:inline-block; /*places the images in a line*/
             position: relative; 
             z-index: 0; 
             margin:10px 10px 5px 5px; /*space between the images*/
           }

           ul.enlarge span{
             position:absolute; /*see support section for more info on positioning*/
             left: -9999px; /*moves the span off the page, effectively hidding it from view*/
           }

           ul.enlarge img{
             background-color:#eae9d4; /*frame colour*/
             padding: 6px; /*frame size*/
              -webkit-box-shadow: 0 0 6px rgba(132, 132, 132, .75);
              -moz-box-shadow: 0 0 6px rgba(132, 132, 132, .75);
               box-shadow: 0 0 6px rgba(132, 132, 132, .75);
               -webkit-border-radius: 4px;
               -moz-border-radius: 4px; 
                border-radius: 4px;
           }

          ul.enlarge li:hover{
             z-index: 50; 
             cursor:pointer; /*changes the cursor to a hand*/
           }
          ul.enlarge li:hover span{ 
             top: -300px; 
             left: -20px; 
          }
          ul.enlarge li:hover:nth-child(2) span{
             left: -100px; 
          }
          ul.enlarge li:hover:nth-child(3) span{
             left: -200px; 
          }

          ul.enlarge span img{
             padding: 2px; /*size of the frame*/
             background: #FAFAFA; /*colour of the frame*/
          }
          
          ul.enlarge span{
             padding: 10px; /*size of the frame*/
             background:#FAFAFA; /*colour of the frame*/
               -webkit-box-shadow: 0 0 20px rgba(0,0,0, .75));
               -moz-box-shadow: 0 0 20px rgba(0,0,0, .75);
                box-shadow: 0 0 20px rgba(0,0,0, .75);
               -webkit-border-radius: 8px;
               -moz-border-radius: 8px;
                border-radius:8px;
                font-family: 'Droid Sans', sans-serif; /*Droid Sans is available from Google fonts*/
                font-size:.9em;
                text-align: center;
                color: #495a62;
}

        </style>

    </head>
    <body>

<script type="text/javascript">

$(function() {
    // Read in the authors.json file
    var json = (function () {
        var json = null;
        $.ajax({
            'async': false,
            'global': false,
            'url': "data/authors.json",
            'dataType': "json",
            'success': function (data) {
                json = data;
            }
        });
        return json;
    })(); 

    $( "#searchField" ).autocomplete({
      source: json,
      select: function(event, ui) {
        console.log(ui); 
        $("#searchField").val(ui.item.label);
        }
    });
  });

</script>


        <div class="container">
            <div class="row">

                  <h1 style="padding-left:30px; padding-top:50px;">Matched Authors</h1>
                  <p style="padding-left:30px;">Below are the top authors matched to the node you selected, with a Z score > 1.96 for all match scores.  The search is limited to return 50 results.</p>

<!-- The pop up effect is done by putting the images in a list-->
<ul class="enlarge">

<!--Here we need to select data based on the author UID from the browser-->

<?php
        // if pid variables exist
        if($_GET) {
                $uid = htmlspecialchars($_GET['uid']);
        }
        // if we have a uid
         if($uid) {
            $uid = explode(",", $uid);
            foreach ($uid as $u) {
               echo "<li><a href=\"author.php?uid=" . $u . "\"><img src=\"img/brainlatticethumb/" . $u . ".png\" width=100px/></a>\n<span>\n<a href=\"author.php?uid=" . $u . "\"><img src=\"img/brainlatticethumb/" . $u . ".png\" /></a>\n</span></li>";
            }
        } 
        // if we don't'
        else {
                echo "<p>Please Specify a valid set of author uids!</p>\n";
        }
?>
</ul><!-- End list -->
     </div><!-- End row -->

        </div><!-- End container -->
    </body>
</html>
