import MediumEditor from 'medium-editor'

class WysiwigHub {
	constructor() {
		this.mediumEditor('.medium-editor');
		this.ckeditor4('ckeditor4');
	}

	/**
	 * MediumEditor
	 * Read more:
	 * https://github.com/yabwe/medium-editor
	 * 
	 * @param  {string} selector 
	 * @return {void}
	 */
	mediumEditor(selector) {
		const editor = new MediumEditor(selector, {
		    placeholder: {
		        text: 'Type your text',
		        hideOnClick: true
		    }
		});
	}

	/**
	 * Initialize CKEditor 4
	 * Read more:
	 * https://ckeditor.com/docs/ckeditor4/latest/guide/dev_installation.html
	 * 
	 * @param  {string} id Node ID
	 * @return {void}
	 */
	ckeditor4(id) {
		if (!document.querySelector(`#${id}`)) 
			return null;
		
		CKEDITOR.disableAutoInline = true;
		CKEDITOR.replace(id, {
			language: 'en'
		});
	}
}

export default WysiwigHub;