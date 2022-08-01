import CustomRules from './CustomRules.js';

class FormValidator {
	/**
	 * Constructor
	 * 
	 * @return {void} 
	 */
	constructor(){
		this.forms = document.querySelectorAll('.needs-validation');
		this.handle();
	}

	/**
	 * Initialize handling
	 * 
	 * @return {void}
	 */
	handle() {
		this.forms.forEach(form => {
			form.addEventListener('submit', (e) => {
				const rules = new CustomRules(form);
				if (form.checkValidity() === false) {
					event.preventDefault();
					event.stopPropagation();
		        }

				form.classList.add('was-validated');
			})
		})
	}
}

export default FormValidator;