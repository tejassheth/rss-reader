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