import { convertToInt, convertToFloat } from './../helpers/Converters.js';

class CustomRules {
	/**
	 * Initializing all custom rules in this class.
	 * 
	 * @param  {Object} form  Node
	 * @return {void}
	 */
	constructor(form) {
		this._makeCustomRule(form, '[data-range]', this.dataRangeRule);
		this._makeCustomRule(form, '[data-rangestring]', this.dataRangeStringRule);
		this._makeCustomRule(form, '[data-type]', this.dataTypeRule);
		this._makeCustomRule(form, '[data-equalto]', this.dataEqualTo);
	}

	/**
	 * High Order Function for validation rule.
	 * 
	 * @param  {Object}   form      Node
	 * @param  {string}   selector  Data attribute
	 * @param  {Function} callback  Function for handle custom rule
	 * @return {void}            
	 */
	_makeCustomRule = (form, selector, callback) => {
		const controls = form.querySelectorAll(selector);
		controls.forEach(control => {
			control.setCustomValidity('');
			callback(control);
		})
	}

	/**
	 * Handler for [data-range] rule
	 * 
	 * @param  {Object} control  Node
	 * @return {void}
	 */
	dataRangeRule = (control) => {
		const rangeValues = control.getAttribute('data-range').split('-').map(value => convertToFloat(value));

		if (control.value < rangeValues[0] || control.value > rangeValues[1])
			control.setCustomValidity('invalid');
	}

	/**
	 * Handler for [data-rangestring] rule.
	 * 
	 * @param  {Object} control  Node
	 * @return {void}
	 */
	dataRangeStringRule = (control) => {
		const rangeValues = control.getAttribute('data-rangestring').split('-').map(value => convertToFloat(value));
		
		if (control.value.length < rangeValues[0] || control.value.length > rangeValues[1])
			control.setCustomValidity('invalid');
	}

	/**
	 * Handler for [data-type] rule.
	 * 
	 * @param  {Object} control  Node
	 * @return {void}
	 */
	dataTypeRule = (control) => {
		const dataType = control.getAttribute('data-type');

		if (dataType.toLowerCase() == 'integer')
			try {
				convertToInt(control.value);
			} catch(err) {
				control.setCustomValidity('invalid');
			}

		if (dataType.toLowerCase() == 'float') 
			try {
				convertToFloat(control.value);
			} catch(err) {
				control.setCustomValidity('invalid');
			}

		if (dataType.toLowerCase() == 'alphanumeric' && !control.value.match(/^[a-z0-9]+$/i))
			control.setCustomValidity('invalid');
	}

	/**
	 * Handler for [data-equalto] attribute
	 * 
	 * @param  {Object} control  Node]
	 * @return {void}
	 */
	dataEqualTo = (control) => {
		const requiredlControl = document.querySelector(control.getAttribute('data-equalto'));
		if (control.value != requiredlControl.value)
			control.setCustomValidity('invalid');
	}
}

export default CustomRules;