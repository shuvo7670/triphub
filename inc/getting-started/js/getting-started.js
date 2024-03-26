jQuery(document).ready(function($){ 
	/** Ajax Call for Theme Club Tab */
	$('body').on( 'click', '.inline-list li', function(){
		var $this = $(this);
		var id = $this.data("id");
		if( ! $('.inline-list li').hasClass('ajax-process') ){
			if( ! $this.hasClass('ajax') ){
				$('.inline-list li').removeClass('current');
				$this.addClass('current');
				$('.panel-left').removeClass( "visible" );
				$('#'+id+'-panel').addClass( "visible" );
			}
		}
	});
	
	$('body').on( 'click', '.inline-list li.ajax', function(){
		var $this = $(this);
		var id = $this.data("id");

		$.ajax({
			data: { action: 'theme_club_from_rest' },
			type: 'POST',
			url : triphub_getting_started.ajax_url,
			beforeSend:function(){
				$('.inline-list li').addClass('ajax-process');
				$('.theme-loader').show();
				$('.inline-list li').removeClass('current');
				$this.addClass('current');
				$('.panel-left').removeClass('visible');
				$('#'+id+'-panel').addClass('visible');
			},
			success: function(response) {
				$('.theme-list').html(response);				
				$('.inline-list li').removeClass('ajax-process');
				$this.removeClass('ajax');
				$('.theme-loader').hide();
				
			},
		});    
	});

	//faq toggle
	$('.toggle-block:not(.active) .toggle-content').hide();
	$('.toggle-block .toggle-title').click(function(){
		$(this).parent('.toggle-block').siblings().removeClass('active');
		$(this).parent('.toggle-block').addClass('active');
		$(this).parent('.toggle-block').siblings().children('.toggle-content').slideUp();
		$(this).siblings('.toggle-content').slideDown();
	});
});