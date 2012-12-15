
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
       <h3>Tejas J. Sheth</h3>
       Bahela Para, Kamadar Street,<br>
       Nr. Chabutra,<br>
       Limbdi, Dist-: Surendranagar,<br>
       PIN -: 363421<br>
       email :- sheth.t.j.2012@gmail.com<br>
       ph &nbsp;-: (02753) 260475<br>
       mo &nbsp;-: +91 9033332295<br>

        

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap-transition.js"></script>
   
    <script type="text/javascript">
      $("#Read").click(function(e){
        $txtval=$("#url").val();
        if(!isUrl($txtval))
        {    alert("Not A Valid URL");
            e.preventDefault();
        }
        
    });
    function isUrl(s) {
        var regexp = /(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
        return regexp.test(s);
        }

    </script>
  </body>
</html>
