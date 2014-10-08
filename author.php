<!DOCTYPE html>
<html lang="en" xmlns:xlink="http://www.w3.org/1999/xlink">
    
     <div id='cssmenu'>
      <ul>
        <li><a href='network.html'><span>Network</span></a></li>
       <li><a href='lattice.html'><span>Brain Lattice</span></a></li>
       <li class='active'><a href='authors.html'><span>Authors</span></a></li>
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

            <h1 style="padding-left:30px;">Author Brain Lattice</h1>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li class="active"><a href="#brain" role="tab" data-toggle="tab">Brain Lattice</a></li>
              <li><a href="#collab" role="tab" data-toggle="tab">Collaborators</a></li>
              <li><a href="#pubs" role="tab" data-toggle="tab">Publications</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">

              <!-- BRAIN LATTICE -->
              <div class="tab-pane active" id="brain"></div>
              <h8>Download here</h8>

              <!-- COLLABORATIONS -->
              <div class="tab-pane" id="collab">
                <br><br>
                <p>Below is a list of neuroscientists, ordered by similarity of published regional activation.  The position of the point from left to right represents this similarity score - with scores toward the left corresponding to more overlap in published regional activation, and scores to the right corresponding to less overlap in published activation points.  The size of the point reflects an "enrichment score" - the percentage of neuroscientists up to that point that the author in question has actually worked with (as determined by being on one or more papers together in the NeuroSynth database).  A red point indicates an actual coauthor, and at these points the collaboration score jumps.  You can click on the circles to view the collaborator page.</p><br><h2 style="padding-left:150px;">Most Similar</h2>
                <match></match>
                <style type="text/css">
                  .axis path,.axis line {fill: none;stroke:#b6b6b6;shape-rendering: crispEdges;}
                  .tick text{fill:#666;} 
                  g.journal.active{cursor:pointer;}
                </style>

                <script type="text/javascript">

//Here we need to select data based on the author UID from the browser
<?php
        // if pid variables exist
        if($_GET) {
                $uid = htmlspecialchars($_GET['uid']);
        }
        // if we have a uid
         if($uid) {
                  echo "d3.tsv(\"data/matchscores/" . $uid . "_match.tsv\", function(error, scores) {\n";
                  
        } 
        // if we don't'
        else {
                echo "<p>Please Specify a valid author uid!</p>\n";
        }
?>


                // This function will truncate a string
                function truncate(str, maxLength, suffix) {
                if(str.length > maxLength) {
                   str = str.substring(0, maxLength + 1); 
                   str = str.substring(0, Math.min(str.length, str.lastIndexOf(" ")));
                   str = str + suffix;
                }
                return str;
                }

                var margin = {top: 20, right: 200, bottom: 0, left: 100},
                   width = 300,
                   height = 2100;

                var start_score = 0,
                    end_score = 1;

                var c = d3.scale.category20c();

                var x = d3.scale.linear()
                    .range([0, width*1.5]);

                var xAxis = d3.svg.axis()
                    .scale(x)
                    .orient("top");

                var formatYears = d3.format("0000");
                    xAxis.tickFormat(formatYears);

                var msvg = d3.select("match").append("svg")
                   .attr("width", width + margin.left + margin.right)
                   .attr("height", height + margin.top + margin.bottom)
                   .style("margin-left", margin.left + "px")
                   .append("g")
                   .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

                   // Here we get the authors maximum match score, and the index acquired
                   
                   // Truncate data to only include 100 authors
                   scores = scores.slice(0,100);

                    if(error){
                        return console.log(error);
                    }

                    // Here we get the maximum and minimum match scores
                    var maxscore = 0;
                    var minscore = 999;
                    for (var j = 0; j < scores.length; j++) {
                       maxscore = Math.max(maxscore,Number(scores[j]["MATCHSCORE"]));
                       minscore = Math.min(minscore,Number(scores[j]["MATCHSCORE"]));
                    };

                    // This will scale the radius
                    var rScale = d3.scale.linear()
                       .domain([minscore, maxscore])
                       .range([5, 15]);

                    // This will scale the scores at the correct value on the plot
                    x.domain([start_score, end_score]);
                    var xScale = d3.scale.linear()
                    .domain([0, 1])
                    .range([0, width]);

//                    msvg.append("g")
 //                   .attr("class", "x axis")
 //                   .attr("transform", "translate(0," + 0 + ")")
 //                   .call(xAxis);

                    var circles = msvg.selectAll("circle")
                         .data(scores)
                         .enter()
                         .append("svg:a")
                         .attr("xlink:href", function(d){ return "author.php?uid="+ d["UUIDS"]})
                         .append("circle")
                         .attr("cx", function(d,i){ return xScale(d["MATCHSCORE"]); })
                         .attr("cy", function(d,i) { return i*20+20 } )
                         .attr("r", function(d,i) { return rScale(d["RUNNING_SCORE"])})
                         .style("fill", function(d) { 
                             if (d["ACTUAL_COLLABORATOR"] == "0"){ return "orange"}
                             else { return "red"}
                         })



                    for (var j = 0; j < 100; j++) {
                      var g = msvg.append("g");

                      // Here is the list of collaborators down the right of the page
                      var text = g.selectAll("text")
                         .data(scores[j]['COLLABORATOR'])
                         .enter()
                         .append("text");

                      // TO DO - make so mouseover we can get the score / link to collaborator
                      text
                        .attr("y", j*20+25)
                        .attr("x",function(d, i) { return xScale(d[0])-5; })
                        .attr("class","value")
                        .text(function(d){ return d[1]; })
                        .style("fill", function(d) { return c(j); })
                        .style("display","none");

                      g.append("text")
                        .attr("y", j*20+25)
                        .attr("x",-100)
                        .attr("class","label")
                        .text(truncate(scores[j]['COLLABORATOR'],30,"..."))
                        .style("fill", function(d) { return c(j); });
                        
                        //.on("mouseover", mouseover)
                        //.on("mouseout", mouseout);
                      };

                     function mouseover(p) {
                       var g = d3.select(this).node().parentNode;
                       d3.select(g).selectAll("circle").style("display","none");
                       d3.select(g).selectAll("text.value").style("display","block");
                     }

                    function mouseout(p) {
                      var g = d3.select(this).node().parentNode;
                      d3.select(g).selectAll("circle").style("display","block");
                      d3.select(g).selectAll("text.value").style("display","none");
                     }
});
</script>


              </div>

              <!-- PUBLICATIONS -->
              <div class="tab-pane" id="pubs">
                <br><br>
                <p>Here we should have links to publications for each author - or actually, it would be most transparent to have the actual coordinates and paper links that are used in the NeuroSynth database (the ones to create the map!)</p>
               <!-- We will use d3 to stick stuff here -->
               <table class="table table-hover">
                 <thead></thead>
                 <tbody></tbody>
                </table>
                <!-- Here is our brain coordinate image -->
                <h3>Publication Activation Coordinates</h3>
                <canvas id='canvas1' width='540' height='540'></canvas>
                <script type="text/javascript">

                // This function will determine if an array contains a value
                Array.prototype.contains = function(v) {
                  for(var i = 0; i < this.length; i++) {
                    if(this[i] === v) return true;
                  }
                  return false;
                };

                Array.prototype.unique = function() {
                  var arr = [];
                    for(var i = 0; i < this.length; i++) {
                      if(!arr.contains(this[i])) {
                        arr.push(this[i]);
                    }
                   }
                   return arr; 
                }

