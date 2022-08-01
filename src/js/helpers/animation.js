/**
* SlideUp
*
* @param {HTMLElement} element
* @param {Number} duration
* @return {Promise<boolean>}
*/
export const slideUp = (element, duration = 350) => {

    return new Promise(function (resolve, reject) {

        element.style.height = element.offsetHeight + 'px';
        element.style.transitionProperty = `height, margin, padding`;
        element.style.transitionDuration = duration + 'ms';
        element.offsetHeight;
        element.style.overflow = 'hidden';
        element.style.height = 0;
        element.style.paddingTop = 0;
        element.style.paddingBottom = 0;
        element.style.marginTop = 0;
        element.style.marginBottom = 0;
        window.setTimeout(function () {
            element.style.display = 'none';
            element.style.removeProperty('height');
            element.style.removeProperty('padding-top');
            element.style.removeProperty('padding-bottom');
            element.style.removeProperty('margin-top');
            element.style.removeProperty('margin-bottom');
            element.style.removeProperty('overflow');
            element.style.removeProperty('transition-duration');
            element.style.removeProperty('transition-property');
            resolve(false);
        }, duration)
    })
}

/**
* Fade Out
*
* @param {HTMLElement} element
* @param {Number} duration
* @return {Promise<boolean>}
*/
export const fadeOut = (element, duration = 350) => {

    return new Promise(function (resolve, reject) {

        element.style.transitionProperty = `opacity`;
        element.style.transitionDuration = duration + 'ms';
        element.style.opacity = 0;
        window.setTimeout(function () {
            element.style.display = 'none';
            element.style.removeProperty('opacity');
            element.style.removeProperty('transition-duration');
            element.style.removeProperty('transition-property');
            resolve(false);
        }, duration)
    })
}

/**
* SlideDown
*
* @param {HTMLElement} element
* @param {Number} duration
* @return {Promise<boolean>}
*/
export const slideDown = (element, duration = 350) => {

    return new Promise(function (resolve, reject) {

        element.style.removeProperty('display');
        let display = window.getComputedStyle(element).display;

        if (display === 'none') 
            display = 'block';

        element.style.display = display;
        let height = element.offsetHeight;
        element.style.overflow = 'hidden';
        element.style.height = 0;
        element.style.paddingTop = 0;
        element.style.paddingBottom = 0;
        element.style.marginTop = 0;
        element.style.marginBottom = 0;
        element.offsetHeight;
        element.style.transitionProperty = `height, margin, padding`;
        element.style.transitionDuration = duration + 'ms';
        element.style.height = height + 'px';
        element.style.removeProperty('padding-top');
        element.style.removeProperty('padding-bottom');
        element.style.removeProperty('margin-top');
        element.style.removeProperty('margin-bottom');
        window.setTimeout(function () {
            element.style.removeProperty('height');
            element.style.removeProperty('overflow');
            element.style.removeProperty('transition-duration');
            element.style.removeProperty('transition-property');
        }, duration)
    })
}

export const hide = (element, duration = 350) => {
    return new Promise(function (resolve, reject) {
        element.style.transitionProperty = `opacity`;
        element.style.transitionDuration = duration + 'ms';
        element.style.opacity = 0;
        window.setTimeout(function () {
            element.style.display = 'none';
            element.style.removeProperty('opacity');
            resolve(false);
        }, duration)
    })
}

export const show = (element, duration = 350) => {
    return new Promise(function (resolve, reject) {
        let display = window.getComputedStyle(element).display;

        if (display === 'none') 
            display = 'block';

        element.style.display = display;
        element.style.transitionProperty = `opacity`;
        element.style.transitionDuration = duration + 'ms';
        element.style.opacity = 0;
        window.setTimeout(function () {
            element.style.removeProperty('opacity');
        }, duration)
    })
}



/**
* SlideToggle
*
* @param {HTMLElement} element
* @param {Number} duration
* @return {Promise<boolean>}
*/
export const slideToggle = (element, duration = 350) => {

    if (window.getComputedStyle(element).display === 'none')
        return slideDown(element, duration);
    else
        return slideUp(element, duration);
}

export const toggle = (element, duration = 100) => {
    if (window.getComputedStyle(element).display === 'none')
        return show(element, duration);
    else
        return hide(element, duration);
}