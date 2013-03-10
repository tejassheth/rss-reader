<?php 
/*
    * This is a Short Discription on this class
    * this class use for getting rss fees data likes
    * rss feed name and its sub title ,discription and images 
    * also you can validate a rss feed using this class's function
    * 
    * @author     tejas
    * @version    1.0
*/
class ReadRSS {
        
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
        /**
        * @access private
        * @var string 
        */
        $dom = new DOMDocument(); // create a DOMDocumnet object
        @$dom->loadHTMLFile($FeedURL); // load file 
        $items=$dom->getElementsByTagName("rss"); //get a tag rss
        if($items->length>=1){ //check at least one rss tag
            return $FeedURL; // return a url of rss feeds
         }else {
            set_time_limit(120);// set program execution time limit 120 seconds
            @$dom->loadHTMLFile($FeedURL); // load html file in dom object
            $items=$dom->getElementsByTagName("link"); // parse a link tag 
            for ($i = 0; $i < $items->length; $i++){ // iterate  all link tag 
                $linkTag=$items->item($i)->getAttribute("type"); // get a type value
                if(strcasecmp($linkTag,"application/rss+xml")==0){ // check with 
                    return $items->item($i)->getAttribute("href"); // return url if match 
                    break;
                }
            }
            return $this::isValidateFeed($FeedURL); // otherwise check using other function
        }
    
	function isValidateFeed($FeedURL) {
        /**
        * This function use for check url on w3 site url and check if it is register or not 
        * this function return full path otherwise it return false if it is register
        */
		set_time_limit(120);
        /**
        * @access private
        * @var string 
        */
		$sValidator = 'http://validator.w3.org/appc/check.cgi?url='; // this is site url for checking
		if( $sValidationResponse = @file_get_contents($sValidator . urlencode($FeedURL))) { // this function load file
		    if( stristr( $sValidationResponse , 'Congratulations!' ) !== false ) { // is file contains 'Congratulations!' means it is right url
                /**
                * @access private
                * @var DOMDocumnet
                */
			    $dom= new DOMDocument(); // load file in DOM 
                @$dom->loadHTML($sValidationResponse); // parse html 
                /**
                * @access private
                * @var Element 
                */
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
    * it return a string which contains name of RSS feed
    */
		set_time_limit(120);
        /**
        * @access private
        * @var SimpleXmlElement
        */
        $con= new SimpleXmlElement($feed_url,null,true); 
        /**
        * @access private
        * @var string 
        */
        $name=$con->channel[0]->title;
        /**
        * @access private
        * @var string
        */
        $cur_encoding = mb_detect_encoding($name); // for character encode 
        if(($cur_encoding == "UTF-8" && mb_check_encoding($name,"UTF-8"))) { // check it is UTF-8 
            $name= iconv("UTF-8", "ASCII//TRANSLIT", $name); // if it is not than convert
        }
        return $name;
    }
    function getFeeds($feed_url) {  
        /**
        * you have to pass a url of rss feed
        * if it is a right url ti will return array of rss feed items's title, url and 100 character
        * otherwise it will return false
        */
        /**
        * @access private
        * @var boolean
        */
        global $ok;
        try{
            set_time_limit(120); // set maximum execution time 120 seconds
            /**
            * @access private
            * @var SimpleXmlElement
            */
            $con= new SimpleXmlElement($feed_url,null,true); // Parse rss feed using this function 
            if($con==true) { // check file is parse or not
                /**
                * @access private
                * @var DOMDocument
                */
                $doc = new DOMDocument();
                /**
                * @access private
                * @var array
                */
                $list=array();
                /**
                * @access private
                * @var array
                */
                $ns = $con->getNamespaces(true); // this function for namespace because encode use content space
                foreach($con->channel[0]->item as $item) // iterate rss feed
                {
                    /**
                    * @access private
                    * @var string
                    */  
                    $title= $item->title; // get title from rss feed
                    /**
                    * @access private
                    * @var string
                    */
                    $link= $item->link;
                    /**
                    * @access private
                    * @var string
                    */
                    $content = $item->children($ns['content']); // get data from namespace  'content'
                    /**
                    * @access private
                    * @var string
                    */
                    $cn=(string) trim($content->encoded); // parse tage name is encoded
                    //echo $cn;
                    /**
                    * @access private
                    * @var HtmlDocument
                    */
                    @$doc->loadHTML($cn); // load file in html 
                    /**
                    * @access private
                    * @var object
                    */
                    $tags = $doc->getElementsByTagName('img'); // get image url
                    foreach ($tags as $tag) { // iterate images and take first
                        $cur_encoding = mb_detect_encoding($title) ;  
                        if(($cur_encoding == "UTF-8" && mb_check_encoding($title,"UTF-8"))) {
                            $title=iconv("UTF-8", "ASCII//TRANSLIT", $title);
                            // echo $title;
                        }
                        /**
                        * @access private
                        * @var string
                        */  
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
            {
                $ok=false; // otherwise return false
            }
         }
        catch(Exception $e) {
        $ok=false; // if is there exception return false
        }
    }
    function getSummary(DOMNode $domNode) {
        /**
        *This method for get 100 character Summary from encoded tag and retunr string 
        */
        /**
        * @access private
        * @var string
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
        return $text; // return a string
    }
}
?>  
