// tab js
// tab-1.addListener(listener);
function openTab(evt, tabName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}
// cover 1 js
let profilePic1 = document.getElementById("cover-pic");
let inputFile1 = document.getElementById("input-file1");

inputFile1.onchange = function () {
  profilePic1.src = URL.createObjectURL(inputFile1.files[0]);
};

//  cover 2 js
let profilePic2 = document.getElementById("profile-pic");
let inputFile2 = document.getElementById("input-file2");

inputFile2.onchange = function () {
  profilePic2.src = URL.createObjectURL(inputFile2.files[0]);
};
