var navLiWidthLarge = [];
var navLiWidthSmall;

function fadeInNav(){
	$(".nav").css("visibility", "visible").animate({"opacity":1}, 300);
}

function hideNavLabels(){
	
		//get width of navLiSmall
		var a,b,c;
		a=$('.navicon:first').outerWidth();
		b=parseInt($('.nav a:first').css('padding-left'));//remove the "px"
		navLiWidthSmall = a+b;
	
		//select all .nav lis without class of .active 
		$('.nav li:not(.active)')
		.each(function(index) {
				
			$this = $(this);
			
			//Push width to navLiWidthLarge[]
			myWidth = $this.outerWidth(false);
			navLiWidthLarge.push(myWidth);
			
			//and set width to navLiWidthSmall
			$this.css('width',navLiWidthSmall + 'px');
			//set navlabel to hidden so IE doesn't chuck a spaz
			$this.find('.navlabel').addClass('hidden');
			
			//add hover functionality
			$this.hover(
				function(e){
					//Mouseover: set width to large
					lgWidth=navLiWidthLarge[index];
					$(this).stop().animate({width:lgWidth +1+'px'}, 200, function(){
						$(this).find('.navlabel').removeClass('hidden')
					})
				},function(e){
					//MouseOut: return width to Small
					$(this).find('.navlabel').addClass('hidden');
					$(this).stop().animate({width:navLiWidthSmall +'px'}, 200);
				}
			);
		})
			
	//finally, show the nav			
	fadeInNav();
	
}// makeNavCool()

function initThumbAnimation(){
	$('.tn').hover(function(e){
		//handler in
		//$(this).children('img').stop().animate({top:"220px"}, 400, 'easeInQuart');
		$(this).children('img').hoverFlow(e.type, {top:"220px"}, 400, 'easeInQuad');
	},function(e){
		//handler out
		//$(this).children('img').stop().animate({top:"0px"}, 400, 'easeOutQuart');
		$(this).children('img').hoverFlow(e.type, {top:"0px"}, 200, 'easeOutQuad');
	});
		
}

$(document).ready(function(){
	initThumbAnimation();
	
	
	
	//remove 'full' class from navbar on scroll and replace when at top of document
	//$(window).scroll(function () {
//		if($(document).scrollTop()>0)
//			{
//				$('.navbar').removeClass('full', 400, 'easeInCubic')
//			}
//		else if($(document).scrollTop()===0)
//			{
//				$('.navbar').addClass('full', 400, 'easeOutCubic');
//			}		
//	});//window scroll


	
});//function

$(window).load(function() {
	if(!Modernizr.touch){//we want to keep the labels on touch screens
		hideNavLabels();
	} else {
		fadeInNav();
	}
	

});