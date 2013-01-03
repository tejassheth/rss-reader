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
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
      <link rel="icon" href="bootstrap\img\logo.ico" type="image/x-icon">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

   
    <script type="text/javascript" src="js/slide.js"></script>
  </head>
  <body>
    <?php
    include("header.html");
    ?>
    <div class="container">

      <?php
       if(isset($_POST["URL"])|| isset($_GET["URL"]))
        {   
            if(isset($_POST["URL"]))
               $url=trim($_POST["URL"]);
            else
              $url=trim($_GET["URL"]);

            require_once("class.ReadRSS.php");
            $r= new ReadRSS();
            $ret=$r->validateFeed($url);
            if($ret!=false)
             {
                  $url=$ret;
                echo  "<h3><sapn class=\"span9\" >Rss Feeds Name :-  <a href=$url >".$r-> getRssFeedName($url);
                echo "</a></sapn></h3><a class=\"btn\" href=\"javascript:void(viewer.show(0))\">Slideshow</a>          <a class=\"btn\" href=\"pdf.php?url=$url\">Download PDF</a>";
                $list=$r->getFeeds($url);
                echo "<br><br><table cellspacing=\"1\" cellpadding=\"3\" class=\"tablehead\" style=\"background:#CCC;\"><thead> <tr class=\"colhead\"><th class=\"{sorter: false}\">Titles</th><th class=\"{sorter: false}\">Images</th></tr></thead><tbody>";
                $i=1;
                foreach ($list as $key ) {
                    $v=($i%2==0)?'evenrow':'oddrow';
                    echo   "<tr class=".$v."><td ><a style\"font-weight:bold,font-size:150%;\" href='$key[1]' >$key[0]</td><td><img src='$key[2]' height=100 width=100> </td><tr>";
                    $i++;
                }
                echo "</tbody></table>";
                 ?>   
            <script type="text/javascript">
              var viewer = new PhotoViewer();
            <?php
                        foreach ($list as $key ) {
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
            {?>
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
         <h1>Not Valid RSS Feeds URL</h1>
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
    <script src="bootstrap/js/bootstrap-transition.js"></script>
    <script src="bootstrap/js/bootstrap-alert.js"></script>
    <script src="bootstrap/js/bootstrap-modal.js"></script>
    <script src="bootstrap/js/bootstrap-dropdown.js"></script>
    <script src="bootstrap/js/bootstrap-scrollspy.js"></script>
    <script src="bootstrap/js/bootstrap-tab.js"></script>
    <script src="bootstrap/js/bootstrap-tooltip.js"></script>
    <script src="bootstrap/js/bootstrap-popover.js"></script>
    <script src="bootstrap/js/bootstrap-button.js"></script>
    <script src="bootstrap/js/bootstrap-collapse.js"></script>
    <script src="bootstrap/js/bootstrap-carousel.js"></script>
    <script src="bootstrap/js/bootstrap-typeahead.js"></script>
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
        if($txtval=='')
        {
          alert("Enter URL...")
          e.preventDefault();
          return false;
        }  
        isUrl($txtval);
        if(($txtval.indexOf("."))==-1)
        {    alert("Not A Valid URL");
            e.preventDefault();
        }
        
    });
    $("#Read").click(function(e){
        $txtval=$("#url").val();
        if($txtval=='')
        {
          alert("Enter URL...");
          e.preventDefault();
          return false;
        }  
        isUrl($txtval);
        if(($txtval.indexOf("."))==-1)
        {    alert("Not A Valid URL");
            e.preventDefault();
        }
        
    });
    </script>
  </body>
</html>
