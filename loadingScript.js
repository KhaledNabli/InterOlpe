// begin hiding

// You may modify the following:
	var locationAfterPreload = "?cat=nachrichten" // URL of the page after preload finishes
	var lengthOfPreloadBar = 200 // Length of preload bar (in pixels)
	var heightOfPreloadBar = 15 // Height of preload bar (in pixels)
	// Put the URLs of images that you want to preload below (as many as you want)
	var yourImages = new Array("./kirmes_2009.swf",
							   "./images/buttom_bar.jpg",
							   "./images/main_section_long.png",
							   "./images/left_bar.png",
							   "./images/sub_section_long.png",
							   "./images/right_bar.png",
							   "./images/main_section.png",
							   "./images/side_element.png",
							   "./images/background.jpg",
							   "./images/sub_section.png",
							   "./images/top_bar.png",
							   "./images/main_navigation_top.png",
							   "./brd/styles/dirtyBoard2/theme/images/site_logo.png",
							   "./brd/styles/dirtyBoard2/theme/images/bg_body.jpg",
							   "./brd/styles/dirtyBoard2/theme/images/copyright.png",
							   "./upload/spieler/alia.jpg",
							   "./upload/spieler/amir.jpg",
							   "./upload/spieler/armend.jpg",
							   "./upload/spieler/bilal.jpg",
							   "./upload/spieler/erg.jpg",
							   "./upload/spieler/erh.jpg",
							   "./upload/spieler/fahri.jpg",
							   "./upload/spieler/far.jpg",
							   "./upload/spieler/gali.jpg",
							   "./upload/spieler/kazim.jpg",
							   "./upload/spieler/marius.jpg",
							   "./upload/spieler/pano.jpg",
							   "./upload/spieler/recep.jpg",
							   "./upload/spieler/selim.jpg",
							   "./upload/spieler/serdar.jpg",
							   "./upload/spieler/tarik.jpg",
							   "./upload/spieler/tarikus.jpg"
							   )

// Do not modify anything beyond this point!W
if (document.images) {
	var dots = new Array() 
	dots[0] = new Image(1,1)
	dots[0].src = "./images/dot.png" // default preloadbar color (note: You can substitute it with your image, but it has to be 1x1 size)
	dots[1] = new Image(1,1)
	dots[1].src = "./images/dot_.png" // color of bar as preloading progresses (same note as above)
	var preImages = new Array(),coverage = Math.floor(lengthOfPreloadBar/yourImages.length),currCount = 0
	var loaded = new Array(),i,covered,timerID
	var leftOverWidth = lengthOfPreloadBar%coverage
}
function loadImages() { 
	for (i = 0; i < yourImages.length; i++) { 
		preImages[i] = new Image()
		preImages[i].src = yourImages[i]
	}
	for (i = 0; i < preImages.length; i++) { 
		loaded[i] = false
	}
	checkLoad()
}
function checkLoad() {
	if (currCount >= preImages.length) { 
		location.replace(locationAfterPreload)
		return
	}
	for (i = 0; i <= preImages.length; i++) {
		if (loaded[i] == false && preImages[i].complete) {
			loaded[i] = true
			eval("document.img" + currCount + ".src=dots[1].src")
			currCount++
		}
	}
	timerID = setTimeout("checkLoad()",10) 
}
// end hiding

