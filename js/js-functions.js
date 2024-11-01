
var waitForFinalEvent = (function () {
  var timers = {};
  return function (callback, ms, uniqueId) {
    if (!uniqueId) {
      uniqueId = "Don't call this twice without a uniqueId";
    }
    if (timers[uniqueId]) {
      clearTimeout (timers[uniqueId]);
    }
    timers[uniqueId] = setTimeout(callback, ms);
  };
})();
jQuery(document).ready(function() {
jQuery('.ssjp_count').val('0'); 
  jQuery('.slippy_draggable').each( function(){
	var maxheight = parseInt(jQuery(this).parent().css('max-height'));
		var currentheight = parseInt(jQuery(this).parent().css('height'));
			var percheight = currentheight/maxheight*100;
			if(percheight<95){
			jQuery(this).find('br').hide();
					if(percheight<30){
					jQuery(this).find('h1, h2, h3, h4, h5, h6, h7, p, .ssjp_button').css({'font-size':'50%','margin':'0','padding':'0'});
					jQuery(this).find('.ssjp_button').css({'padding':'3% !important'});
					}
					if(percheight<70 && percheight>31){
					jQuery(this).find('h1, h2, h3, h4, h5, h6, h7, p, .ssjp_button').css({'font-size':'90%','margin':'1px','padding':'0'});
					jQuery(this).find('.ssjp_button').css({'padding':'3% !important'});
					}
					if(percheight>70){
					jQuery(this).find('h1, h2, h3, h4, h5, h6, h7, p, .ssjp_button').css({'font-size':'120%','margin':'3px','padding':'3px'});
					jQuery(this).find('.ssjp_button').css({'padding':'5%'});
					}
				}
	});			
jQuery(window).resize(function() {
    waitForFinalEvent(function(){ 
		jQuery('.ssjp_count').val('0'); 
		jQuery('.slippy_draggable').each( function(){
			var sliderName = jQuery(this).parent().attr('class'); sliderName= sliderName.replace("holder_",""); 
			slippy_next('none','',sliderName); 
				
				var maxheight = parseInt(jQuery(this).parent().css('max-height'));
				var currentheight = parseInt(jQuery(this).parent().css('height'));
			var percheight = currentheight/maxheight*100; 
			if(percheight<95){
					if(percheight<30){
					jQuery(this).find('h1, h2, h3, h4, h5, h6, h7, p, .ssjp_button').css({'font-size':'50%','margin':'0','padding':'0'});
					jQuery(this).find('.ssjp_button').css({'padding':'3% !important'});
					}
					if(percheight<70 && percheight>31){
					jQuery(this).find('h1, h2, h3, h4, h5, h6, h7, p, .ssjp_button').css({'font-size':'90%','margin':'1px','padding':''});
					jQuery(this).find('.ssjp_button').css({'padding':'3% !important'});
					}
					if(percheight>70){
					jQuery(this).find('h1, h2, h3, h4, h5, h6, h7, p, .ssjp_button').css({'font-size':'120%','margin':'3px','padding':'3px'});
					jQuery(this).find('.ssjp_button').css({'padding':'5%'});
					}
				}
			  });
			  
		
	}, 200, "Dfbdw5325");

});
});
		function slippy_do_timer(sname,autoplay){ 
		
			if(sname=='' || sname==undefined) {sname = snameDefault;}
			if(autoplay==undefined) autoplay= 5000;
			
			if (slippytimer instanceof slippy_timer == false) {
			var slippytimer = new slippy_timer(function() {
						slippy_next('none','',sname); 
					}, autoplay);
			} else {
			if (slippytimer1 instanceof slippy_timer == false) {
			var slippytimer1 = new slippy_timer(function() {
						slippy_next('none','',sname); 
					}, autoplay);
			} else{
			if (slippytimer2 instanceof slippy_timer == false) {
			var slippytimer2 = new slippy_timer(function() {
						slippy_next('none','',sname); 
					}, autoplay);
			} else{
			if (slippytimer3 instanceof slippy_timer == false) {
			var slippytimer3 = new slippy_timer(function() {
						slippy_next('none','',sname); 
					}, autoplay);
			} else{
			if (slippytimer4 instanceof slippy_timer == false) {
			var slippytimer4 = new slippy_timer(function() {
						slippy_next('none','',sname); 
					}, autoplay);
			}			
			}
			}
			}
			}
		jQuery(".holder_"+sname).hover( function () {
		slippytimer.pause();
		},
		function () {
		slippytimer.resume();
		});	
		
		}
		
		





	  var posdir="0";
    function slippy_draggable(sname){ 
	
	if(sname=='' || sname==undefined) {sname = snameDefault;}
	
	  var posdir="0"; var tpcountall=jQuery(".slippy-slider-"+sname+" #s_navigation div span").length; 
		if(jQuery('.slippy-slider-'+sname+' #s_holder').length > 0){
			var swidthIO=jQuery('.slippy-slider-'+sname+' #s_holder').css('width').replace(/[^-\d\.]/g, '');
			 swidthIO= swidthIO/tpcountall;
			var swidthI = swidthIO*tpcountall*2; var swidthHalf=(swidthI/2-swidthIO)*(-1); swidthI=swidthI+'px';
		
			jQuery( ".slippy-slider-"+sname+" #s_draggable" ).draggable({ 
			axis: "x",
			drag: function( event, ui ) {
			jQuery('.slippy-slider-'+sname+' .ssjp_wrap').css('cursor','move');
			 var currentPos = jQuery(this).position().left; 
			 if(currentPos<swidthHalf) {event.preventDefault(); jQuery(this).css('left',swidthHalf+'px'); }
			if(currentPos>0) {event.preventDefault(); jQuery(this).css('left','0px');}
			},
			
			stop: function( event, ui ) {
			jQuery('.slippy-slider-'+sname+' .ssjp_wrap').css('cursor','auto');
			var swidth=jQuery('.slippy-slider-'+sname+' #s_holder').css('width').replace(/[^-\d\.]/g, ''); swidth= swidth/tpcountall;
			var currentPos = jQuery(this).position().left;
			var tpcount=jQuery("#ssjp_count"+sname).val()-1; 
			 posdir=swidth*tpcount;
				  
					
				if(currentPos*(-1)>posdir){  slippy_next('none',currentPos,sname);   }else{
				slippy_prev('none',currentPos*(-1),sname); }
				
			}
			});
			
		   }
       
	}
	
