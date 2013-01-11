<?php 
/*
    * @author     tejas
    * @version    1.0
*/
class ReadRSS {
    /**
    * This class is use for performing an operation on RSS Feeds
    */
    function validateFeed( $FeedURL ) {
        /**
        * This method use for checking that it is a valid RSS Feed URL or Not
        * it returns a url if it is valid otherwise it returns false
        */
        if (false === strpos($FeedURL, '://')) { // checking that http is available in url or not
            $FeedURL = 'http://' . $FeedURL; // if not add http:// in url
        }   
        // echo $FeedURL;
        // @$name = array_pop(explode('/', $FeedURL));
        // echo $name;
       	set_time_limit(120);// set program execution time limit 120 seconds
		@$con=simplexml_load_file($FeedURL); // load rss feed xml file 
		if($con<>null) {		// check file is load or not
			if(strcasecmp($con->getName(),"rss")==0) {	// if load check first tag rss
				return $FeedURL; // if it is there return url
			}
			else {    
				return $this::isValidateFeed($FeedURL); // otherwise check using other function
            }
		}
		else {
			return $this::isValidateFeed($FeedURL); // otherwise check using other function
		}
    }
    
	function isValidateFeed($FeedURL) {
        /**
        * This function use for check url on w3 site url and check if it is register or not 
        * this function return full path otherwise it return false if it is register
        */
		set_time_limit(120);
		$sValidator = 'http://validator.w3.org/appc/check.cgi?url='; // this is site url for checking
		if( $sValidationResponse = @file_get_contents($sValidator . urlencode($FeedURL))) { // this function load file
		    if( stristr( $sValidationResponse , 'Congratulations!' ) !== false ) { // is file contains 'Congratulations!' means it is right url
				$dom= new DOMDocument(); // load file in DOM 
                @$dom->loadHTML($sValidationResponse); // parse html 
                $tag=$dom->getElementById("url"); // get element which id 'url', it is a textbox contains url
                if($tag->getAttribute("value")=="") // check it is empty or not
                    return false; // is it is empty return false
                else
					return $tag->getAttribute("value"); // otherwise return url
           }
            else{	
				return false;  // if not contains 'Congratulations!' return false
			}
        
        }
        else{
            return false;  // if file is not load return false
        }
    }
   function getRssFeedTitle($feed_url) {
    /**
    * This function use for get a RSS Feed Title
    */
		set_time_limit(120);
        $con= new SimpleXmlElement($feed_url,null,true); 
        $name=$con->channel[0]->title;
        $cur_encoding = mb_detect_encoding($name); // for character encode 
        if(($cur_encoding == "UTF-8" && mb_check_encoding($name,"UTF-8"))) { // check it is UTF-8 
            $name= iconv("UTF-8", "ASCII//TRANSLIT", $name); // if it is not than convert
        }
        return $name;
    }
    function getFeeds($feed_url) {  
        /**
        * This function return array of rss feed items's title, url and 100 character
        */
        global $ok;
        try{
            set_time_limit(120);
            $con= new SimpleXmlElement($feed_url,null,true); // Parse rss feed using this function 
            if($con==true) { // check file is parse or not
                $doc = new DOMDocument();
                $list=array();
                $ns = $con->getNamespaces(true); // this function for namespace because encode use content space
            
                foreach($con->channel[0]->item as $item) // iterate rss feed
                {
                    $title= $item->title; // get title from rss feed
                    $link= $item->link;
                    $content = $item->children($ns['content']); // get data from namespace  'content'
                    $cn=(string) trim($content->encoded); // parse tage name is encoded
                    //echo $cn;
                    @$doc->loadHTML($cn); // load file in html 
                    $tags = $doc->getElementsByTagName('img'); // get image url
                    foreach ($tags as $tag) { // iterate images and take first
                        $cur_encoding = mb_detect_encoding($title) ;  
                        if(($cur_encoding == "UTF-8" && mb_check_encoding($title,"UTF-8"))) {
                            $title=iconv("UTF-8", "ASCII//TRANSLIT", $title);
                            // echo $title;
                        }
                        $img= $tag->getAttribute('src'); // take image url
                        $img=str_replace(strstr($img, '?w'),"",$img); //remove extra character from url
                        $img=str_replace(strstr($img, '?h'),"",$img); //remove extra character from url
                        $img=str_replace(strstr($img, '?W'),"",$img); //remove extra character from url
                        $img=str_replace(strstr($img, '?H'),"",$img); //remove extra character from url
                        $text=$this->getSummary($doc); // get First 100 character from encoded tag
                        array_push($list, array($title,$link,$img,$text)); // push array in another array
                        break;
                    }
                }
                return $list; // return array
            }
            else
                $ok=false; // otherwise return false
         }
        catch(Exception $e) {
        $ok=false; // if is there exception return false
        }
    }
    function getSummary(DOMNode $domNode) {
        /**
        *This method for get 100 character Summary from encoded tag and retunr string 
        */
        $text='';
        foreach ($domNode->childNodes as $node) // iterate all node till 100 character not complete
        {
            $text=$text.$node->nodeValue; // get node text value
            if(strlen($text)>=100) // check 100 characters 
                break;
            if($node->hasChildNodes()) { // if not 
                self::getSummary($node); // call itself 
            }
        }    
        return $text;
    }
}
?>  