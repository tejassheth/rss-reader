<?php /**
* 
*/
class ReadRSS
{
    function validateFeed( $sFeedURL )
    {
       $sValidator = 'http://validator.w3.org/appc/check.cgi?url=';
       if( $sValidationResponse = @file_get_contents($sValidator . urlencode($sFeedURL)) )
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
                array_push($list, array($title,$link,$img));
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
} 
?>  