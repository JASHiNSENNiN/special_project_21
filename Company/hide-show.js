$(".cta-show-hide").click(function () {
  var lable = $(".cta-show-hide").text().trim();

  if (lable == "more..") {
    $(".cta-show-hide").text("less");
    $(".myText").show();
  } else {
    $(".cta-show-hide").text("more..");
    $(".myText").hide();
  }
});