<?php
        // if we have a uid
         if($uid) {
                  echo "d3.tsv(\"data/publications/" . $uid . "_pubs.txt\", function(error, pubs) {\n";
                  
        } 
        // if we don't'
        else {
                echo "<p>Please Specify a valid author uid!</p>\n";
        }
?>

                   
                  // Function to get unique values from arrays
                  var arrayUnique = function(a) {
                    return a.reduce(function(p, c) {
                      if (p.indexOf(c) < 0) p.push(c);
                          return p;
                      }, []);
                   };

                   // Keep unique papers, titles, pmids
                   var titles = [];
                   var pmid = [];
                   var coauthors = [];
                   var xyz = [];
                   
                    // Save what we need, delete, and keep XYZ coordinates
                    pubs.forEach(function(d) {
                        titles.push(d["TITLE"]);
                        xyz.push([Number(d["X"]),Number(d["Y"]),Number(d["Z"])]);
                        delete d["TITLE"];
                        delete d["JOURNAL"];
                        pmid.push(d["PMID"]);
                        delete d["PMID"];
                        delete d["YEAR"];
                        coauthors.push(d["COAUTHORS"]);
                        delete d["COAUTHORS"];
                        delete d["AUTHOR"];
                        delete d["DOI"];
                    })

                    // Make unique!
                    utitles = arrayUnique(titles);
                    coauthors = arrayUnique(coauthors);
                    pmid = arrayUnique(pmid);

                    // Put into one object
                    var final = [];
                    for (i = 0; i < utitles.length; i++) { 
                      var tmp = {title:utitles[i], coauthors:coauthors[i],pmid:pmid[i]};
                    final.push(tmp);
                    };
                    var header = ["TITLE","AUTHORS","PUBMED"];

                    // Write to a table
                    var th = d3.select("thead").selectAll("th")
                           .data(header)
                           .enter().append("th")
                           //.attr("onclick", function (d, i) { return "transform('" + d + "');";})
                           .text(function(d) { return d; })

                    // Rows
                    var tr = d3.select("tbody").selectAll("tr")
                          .data(final)
                          .enter().append("tr")

                     // Cells
                     var td = tr.selectAll("td")
                            .data(function(d) { return jsonToArray(d); })
                            .enter().append("td").append("a")
                            .attr("href", function(d) { 
                               if (d[0] == "pmid"){
                                 return "http://www.ncbi.nlm.nih.gov/pubmed/" + d[1] }})
                            .text(function(d) { return d[1]; });

                // We will render brain points with canvas express
                var cx1 = new CanvasXpress('canvas1',
                {
            'y' : {
              'vars' : titles,
              'smps' : ['X', 'Y', 'Z'],
              'data' : xyz
            }
},
          {'graphType': 'Scatter3D',
          'xAxis': ['X'],
          'yAxis': ['Y'],
          'zAxis': ['Z'],
          'imageDir': "http://canvasxpress.org/images/"}
        );

                    
                    // Return any errors
                    if(error){
                        return console.log(error);
                    }

                    function stringCompare(a, b) {
                        a = a.toLowerCase();
                        b = b.toLowerCase();
                        return a > b ? 1 : a == b ? 0 : -1;
                    }

                    function jsonKeyValueToArray(k, v) {return [k, v];}

                    function jsonToArray(json) {
                        var ret = new Array();
                        var key;
                        for (key in json) {
                            if (json.hasOwnProperty(key)) {
                              test = jsonKeyValueToArray(key, json[key]);
                              ret.push(test);
                            }
                        }
                       return ret;
                    };

           });

                </script>
              </div>
            </div>
                <script type="text/javascript">


                // Set height and width
                h = 1200;
                w = 1200;

                // Create canvas
                svg = d3.select(".tab-pane")
                    .append("svg")
                    .attr("height",h)
                    .attr("width",w)
           
                // This is a function for tooltips
                var tip = d3.tip()
                    .attr('class', 'd3-tip')
                    .offset([-10, 0])
                    .html(function(d) {

                        // Parse each of our terms
                        var terms = d.TERMS.split("|");
                        terms = terms.join("<br>")

                        if (terms.length == 0) {
                        return "<span style='color:tomato'>No Matched Terms</span>"
                        } else { 
                        return "<span style='color:yellow'>" + terms + "</span>";
                        }
                    })

                // Call tooltips function
                svg.call(tip);

