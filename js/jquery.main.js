// page init
jQuery(document).ready(function($) {



	/***************** SERMON TABS ******************/

	if ($('#fg-sermon-player-blocks').length){	
		// var player = new MediaElementPlayer('#player');
		$('.fg-sermon-button').click(function(e){
			e.preventDefault();
			var thisTabData = $(this).attr('data');
			$('.fg-sermon-button').removeClass('active');
			$(this).addClass('active');
			$('.fg-sermon-block').removeClass('active');
			$('.fg-sermon-block.'+thisTabData).addClass('active');

			if ( !$('.fg-sermon-block.video').hasClass('active') ){
				var src = $('.fg-sermon-block.video iframe').attr('src');
				$('.fg-sermon-block.video iframe').attr('src', '');
				$('.fg-sermon-block.video iframe').attr('src', src);
			}

			if ( !$('.fg-sermon-block.audio').hasClass('active') ){
				$('.fg-sermon-block.audio .mejs-pause').trigger('click');
			}

		});
	}
	
	
	
	/***************** COUNTDOWN ******************/
	if($('#event-countdown').length) {
	
		var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
		
        var austDay = new Date();
        var date_str = $('#event-countdown .countdown-date').text().replace(',', '').split(' ');

        var month_str = date_str[0];
        for(i=0;i<months.length;i++) {
            if(months[i] == month_str) {
                var austMonth = i;
            }
        }
        
        var austDate = parseInt(date_str[1]);
        var austYear = parseInt(date_str[2]);
        var austHours = parseInt(date_str[3]);
        var austMinutes = parseInt(date_str[4]);
        var currentTimezone = $('.hidden-timezone').html();
        
        austDay = new Date(austYear, austMonth, austDate, austHours, austMinutes);
        $('#event-countdown .countdown-date').countdown({until: austDay, timezone: currentTimezone, format: 'dhmS'});
    
    }



	/***************** AJAX SPINNER ******************/
	
	$.fn.spin.presets.forgiven = {
	  lines: 11, // The number of lines to draw
	  length: 3, // The length of each line
	  width: 7, // The line thickness
	  radius: 15, // The radius of the inner circle
	  corners: 1, // Corner roundness (0..1)
	  rotate: 0, // The rotation offset
	  direction: 1, // 1: clockwise, -1: counterclockwise
	  color: '#aaa', // #rgb or #rrggbb or array of colors
	  speed: 1, // Rounds per second
	  trail: 60, // Afterglow percentage
	  shadow: false, // Whether to render a shadow
	  hwaccel: false, // Whether to use hardware acceleration
	  className: 'spinner', // The CSS class to assign to the spinner
	  zIndex: 2e9, // The z-index (defaults to 2000000000)
	  top: 'auto', // Top position relative to parent in px
	  left: 'auto' // Left position relative to parent in px
	}
	
	if ($('.spinner').length){			
		$('.spinner').spin('forgiven');
	}
	
	
	

	
	/***************** CTA HOVER FIX ******************/
	
	$('#ctas article').hover(function(){
		$(this).addClass('hovered');
	},function(){
		$(this).removeClass('hovered');
	});
	
	$('#ctas article').click(function(){
		$('#ctas article').removeClass('hovered');
		$(this).addClass('hovered');
	});

	
	
	
	
	/***************** AJAX FUNCTIONS ******************/

	if ($('.ajax-wrapper').length){
		$('.ajax-wrapper').each(function(){
			var thisContent = this.id;
			if (thisContent == 'schedule-block'){
				var event_category = $('.schedule-category').html();
				if (!event_category){ event_category = 0; }
				$(this).load(templateDir+'/ajax/'+thisContent+'.php',{'category':event_category},function(response, status, xhr){
				
				});
			} else {
				$(this).load(templateDir+'/ajax/'+thisContent+'.php',function(response, status, xhr){
				
				});
			}
		});
	}
	
	if ($('#schedule-block')){
	
		var currentlyLoadingSchedule = false;
		
		$('.fg-schedule-week-change').click(function(e){
		
			e.preventDefault();
			
			if (!currentlyLoadingSchedule){
				
				var event_category = $('.schedule-category').html();
				if (!event_category){ event_category = 0; }
			
				currentlyLoadingSchedule = true;
				$('#schedule-block').html('<div class="spinner"></div>');
				$('.spinner').spin('forgiven');
				
				var weekToLoad = $(this).attr('data');
				
				$('#schedule-block').load(templateDir+'/ajax/schedule-block.php',{'first_day':weekToLoad,'category':event_category},function(response, status, xhr){
					var firstDay = new Date(weekToLoad);
					var nextWeek = new Date(firstDay.getTime() + 7 * 24 * 60 * 60 * 1000);
					var lastWeek = new Date(firstDay.getTime() - 7 * 24 * 60 * 60 * 1000);
				
					lastWeekYear = lastWeek.getFullYear();
					lastWeekDay = lastWeek.getDate();
					lastWeekMonth = lastWeek.getMonth() + 1;
					
					nextWeekYear = nextWeek.getFullYear();
					nextWeekDay = nextWeek.getDate();
					nextWeekMonth = nextWeek.getMonth() + 1;
					
					$('.fg-schedule-prev-week').attr('data',lastWeekYear+'/'+lastWeekMonth+'/'+lastWeekDay);
					$('.fg-schedule-next-week').attr('data',nextWeekYear+'/'+nextWeekMonth+'/'+nextWeekDay);
					currentlyLoadingSchedule = false;
				});
			}
			
		})
	}



    
    /***************** FITVIDS ******************/
    
    $('.page-content').fitVids();
    
    

	
	/***************** INITIATE SLIDERS ******************/
	
	$(window).on('load', function(){
    	initCarousels();    	
    });
    
    

});

