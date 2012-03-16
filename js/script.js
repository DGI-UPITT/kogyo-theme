Drupal.behaviors.kogyoTabs = function(context) {   

  var kogyoTabs = $(".kogyo-tabs li", context);

  kogyoTabs.click(function(e) {
       e.preventDefault();
       
       // position of clicked element
       var number = kogyoTabs.index(this);
             
       // remove all active classes
       $('.kogyo-tabs li').removeClass('active');
      
       // add active class to this item
       $(this).addClass('active');


       $('.kogyo-tab-content.exposed').removeClass('exposed').addClass('hidden');
       $('.kogyo-tab-content').eq(number).removeClass('hidden').addClass('exposed');
       
       return false;
   });
   
   kogyoTabs.hover(
     function () {
       $(this).addClass("hover");
     },
     function () {
       $(this).removeClass("hover");
     }
   );
   


}





/*
.kogyo-tabs-wrapper
{

}

.kogyo-tabs-wrapper .hidden
{
  display: none;
}

.kogyo-tabs-content-wrapper
{

}

ul.kogyo-tabs
{
  padding: 0px 0px 0px 0px;
}

ul.kogyo-tabs li
{
  display: inline-block;
  list-style: none;
  list-style-image: none;
  
  padding: 5px 10px;
  cursor: pointer;
}

ul.kogyo-tabs li.active
{
  color: blue;
}
*/
