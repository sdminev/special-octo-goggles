/* TEST TEST TEST */
	/**'use strict';


	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
  var contentHeight = 800;
  var pageHeight = document.documentElement.clientHeight;
  var scrollPosition;
  var n = 9;
  var xmlhttp;
          if (window.XMLHttpRequest) {
            console.log("Using XMLHttpRequest");
            xmlhttp = new XMLHttpRequest();
        }
        else {
            console.log("Using ActiveXObject");
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
  
  function putImages(){
             console.log(xmlhttp.status);
                          console.log(xmlhttp.readyState);
        console.log(xmlhttp.responseText);
      if (xmlhttp.readyState == 4)
        {
            if(xmlhttp.responseText){
               var resp = xmlhttp.responseText.replace("\r\n", ""); 
               resp=resp.replace("/\n/ig", ""); 
               resp=resp.replace("/\n/ig", ""); 
               var files = resp.split(";");
                var j = 0;
                for(i=0; i<files.length; i++){
                    if(files[i] != ""){
                       document.getElementById("container").innerHTML += ' <div class="masonry-brick" ><div class="item masonry-item"><img src="https://wowtea.eu/img/'+files[i]+'" alt="Masonry Brick" class="masonry-content"/></div></div>';
                       j++;
                     
                  if(j == 5)
                       document.getElementById("container").innerHTML += '';
                    else if(j == 10){
                        //document.getElementById("container").innerHTML += '<p>'+(n-1)+" Images Displayed | <a href='#header'>top</a></p><hr />";
                          j = 0;
                      }
                   }
                }
            }
        }
  }
           
           
  function scroll(){
       
      if(navigator.appName == "Microsoft Internet Explorer")
          scrollPosition = document.documentElement.scrollTop;
      else
          scrollPosition = window.pageYOffset;        
       
      if((contentHeight - pageHeight - scrollPosition) <= 500){
                   
          if(window.XMLHttpRequest)
              xmlhttp = new XMLHttpRequest();
          else
              if(window.ActiveXObject)
                  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
              else
                  alert ("Bummer! Your browser does not support XMLHTTP!");         
             
          var url="https://wowtea.eu/wp-content/plugins/wowgirls-gallery/getImages.php?n="+n;
           
          xmlhttp.open("GET",url,true);
          xmlhttp.send();
           
          n += 9;
          xmlhttp.onreadystatechange=putImages;       
          contentHeight += 800;   
          resizeAllMasonryItems(); 
          console.log('thisisif');   
      }
      else
  {          if(window.XMLHttpRequest)
              xmlhttp = new XMLHttpRequest();
          else
              if(window.ActiveXObject)
                  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
              else
                  alert ("Bummer! Your browser does not support XMLHTTP!");         
             
          var url="https://wowtea.eu/wp-content/plugins/wowgirls-gallery/getImages.php?n="+n;
           
          xmlhttp.open("GET",url,true);
          xmlhttp.send();
           
          n += 9;
          xmlhttp.onreadystatechange=putImages;       
          contentHeight += 800;   
          resizeAllMasonryItems(); 
          console.log('thisisifelse2');   
  }
  }
  
   
      /**
   * Set appropriate spanning to any masonry item
   *
   * Get different properties we already set for the masonry, calculate 
   * height or spanning for any cell of the masonry grid based on its 
   * content-wrapper's height, the (row) gap of the grid, and the size 
   * of the implicit row tracks.
   *
   * param item Object A brick/tile/cell inside the masonry 
   */
  function resizeMasonryItem(item){
      /* Get the grid object, its row-gap, and the size of its implicit rows */
      var grid = document.getElementsByClassName('masonry')[0],
          rowGap = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-row-gap')),
          rowHeight = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-auto-rows'));
    
      /*
       * Spanning for any brick = S
       * Grid's row-gap = G
       * Size of grid's implicitly create row-track = R
       * Height of item content = H
       * Net height of the item = H1 = H + G
       * Net height of the implicit row-track = T = G + R
       * S = H1 / T
       */
      var rowSpan = Math.ceil((item.querySelector('.masonry-content').getBoundingClientRect().height+rowGap)/(rowHeight+rowGap));
    
      /* Set the spanning as calculated above (S) */
      
        if (rowSpan < 8) {
          item.querySelector('.masonry-content').style.display = "none";
        } else {
          item.style.gridRowEnd = 'span '+rowSpan;
        }
     
    }
    /**
     * Apply spanning to all the masonry items
     *
     * Loop through all the items and apply the spanning to them using 
     * `resizeMasonryItem()` function.
     *
     * @uses resizeMasonryItem
     */
    function resizeAllMasonryItems(){
      // Get all item class objects in one list
      var allItems = document.getElementsByClassName('masonry-brick');
      // if (document.getElementsByClassName('masonry-brick').height < 4) {
      //   var dontShow = document.getElementsByClassName('masonry-brick');
      //   dontShow.style.display = "none";
      // }
    
      /*
       * Loop through the above list and execute the spanning function to
       * each list-item (i.e. each masonry item)
       */
      
      for(var i=0;i<allItems.length;i++){
        
        resizeMasonryItem(allItems[i]);
        }
      
    }
    
    /**
     * Resize the items when all the images inside the masonry grid 
     * finish loading. This will ensure that all the content inside our
     * masonry items is visible.
     *
     * @uses ImagesLoaded
     * @uses resizeMasonryItem
     */
    function waitForImages() {
      var allItems = document.getElementsByClassName('masonry-brick');
      for(var i=0;i<allItems.length;i++){
        imagesLoaded( allItems[i], function(instance) {
          var item = instance.elements[0];
          resizeMasonryItem(item);
        } );
      }
    }
    
    /* Resize all the grid items on the load and resize events */
    var masonryEvents = ['load', 'resize'];
    masonryEvents.forEach( function(event) {
      window.addEventListener(event, resizeAllMasonryItems);
    } );
    
    /* Do a resize once more when all the images finish loading */
    waitForImages();
  /**Makes script to load more images. not sure if it works as it planned.  */
   
  
  function setINtervalOnGallery() {
    setInterval('scroll();', 450); 
    setInterval('waitForImages();', 860);
    
  }

