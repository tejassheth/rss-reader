<?php /**
* 
*/
class ReadRSS
{
    function validateFeed( $FeedURL )
    {
        if (false === strpos($FeedURL, '://')) {
        $FeedURL = 'http://' . $FeedURL;
        }   
        @$name = array_pop(explode('/', $FeedURL));
       	set_time_limit(120);
		@$con=simplexml_load_file($FeedURL);
		if($con<>null)
		{		
			if(strcasecmp($con->getName(),"rss")==0)
			{	
				return $FeedURL;
			}
			else
            {    
				return $this::isValidateFeed($FeedURL);
            }
		}
		else
		{
			return $this::isValidateFeed($FeedURL);
		}
    }
    
	function isValidateFeed($FeedURL)
    {
		set_time_limit(120);
		$sValidator = 'http://validator.w3.org/appc/check.cgi?url=';
		if( $sValidationResponse = @file_get_contents($sValidator . urlencode($FeedURL)) )
        {
		    if( stristr( $sValidationResponse , 'Congratulations!' ) !== false )
            {
				
                $dom= new DOMDocument();
                @$dom->loadHTML($sValidationResponse);
                $tag=$dom->getElementById("url");
                if($tag->getAttribute("value")=="")
                    return false;
                else
					return $tag->getAttribute("value");
           }
            else
            {	
					
				return false;
			}
        
        }
        else
        {
            return false;
        }
    }
   function getRssFeedName($feed_url)
    {
		set_time_limit(120);
        $con= new SimpleXmlElement($feed_url,null,true); 
        $name=$con->channel[0]->title;
        $cur_encoding = mb_detect_encoding($name); 
        if(($cur_encoding == "UTF-8" && mb_check_encoding($name,"UTF-8"))) 
        {
            $name= iconv("UTF-8", "ASCII//TRANSLIT", $name);
        }
        return $name;
    }
     function getFeeds($feed_url) {  
        global $ok;
        try{
        set_time_limit(120);
        $con= new SimpleXmlElement($feed_url,null,true); 
        if($con==true) 
        {
         $doc = new DOMDocument();
        $list=array();
        $ns = $con->getNamespaces(true);
        
        foreach($con->channel[0]->item as $item)
        {
            $title= $item->title;
            $link= $item->link;
            $content = $item->children($ns['content']);
            $cn=(string) trim($content->encoded);
            //echo $cn;
            @$doc->loadHTML($cn);
            $tags = $doc->getElementsByTagName('img');
            foreach ($tags as $tag) {
                $cur_encoding = mb_detect_encoding($title) ; 
                if(($cur_encoding == "UTF-8" && mb_check_encoding($title,"UTF-8"))) 
                {
                         $title=iconv("UTF-8", "ASCII//TRANSLIT", $title);
                        // echo $title;
                }
                $img= $tag->getAttribute('src');
                $img=str_replace(strstr($img, '?w'),"",$img);
                $img=str_replace(strstr($img, '?h'),"",$img);
                $img=str_replace(strstr($img, '?W'),"",$img);
                $img=str_replace(strstr($img, '?H'),"",$img);
                $text=$this->showDOMNode($doc);
                array_push($list, array($title,$link,$img,$text));
                break;
            }
        }
        
        return $list;
    }
    else
        $ok=false;
}
    catch(Exception $e)
    {
        $ok=false;
    }

    }
    function showDOMNode(DOMNode $domNode) {
        $text='';
    foreach ($domNode->childNodes as $node)
    {
        $text=$text.$node->nodeValue;
        if(strlen($text)>=100)
            break;
        if($node->hasChildNodes()) {
            self::showDOMNode($node);
        }
    }    
    return $text;
}
}

?>  