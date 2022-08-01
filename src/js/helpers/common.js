/**
 * Toggle icons.
 * 
 * @param  {Object} node FontAwesome icon
 * @return {void}
 */
export const togglePlusIcon = (node) =>{
	if (!node)
		return null;

	if (node.classList.contains('fa-minus')) {
		node.classList.remove('fa-minus');
		node.classList.add('fa-plus');
	} else if (node.classList.contains('fa-plus')) {
		node.classList.add('fa-minus');
		node.classList.remove('fa-plus');
	}
}

/**
 * A recursive method for getting next elements and apply callback.
 * 
 * @param  {Object}   node     
 * @param  {Function} callback 
 * @return {void}
 */
export const getNextElements = (node, callback) => {
	if (node.nextElementSibling){
		callback(node.nextElementSibling);
		getNextElements(node.nextElementSibling, callback);
	}
}

/**
 * Toggle fullscreen mode
 * 
 * @param  {Object} node 
 * @return {void}
 */
export const toggleFullscreen = (node) => {
	const isEnabled = document.fullscreenElement || document.webkitIsFullScreen || document.mozFullScreenEnabled || document.msFullscreenEnabled || document.fullscreen || false;

	if (isEnabled)
		exitFullscreen(node);
	else
		enterFullscreen(node);
}

/**
 * Enter fullscreen mode
 * 
 * @param  {Object} node 
 * @return {void}      
 */
export const enterFullscreen = (node) => {
	if (node.requestFullscreen) {
		node.requestFullscreen();
	} else if (node.mozRequestFullScreen) {
		node.mozRequestFullScreen();
	} else if (node.webkitRequestFullscreen) {
		node.webkitRequestFullscreen();
	} else if (node.msRequestFullscreen) {
		node.msRequestFullscreen();
	}
}

/**
 * Exit fullscreen mode
 * 
 * @return {void}
 */
export const exitFullscreen = () => {
	if (document.exitFullscreen) {
		document.exitFullscreen();
	} else if (document.mozCancelFullScreen) { /* Firefox */
		document.mozCancelFullScreen();
	} else if (document.webkitExitFullscreen) { /* Chrome, Safari and Opera */
		document.webkitExitFullscreen();
	} else if (document.msExitFullscreen) { /* IE/Edge */
		document.msExitFullscreen();
	}
}