function slippy_prev(animation,lpos,slider){ 

	var tpcount=document.getElementById("ssjp_count"+slider).value; var tpcountall=jQuery(".slippy-slider-"+slider+" #s_navigation div span").length;
	var tpcountP=tpcount-1+2; var tpcountM=tpcount-1; var tpcountMM=tpcount-2; 
	var swidth=jQuery('.holder_'+slider).css('width').replace(/[^-\d\.]/g, '');  swidth= swidth/tpcountall;  
	var lposa=lpos; 
	var totLeft=(swidth*tpcountMM)*(-1);
	if(tpcountM=='0') return;
	
	if(animation=='none' || animation==undefined){  
	 var lpos=jQuery(".slippy-slider-"+slider+" #ssjp_div_"+tpcount).css('left'); 
	 jQuery(".slippy-slider-"+slider+" #s_navigation span").css('background','#ddd');  jQuery(".slippy-slider-"+slider+" #s_navigation span:nth-child("+tpcountM+")").css('background','#369');  
	jQuery(".slippy-slider-"+slider+" #s_draggable").animate({'left':totLeft+'px'},400, function(){
	jQuery(".slippy-slider-"+slider+" .ssjp_desc").hide();  
	jQuery(".slippy-slider-"+slider+" #ssjp_desc_"+tpcountM).fadeIn('slow');
	});

	}


	document.getElementById("ssjp_count"+slider).value=tpcountM;
}

function slippy_next(animation,lpos,slider){  
	var tpcount=document.getElementById("ssjp_count"+slider).value; var tpcountall=jQuery(".slippy-slider-"+slider+" #s_navigation div span").length;
	var tpcountP=tpcount-1+2; 
	if(tpcountall<tpcountP){ tpcountP=1; tpcount=0;}
	var tpcountM=tpcount-1; 
	
	var swidth=jQuery('.holder_'+slider).css('width').replace(/[^-\d\.]/g, ''); swidth= swidth/tpcountall;

	var totLeft=(swidth*tpcount)*(-1);
	 


	if(animation=='none' || animation==undefined){ 
	jQuery(".slippy-slider-"+slider+" #s_navigation span").css('background','#ddd');  jQuery(".slippy-slider-"+slider+" #s_navigation span:nth-child("+tpcountP+")").css('background','#369'); 

	jQuery(".slippy-slider-"+slider+" #s_draggable").animate({'left':totLeft+'px'},400, function(){
	jQuery(".slippy-slider-"+slider+" .ssjp_desc").hide();  
	jQuery(".slippy-slider-"+slider+" #ssjp_desc_"+tpcountP).fadeIn('slow'); 
	});
	}

	document.getElementById("ssjp_count"+slider).value=tpcountP;
}




function slippy_timer(func, delay){

this.func = func;
    this.delay = delay;

    this.triggerSetAt = new Date().getTime();
    this.triggerTime = this.triggerSetAt + this.delay;

    this.i = window.setInterval(this.func, this.delay);

    this.t_restart = null;

    this.paused_timeLeft = 0;

    this.getTimeLeft = function(){
        var now = new Date();
        return this.delay - ((now - this.triggerSetAt) % this.delay);
    }

    this.pause = function(){
        this.paused_timeLeft = this.getTimeLeft();
        window.clearInterval(this.i);
        this.i = null;
    }

    this.restart = function(sender){

        sender.i = window.setInterval(sender.func, sender.delay);
    }

    this.resume = function(){
        if (this.i == null){
            this.i = window.setTimeout(this.restart, this.paused_timeLeft, this);
        }
    }

    this.clearInterval = function(){ window.clearInterval(this.i);}
}

