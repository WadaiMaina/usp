// JavaScript Document
$(document).ready(function(e) {
		$("#mobile-nav").hide();
		$(".menu-icon").click(function(e) {
			$("#mobile-nav").show();
			$(".cls-btn").show();
		});
	});
	$("#active").attr('style', 'border-left:5px solid #0AD;');
	$('.cls-btn').click(function(e) {
		$("#mobile-nav").hide();
		$(this).hide();
	});