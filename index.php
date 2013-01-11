<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Rss Feeds Reader</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="bootstrap/css/tablecloth.css" rel="stylesheet">
    <link href="bootstrap/css/prettify.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link rel="icon" href="bootstrap\img\logo.ico" type="image/x-icon">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .crop { width: 200px; height: 200px; overflow: hidden;}
    </style>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script type="text/javascript" src="js/slide.js"></script>
  </head>
  <body>
    <?php
      include("header.html"); // include header file 
    ?>
    <div class="container">
    <?php
      require_once("class.ReadRSS.php"); // include file for read rss feeds
      if(isset($_POST["URL"])|| isset($_GET["URL"])){   
            if(isset($_POST["URL"]))
               $url=trim($_POST["URL"]);
            else
              $url=trim($_GET["URL"]);
            
            $r= new ReadRSS();
            $ret=$r->validateFeed($url); // check enter url
            if($ret!=false) 
             {
                  $url=$ret;
                  echo "<h3><sapn class=\"span9\" >Rss Feeds Name :-  <a href=$url>";
                  echo $r-> getRssFeedTitle($url)."</a>"; // get Rss Feed Ttile 
    ?>
      </sapn>
        </h3>
          <a class="btn" href="javascript:void(viewer.show(0))">Slideshow</a> 
    <?php
                  echo "<a class='btn' href='pdf.php?url=$url'>Download PDF</a>";
                  $list=$r->getFeeds($url);
    ?>
          <br><br>
          <table cellspacing="1" cellpadding="3" class="tablehead" style="background:#CCC;">
            <thead> 
              <tr class="colhead">
                <th class="{sorter: false}">Titles</th>
                <th class=\"{sorter: false}\">Images</th>
              </tr>
            </thead>
            <tbody>
    <?php
                  $i=1;
                  foreach ($list as $key ) { // iterate array of image url, title , summay 
                    $v=($i%2==0)?'evenrow':'oddrow';
                    echo   "<tr class=".$v.">";
                    echo "<td ><h3><a style\"font-weight:bold,font-size:150%;\" href='$key[1]' >$key[0]</a></h3>";
                    echo substr($key[3], 0,300)."....</td>";
                    echo "<td><div class=\"crop\"><img src='$key[2]'></div> </td><tr>";
                    $i++;
                   }
    ?> 
            </tbody>
          </table>
      <script type="text/javascript">
        var viewer = new PhotoViewer();
    <?php
                  foreach ($list as $key ) { //iterate array of image url
                    $key[0]=str_replace('"', "", $key[0]);
                    $key[0]=str_replace("'", "", $key[0]);
                    echo   "viewer.add('$key[2]','<b><a href= \"$key[1]\">$key[0]</a></b>');\n";
                  }
    ?>
        viewer.disableEmailLink(); 
        viewer.disablePanning();
        viewer.enableAutoPlay();
        viewer.enableLoop();
      </script>

    <?php
            }
            else
            {
    ?>
      <h1>Not Valid RSS Feeds URL</h1>
      <form class="navbar-form pull-left" action="index.php" method="post">
          <input class="span3" type="text" id="url1" name="URL"placeholder="Enter Rss Feeds URL">
          <button type="submit" class="btn" id="Read1">Read</button>
      </form>
    <?php
            }
        }
        else
        { 
    ?>
        <h1>Enter RSS Feeds URL</h1>
        <form class="navbar-form pull-left" action="index.php" method="post">
             <input class="span3" type="text" id="url1" name="URL"placeholder="Enter Rss Feeds URL">
             <button type="submit" class="btn" id="Read1">Read</button>
        </form>
    <?php
        }
    ?>
      
        <footer>
          <p></p>
        </footer>
    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/jquery.tablecloth.js"></script>
    <script src="bootstrap/js/jquery.metadata.js"></script>
    <script src="bootstrap/js/jquery.tablesorter.min.js"></script>
    <script type="text/javascript">
    $(function(e){
        $("table").tablecloth({ theme: "dark",
          striped: true,
          sortable: true,
          condensed: true
           });
    })
    $("#Read1").click(function(e){
        $txtval=$("#url1").val();
        if($txtval=='') // check if textbox is empty or not
        {
          alert("Enter URL...")
          e.preventDefault(); // prevent form submission
          return false;
        }  
        if(($txtval.indexOf("."))==-1)
        {    alert("Not A Valid URL");
            e.preventDefault(); // prevent form submission
        }
        
    });
    $("#Read").click(function(e){
        $txtval=$("#url").val();
        if($txtval=='') // check if textbox is empty or not
        {
          alert("Enter URL...");
          e.preventDefault(); // prevent form submission
          return false;
        }  
        if(($txtval.indexOf("."))==-1) 
        {    alert("Not A Valid URL");
            e.preventDefault(); // prevent form submission
        }
        
    });
    </script>
  </body>
</html>
