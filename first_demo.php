<html>
    <hrad>
    <title>Rss Reader</title>
    <style type="text/css">
        th {
            font: bold 11px "Trebuchet MS", Verdana, Arial, Helvetica,sans-serif;
            color: #6D929B;
            border-right: 1px solid #C1DAD7;
            border-bottom: 1px solid #C1DAD7;
            border-top: 1px solid #C1DAD7;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-align: left;
            padding: 6px 6px 6px 12px;
            background: #CAE8EA url(images/bg_header.jpg) no-repeat;
        }

        td {
	        border-left: 1px solid #C1DAD7;
            border-right: 1px solid #C1DAD7;
            border-bottom: 1px solid #C1DAD7;
            background: #fff;
            padding: 6px 6px 6px 12px;
            color: #6D929B;
        }


        td.alt {
            background: #F5FAFA;
            color: #B4AA9D;
        }
    </style>
    <?php
        require_once("class.ReadRSS.php"); // include file for read rss feed
        $ok= true;
        $r= new ReadRSS(); // creating object of readRSS class
    ?>
    <script type="text/javascript"src="js/slide.js"></script>
    <script type="text/javascript">
        var viewer = new PhotoViewer();
    <?php
            if($ok)
            {
            	$list=$r->getFeeds("http://www.rtcamp.com/feed");
        	    foreach ($list as $key ) { // iterate array of image url, title
                	echo   "viewer.add('$key[2]','<b><br>$key[0]</b>');\n";
            }
       }
        else
            echo "<h1>Not Valid Rss Feeds</h1>";
    ?>
        viewer.disableEmailLink(); 
        viewer.disablePanning();
        viewer.enableAutoPlay();
        viewer.enableLoop();
    </script>
    </head>
    <body>
    	<div align="center">
            <a href="javascript:void(viewer.show(0))">Slideshow</a>||<a href="pdf.php">Download PDF</a>
            <br>
            <table id="mytable" cellspacing="0" summary="Rss Feed's Title And Images">
                <caption>Table 1:Rss Feed's Title And Images </caption>
	           <tr><th>Title</th><th>Image</th></tr>
    <?php
	
        if($ok)
        {
	       foreach ($list as $key ) { // iterate array of image url, title
               echo   "<tr><td><a href='$key[1]' >$key[0]</td><td><img src='$key[2]' style='height:100;width:100;overflow:hidden;'> </td><tr>";
        }
    }  

	?>
            </table>
        </div>
    </body>
</html>