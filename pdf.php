<?php
require_once('fpdf.php');  // include file fpdf from pdf operation 
require_once('class.ReadRSS.php');  // for get rss feed data
if(isset($_GET["url"]))
{
	$url=$_GET["url"];
	$RSS=new ReadRSS(); // create ReadRSS class object
	$ret=$RSS->validateFeed($url); // validate url
        if($ret==true) // if it is true move next
        {
			set_time_limit(120); // set time 
			$pdf =new FPDF(); // create a object of FPDF class
			$list=$RSS->getFeeds($url); // get feed data
			foreach ($list as $key ) {
				$k1=strstr($key[2],".GIF"); 
				$k2=strstr($key[2],".JPG");
				$k3=strstr($key[2],".PNG");
				$k4=strstr($key[2],".gif");
				$k5=strstr($key[2],".jpg");
				$k6=strstr($key[2],".png");
				$k7=strstr($key[2],".JPEG");
				$k8=strstr($key[2],".jpeg");
				if(($k1==".GIF")||($k2==".JPG")||($k3==".PNG")||($k4==".gif")||($k5==".jpg")||($k6==".png")||($k7==".JPEG")||($k8==".jpeg")) // this condition because it allows only this image type
				{
					$pdf->AddPage(); // add new page in pdf
					$pdf->SetFont("Arial","B",16); // setting font
					$pdf->Write(5,$key[0]);	 // write title 
					$pdf->Ln(true); 
					$pdf->image($key[2],20,30,-150); // print image on pdf
				}
			}
			$pdf->Output(); // generate pdf
		}
		else // if url is not valid
			echo "Enter A valid RSS Feeds URL";
	}
	else // if url is not valid
		echo "Enter A valid RSS Feeds URL";
?>
