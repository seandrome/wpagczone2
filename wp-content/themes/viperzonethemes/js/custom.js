jQuery(document).ready(function() {
	
	
/* Navigation */

	jQuery('#submenu ul.sfmenu').superfish({ 
		delay:       500,								// 0.1 second delay on mouseout 
		animation:   { opacity:'show',height:'show'},	// fade-in and slide-down animation 
		dropShadows: true								// disable drop shadows 
	});	
	
	
	jQuery('.article-list .grid_3:nth-child(4n)').after('<div class="clear"></div>');
	
	
/* Banner class */

	jQuery('.squarebanner ul li:nth-child(even)').addClass('rbanner');

/* Fancybox */

	jQuery(".fancybox").fancybox({
          helpers: {
              title : {
                  type : 'float'
              }
          }
    });


/* Responsive slides */

	jQuery('#flexislider').flexslider({
		animation:"slide",
		controlNav: false,
		directionNav:true
	});	




});