function initCarousels() {	



	/***************** TWEETS SLIDER ******************/

	if (jQuery('.tweets-carousel').length){
	
		jQuery('.tweets-carousel').carouFredSel({
			auto: false,
			width: 1440,
			height: 'variable',
		    responsive: true,
		    items: {
		        visible: 1,
		        width: 1440,
		    },
		    scroll: {
		    	duration: 700,
		    	easing: 'easeInOutExpo'
		    },
		    onCreate: function(){
				jQuery('#recent-tweets').animate({'opacity':1},200);   
		    }
		});
		
		jQuery('.tweets-carousel').on('mouseenter', function(){
			jQuery('.tweets-carousel').trigger('pause');
		}).on('mouseleave', function(){
			jQuery('.tweets-carousel').trigger('play');	
		});	
		jQuery('#recent-tweets .btn-prev').on('click', function(){
			jQuery('.tweets-carousel').trigger('prev', 1);
			return false;
		});
		jQuery('#recent-tweets .btn-next').on('click', function(){
			jQuery('.tweets-carousel').trigger('next', 1);
			return false;
		});
		jQuery('#recent-tweets .btn-next').on('click', function(){
			jQuery('.tweets-carousel').trigger('next', 1);
			return false;
		});
		
	}
	
	
	
	/***************** GALLERY FUNCTIONALITY ******************/

	if (jQuery('.Collage').length){
		jQuery('.Collage').collageCaption().removeWhitespace().collagePlus({
            'targetHeight'    		: 350,
            'fadeSpeed'       		: 2000,
            'effect'          		: 'effect-2',
            'direction'       		: 'horizontal',
            'allowPartialLastRow'	: true
		});
		jQuery('.Collage a').magnificPopup({
			type:'image',
			mainClass: 'mfp-with-zoom', // this class is for CSS animation below
			zoom: {
				enabled: true, // By default it's false, so don't forget to enable it
				duration: 300, // duration of the effect, in milliseconds
				easing: 'ease-in-out', // CSS transition easing function 
				opener: function(openerElement) {
					return openerElement.is('img') ? openerElement : openerElement.find('img');
				}
			},
			gallery: {
				enabled: true, // set to true to enable gallery
				preload: [0,2], // read about this option in next Lazy-loading section
				navigateByImgClick: true,
				arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>', // markup of an arrow button
				tPrev: 'Previous (Left arrow key)', // title for left button
				tNext: 'Next (Right arrow key)', // title for right button
				tCounter: '<span class="mfp-counter">%curr% of %total%</span>' // markup of counter
			}
		});
		
	}

}