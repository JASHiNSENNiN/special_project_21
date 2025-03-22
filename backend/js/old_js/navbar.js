document.addEventListener("DOMContentLoaded", function () {
	const defaultLink = document.querySelector(
		".page-header__nav-link:first-child a"
	);
	setActive(defaultLink);
});

function setActive(clickedLink) {
	const links = document.querySelectorAll(".page-header__nav-link a");
	links.forEach((link) => link.parentNode.classList.remove("active"));

	clickedLink.parentNode.classList.add("active");

	const sections = document.querySelectorAll("section");
	sections.forEach((section) => {
		section.style.display = "none";
	});

	const activeSectionId = clickedLink.getAttribute("href").substring(1);
	const activeSection = document.getElementById(activeSectionId);
	if (activeSection) {
		activeSection.style.display = "block";
	}
}

document.addEventListener("DOMContentLoaded", function () {
	const url = window.location.href;
	const fragmentIndex = url.indexOf("#");
	if (fragmentIndex !== -1) {
		const fragment = url.substring(fragmentIndex + 1);
		const targetLink = document.querySelector(
			`.page-header__nav-link a[href="#${fragment}"]`
		);
		if (targetLink) {
			setActive(targetLink);
		}
	}
});
