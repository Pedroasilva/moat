import Tooltip from 'tooltip.js';
import Popper from 'popper.js';
import IMask from 'imask';
import moment from 'moment';
import { slideUp, slideDown, slideToggle, toggle, fadeOut } from './helpers/animation.js';
import { getNextElements, togglePlusIcon, toggleFullscreen } from './helpers/common.js';
import { cookie }  from './helpers/cookie.js';
import objectFitImages from 'object-fit-images';


/**
 * DOM manipulation and actions.
 */
class DomActions {
	constructor(){
		this.getElements('[data-dismiss]', this.dataDismiss);
		this.getElements('[data-toggle]', this.dataToggle);
		this.getElements('[data-tab]', this.dataTab);
		this.getElements('[data-widget]', this.dataWidget);
		this.getElements('[data-tooltip]', this.dataTooltip);
		this.getElements('[data-popover-placement]', this.dataPopover);
		this.getElements('.accordion', this.accordion);
		this.getElements('.sidebar-list li ul', this.sidebarMultilevel);
		this.getElements('[data-mask]', this.dataMask);
		this.getElements('[data-mask-date]', this.dataMaskDate);
		this.getElements('[data-dropdown]', this.dataDropdown);
		this.getElements('a[href="#"]', this.preventEmptyLinkAction);
		this.setWindowHeight();
		this.sidebarHandler();
		this.loaderHandler();
		this.fullscreenButton();

		objectFitImages();
	}

	/**
	 * Wrapper function for getting elements by CSS and apply callback (optional);
	 * 
	 * @param  {string}   selector  CSS selector
	 * @param  {Function} callback  Callback function
	 * @return {mixed}            
	 */
	getElements(selector, callback = null) {
		const elements = document.querySelectorAll(selector);

		if (callback)
			return elements.forEach(element => callback(element));

		return elements;
	}

	/**
	 * Dismissing (removng) elements using [data-dismiss] attribute. 
	 * [data-dismiss] attribute should be a CSS selector of your target DOM element.
	 * 
	 * For example: <button data-dismiss=".sidebar">Hide</button>;
	 * After clicking on this button, .sidebar will become removed.
	 * 
	 * @param  {Object}  element  Node
	 * @return {void}
	 */
	dataDismiss(element) {
		const targetSelector = element.getAttribute('data-dismiss'),
			  targetNodes = document.querySelectorAll(targetSelector);

		if (targetNodes.length)
			element.addEventListener('click', () => {
				targetNodes.forEach(node => {
					slideUp(node, 350);
					setTimeout(() => {
						node.remove();
					}, 350)
				})
			})
	}

	/**
	 * Toggling elements using [data-toggle] attribute. 
	 * [data-toggle] attribute should be a CSS selector of your target DOM element.
	 * 
	 * For example: <button data-toggle=".sidebar">Hide</button>;
	 * After clicking on this button, .sidebar will become hidden.
	 * After clicking again, .sidebar will become visible.
	 * 
	 * @param  {Object}  element  Node
	 * @return {void}
	 */
	dataToggle(element) {
		const targetSelector = element.getAttribute('data-toggle'),
			  targetNodes = document.querySelectorAll(targetSelector);

		if (targetNodes.length)
			element.addEventListener('click', (e) => {
				togglePlusIcon(element.querySelector('i'));
				targetNodes.forEach(node => {
					slideToggle(node);
				})
			})
	}

	/**
	 * Tabs handling using [data-tab] attribute. 
	 * [data-tab] attribute should be a CSS selector of your target DOM element.
	 * 
	 * For example: <button data-tab="#customTab1">Tab 1</button>;
	 * After clicking on this button, #customTab1 will become active.
	 * 
	 * @param  {Object} element Node
	 * @return {void}
	 */
	dataTab(element) {
		const tabId = element.getAttribute('data-tab'),
			  targetTab = document.getElementById(tabId);

		element.addEventListener('click', (e) => {
			// Hiding all tabs
			try {
				targetTab.parentNode.querySelectorAll('.tabs-item').forEach(tab => {
					if(tab.parentNode === targetTab.parentNode) 
						tab.classList.remove('active');
				});
				const tabsContainer = element.closest('.tabs-box') || element.closest('.tabs-row');
				tabsContainer.querySelectorAll('.tabs-trigger').forEach(trigger => trigger.classList.remove('active'));
			} catch(err) {}

			// Showing target nodes
			element.classList.add('active');
			targetTab.classList.add('active');

			// Change active class on reference tabs
			const refTab = document.querySelector(`[data-tab-ref="${tabId}"]`);
			if (refTab) {
				refTab.parentNode.querySelectorAll('.tabs-trigger').forEach(trigger => trigger.classList.remove('active'));
				refTab.classList.add('active');
			}
		})
	}

