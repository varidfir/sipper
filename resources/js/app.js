import './bootstrap';

const uppercaseFieldSelector = [
	'.form-content input[type="text"]',
	'.form-content textarea',
	'.wilayah-form-content input[type="text"]',
].join(', ');

const uppercaseField = (field) => {
	field.value = field.value.toUpperCase();
};

document.addEventListener('input', (event) => {
	if (event.target.matches(uppercaseFieldSelector)) {
		uppercaseField(event.target);
	}
});

document.addEventListener('submit', (event) => {
	event.target.querySelectorAll(uppercaseFieldSelector).forEach(uppercaseField);
});
