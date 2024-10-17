$(".wrapper").click(function () {
	setInterval(function () {
		$(".nav li:nth-child(1)").addClass("animated fadeInRight");
		$(".review_category ul li").removeClass("animated fadeInRight");
	}, 500);
	setInterval(function () {
		$(".nav li:nth-child(2)").addClass("animated fadeInRight");
		$(".review_category ul li").removeClass("animated fadeInRight");
	}, 600);
	setInterval(function () {
		$(".nav li:nth-child(3)").addClass("animated fadeInRight");
		$(".review_category ul li").removeClass("animated fadeInRight");
	}, 700);
	setInterval(function () {
		$(".nav li:nth-child(4)").addClass("animated fadeInRight");
		$(".review_category ul li").removeClass("animated fadeInRight");
	}, 800);
	setInterval(function () {
		$(".nav li:nth-child(5)").addClass("animated fadeInRight");
		$(".review_category ul li").removeClass("animated fadeInRight");
	}, 900);
	setInterval(function () {
		$(".nav li:nth-child(6)").addClass("animated fadeInRight");
		$(".review_category ul li").removeClass("animated fadeInRight");
	}, 1000);
	setInterval(function () {
		$(".nav li:nth-child(7)").addClass("animated fadeInRight");
		$(".review_category ul li").removeClass("animated fadeInRight");
	}, 1100);
	$(".nav li").removeClass("animated fadeInRight");
});
$(document).ready(function () {
	$template = $(".rating").clone();
	$(".myrate").append($template);
	$(".myrate input#star4").attr("checked", "checked");
});
