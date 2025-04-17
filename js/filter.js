// Search filter
$(".globalSearchResultNoFoundFeedback").hide();
$(".globalInputSearch").keyup(function () {
  // Retrieve the input field text and reset the count to zero
  var filter = $(this).val(),
    count = 0;

  if (count == 0) {
    $(".globalSearchResultNoFoundFeedback").hide();
  }

  // Loop through the comment list
  $(".globalTargetList li").each(function () {
    // If the list item does not contain the text phrase fade it out

    if ($(this).text().search(new RegExp(filter, "i")) < 0) {
      $(this).hide(); // MY CHANGE
      if (count == 0) {
        $(".globalSearchResultNoFoundFeedback").show();
      } else {
        $(".globalSearchResultNoFoundFeedback").hide();
      }
      // Show the list item if the phrase matches and increase the count by 1
    } else {
      $(this).show(); // MY CHANGE
      count++;
    }
  });
});