	/**
	 * Showing tooltip around blocks (using tooltip.js).
	 * 
	 * Place your text into [data-tooltip] attribute in DOM element (top placement using
	 * by default). You can also use [data-tooltip-placement] attribute to change tooltip placement.
	 *
	 * For example: <button data-tooltip="Great tooltip" data-tooltip-pacement="right">Button</button>
	 * 
	 * @param  {Object}  element  Node
	 * @return {void}
	 */
	dataTooltip(element) {
		new Tooltip(element, {
			placement: element.getAttribute('data-tooltip-placement') || 'top',
			title: element.getAttribute('data-tooltip')
		})
	}

	/**
	 * Showing popover after block with [data-tooltip-placement] attribute (using popper.js).
	 *
	 * Add new element with [data-tooltip-placement] attribute, 
	 * then place <div class="popover">...</div> after the first.
	 *
	 * For example: 
	 * <button data-popover-placement="top">Button</button>
	 * <div class="popover">...</div>
	 * 
	 * @param  {Object}  element  Node
	 * @return {void}
	 */
	dataPopover(element) {
		element.addEventListener('click', (e) => {
			const popover = element.nextElementSibling;

			if(!popover || !popover.classList.contains('popover'))
				return false;

			hideAllPopovers()
				.then(() => {
					// Showing popover.
					new Popper(element, popover, {
						placement: element.getAttribute('data-popover-placement') || 'top'
					});
					popover.style.display = 'block';

					// Hiding popover
					popover.querySelector('[data-popover-dismiss]').addEventListener('click', () => {
						return element.getAttribute('data-popover-once') !== null
							? popover.remove()
							: popover.style.display = 'none';
					})
				});
		});

		const hideAllPopovers = () => {
			return new Promise((resolve, reject) => {
				document.querySelectorAll('.popover').forEach(el => el.style.display = 'none');
				resolve();
			})
		}

		// Hiding by Escape
		document.addEventListener('keyup', e => e.keyCode === 27 ? hideAll() : null);
	}

	/**
	 * Handler for dropdown menus
	 * 
	 * @param  {Object} element Node
	 * @return {mixed}
	 */
	dataDropdown(element) {
		element.addEventListener('click', (event) => {
			const dropdown = element.nextElementSibling;

			if(!dropdown || !dropdown.classList.contains('dropdown-menu') || dropdown.style.display == 'block')
				return false;

			hideAllDropdowns()
				.then(() => {
					new Popper(element, dropdown, {
						placement: 'bottom'
					});
					toggle(dropdown, 0);
				})
		})

		const hideAllDropdowns = () => {
			return new Promise((resolve, reject) => {
				document.addEventListener('click', () => {
					document.querySelectorAll('.dropdown-menu').forEach(el => {
						el.style.display = 'none';
					});
					resolve();
				})
			})
		}
	}

	/**
	 * Handler for [data-widget] attribute.
	 * 
	 * @param  {Object} element  Node
	 * @return {void}
	 */
	dataWidget(element) {
		element.addEventListener('click', () => {
			const action = element.getAttribute('data-widget');

			if (action === 'toggle') {
				const header = element.closest('.box-header');
				getNextElements(header, slideToggle);
				togglePlusIcon(element.querySelector('i'));
			}

			if (action === 'dismiss') {
				const box = element.closest('.box, .alert');
				slideUp(box, 350),
				setTimeout(() => {
					box.remove();
				}, 350);
			}
		})
	}

	/**
	 * Toggling .accordion blocks by click.
	 * 
	 * @param  {Object}  element  Node
	 * @return {void}
	 */
	accordion(element) {
		if(element.classList.contains('active')) 
			element.querySelector('.accordion-body').style.display = 'block';

		element.addEventListener('click', (e) => {
			element.classList.toggle('active');
			slideToggle(element.querySelector('.accordion-body'));
		})
	}

	/**
	 * Mask for input's.
	 * 
	 * Read more about IMask plugin: 
	 * https://unmanner.github.io/imaskjs/
	 * 
	 * @param  {Object} element Node
	 * @return {void}
	 */
	dataMask(element) {
		const maskPattern = element.getAttribute('data-mask');
		const mask = new IMask(element, {
			mask: maskPattern
		});
	}

