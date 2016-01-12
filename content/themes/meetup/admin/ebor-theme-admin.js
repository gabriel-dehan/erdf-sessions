jQuery(document).ready(function($){
	
	$('body').on('click', '.ebor-icons i', function(){
		$('.ebor-icons i').removeClass('active');
		$(this).addClass('active');
		$('.ebor-icon-value').attr('value', $(this).attr('data-icon-class'));
	});
	
	$('body').on('click', '#ebor-icon-toggle', function(){
		$('.ebor-icons-wrapper').slideToggle();
		return false;
	});
	
});