<?php
        // if pid variables exist
        if($_GET) {
                $uid = htmlspecialchars($_GET['uid']);
        }
        // if we have a uid
         if($uid) {
                  echo "d3.tsv(\"data/brainlattice/" . $uid . "_lattice.tsv\", function(error, data) {\n";
                  
        } 
        // if we don't'
        else {
                echo "<p>Please Specify a valid author uid!</p>\n";
        }
?>

                    data.forEach(function(d) {
                        //console.log(d);
                    })
                    // Return any errors
                    if(error){
                        return console.log(error);
                    }

                    // Create a square for each data element
                    var rects = svg.selectAll("rect")
                        .data(data)
                        .enter() 
                        .append("svg:rect");
                    
                    // Here we add the author name to the Header
                    h1 = d3.select("h1")
                        .data(data)
                        .html(function(d){ return d.AUTHOR });

                    // Here we add the author name to the Header
                    braintext = d3.select("h8")
                        .data(data)
                        .html(function(d){ return '<a href="img/brainlattice/' + d.UUID  + '.png"> download </a>'});

                    // Now let's add the rect attributes
                    var rectAttributes = rects
                        .attr("y",function(d,i){ return 50*d.Y })
                        .attr("x",function(d,i){ return 50*d.X })
                        .attr("width", 50)
                        .attr("height",50)
                        .attr("fill",function(d,i){ return d.COLOR})
                        //.attr("stroke",function(d) {if (d.PROCESS == "DONE") {return "#0066FF"} else   { return "orange" } ;}) 
                        //.attr("stroke-width",10)
                        .attr("transform","translate(60,40)")
                        .on('mouseout.tip', tip.hide)
                        .on('mouseover.tip', tip.show)
                        .on('mouseover.color', function(d) {
                            d3.select(this).style("fill", "red");
                        })
                        .on('mouseout.color', function(d) {
                            d3.select(this).style("fill", function(d){ return d.COLOR });
                        })
                        .on('mouseover.size', function(d) {
                            d3.select(this).attr("r", 15);
                        })
                        .on('mouseout.size', function(d) {
                            d3.select(this).attr("r", 10);
                        });

                      // Add the text to the svg container
                      var text = svg.selectAll("text")
                          .data(data)
                          .enter()
                          .append("text");
 
                       // Now define text attributes
                      var textAttributes = text
                          .attr("x", function(d) { return 50*d.X + 65; })
                           .attr("y", function(d) { return 50*d.Y + 70; })
                           // here is how to debug position
                           //.text( function (d) { return "( " + d.X + ", " + d.Y +" )"; })
                           .attr("font-family", "sans-serif")
                           .attr("font-size", "1px")
                           .attr("fill", "red")
                           //Here is the link to similar authors!
                           .append("svg:a")
                           .attr("xlink:href", function(d){return "brainlattice.php?uid=" + d.UIDS;})
                           .text(function(d) {
                            var terms = d.TERMS.split("|");
                            //just render the first
                            return terms[0]; });

                        //.transition()
                        //.attr("x",10)

                    }); // End of file
                   
                </script>
            </div><!-- End row -->

        </div><!-- End container -->
    </body>
</html>