	/**
	 * Date mask for input's.
	 * 
	 * Read more about IMask plugin: 
	 * https://unmanner.github.io/imaskjs/
	 * 
	 * @param  {Object} element Node
	 * @return {void}
	 */
	dataMaskDate(element) {
		const maskPattern = element.getAttribute('data-mask-date');
		const mask = new IMask(element, {
			mask: Date,
			pattern: maskPattern,
			lazy: false,
			min: new Date(1900, 0, 1),
			max: new Date(2100, 0, 1),
			format: date => moment(date).format(maskPattern),
			parse: str => moment(str, maskPattern),
			blocks: {
				YYYY: {
					mask: IMask.MaskedRange,
					from: 1970,
					to: 2030
				},
				MM: {
					mask: IMask.MaskedRange,
					from: 1,
					to: 12
				},
				DD: {
					mask: IMask.MaskedRange,
					from: 1,
					to: 31
				},
				HH: {
					mask: IMask.MaskedRange,
					from: 0,
					to: 23
				},
				mm: {
					mask: IMask.MaskedRange,
					from: 0,
					to: 59
				},
				ss: {
					mask: IMask.MaskedRange,
					from: 0,
					to: 59
				}
			}
		});
	}
	
	/**
	 * Sidebar handler
	 * 
	 * @return {void}
	 */
	sidebarHandler() {
		const sidebar = document.querySelector('.sidebar');
		const trigger = document.querySelector('#js-toggle-sidebar');

		if (!sidebar) 
			return null;

		const hideSidebar = () => sidebar.classList.add('sidebar-collapse')
		const showSidebar = () => sidebar.classList.remove('sidebar-collapse')
		const toggleSidebar = () => {
			const collapsed = sidebar.classList.contains('sidebar-collapse');

			if (collapsed)
				showSidebar();
			else
				hideSidebar();

			cookie.setItem('sidebar-collapse', !collapsed);
		}

		// Sizing sidebar by screen resolution
		const resizeSidebar = () => {
			if (window.innerWidth < 1199 && !sidebar.classList.contains('sidebar-collapse')) 
				hideSidebar();
		}

		// Show/hide sidebar if has cookie item
		if(cookie.getItem('sidebar-collapse') === 'true')  {
			hideSidebar()
		}

		if(cookie.getItem('sidebar-collapse') === 'false')
			showSidebar()

		// Click handler for hamburger menu
		trigger.addEventListener('click', () => {
			toggleSidebar();
		})
		
		// Hide sidebar by outside click (mobile only)
		document.addEventListener('DOMContentLoaded', () => {
			sidebar.style.display = 'block';
			resizeSidebar();

			window.addEventListener('resize', (e) => {
				if (window.innerWidth != e.target.windowWidth)
					resizeSidebar();
			})
		})

		// Hide sidebar by outside touch (mobile only)
		document.addEventListener('touchstart', (e) => {
			if (window.innerWidth < 768 && !e.target.closest('.sidebar')) 
				hideSidebar();
		})

		// Hide sidebar by outside click (mobile only)
		document.addEventListener('click', (e) => {
			if (window.innerWidth < 768 && (!e.target.closest('.sidebar') && !e.target.closest('#js-toggle-sidebar')))
				hideSidebar();
		})
	}

	/**
	 * Handler for sidebar menu.
	 *
	 * After click on <li> element, next element <ul> (wrapped in <li>) will be opened.
	 * For example: 
	 * 
	 *  <li>Multilevel</li>
	 *	<li>
	 *	  <ul>
	 *	    ...
	 *	  </ul>
	 *	</li>
	 * 
	 * @param  {Object}  element  Node
	 * @return {void}
	 */
	sidebarMultilevel(element) {
		const trigger = element.parentNode.previousElementSibling;
		trigger.addEventListener('click', () => {
			if (trigger.classList.contains('active')){
				slideUp(element);
				trigger.classList.remove('active');
			}
			else{
				slideDown(element);
				trigger.classList.add('active');
			}
		})
	}

	/**
	 * Handler for page loader
	 * 
	 * @return {void} 
	 */
	loaderHandler() {
		document.addEventListener('DOMContentLoaded', () => {
			fadeOut(document.querySelector('.loader'))
		})
	}

	/**
	 * Setting min window height
	 */
	setWindowHeight() {
		const height = window.innerHeight;
		const contentHeight = height / 100 * 78;
		const content = document.querySelector('.content');
		content.style.minHeight = contentHeight+'px'
	}

	fullscreenButton() {
		const button = document.querySelector('#js-enter-fullscreen');
		const doc = document.documentElement;

		if (!button)
			return null;

		button.addEventListener('click', () => {
			toggleFullscreen(doc);
		});
	}

	/**
	 * Prevent event on empty link.
	 * For example: <a href="#">Link</a>
	 * 
	 * @param  {Object} element DOM node
	 * @return {void}
	 */
	preventEmptyLinkAction(element) {
		element.addEventListener('click', e => e.preventDefault());
	}
}

export default DomActions;