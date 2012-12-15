<?php
require_once('fpdf.php'); 
require_once('class.ReadRSS.php'); 
if(isset($_GET["url"]))
{
	$url=$_GET["url"];
	$RSS=new ReadRSS();
	$ret=$RSS->validateFeed($url);
            if($ret==true)
            {
			set_time_limit(120);
			$pdf =new FPDF();
			$list=$RSS->getFeeds($url);
			foreach ($list as $key ) {
				$k1=strstr($key[2],".GIF");
				$k2=strstr($key[2],".JPG");
				$k3=strstr($key[2],".PNG");
				$k4=strstr($key[2],".gif");
				$k5=strstr($key[2],".jpg");
				$k6=strstr($key[2],".png");
				$k7=strstr($key[2],".JPEG");
				$k8=strstr($key[2],".jpeg");
				if(($k1==".GIF")||($k2==".JPG")||($k3==".PNG")||($k4==".gif")||($k5==".jpg")||($k6==".png")||($k7==".JPEG")||($k8==".jpeg"))
				{
				$pdf->AddPage();
				$pdf->SetFont("Arial","B",16);
				$pdf->Write(5,$key[0]);	
				$pdf->Ln(true);
				$pdf->image($key[2],20,30,-150);
				}
			}
			$pdf->Output();
		}
		else
			echo "Enter A valid RSS Feeds URL";
	}
	else
		echo "Enter A valid RSS Feeds URL";
?>
