import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('form[data-submit-loading]');

    forms.forEach((form) => {
        form.addEventListener('submit', () => {
            const submitButton = form.querySelector('[data-save-button]');

            if (!submitButton) {
                return;
            }

            const savingText = submitButton.getAttribute('data-saving-text') || 'Saving...';

            submitButton.disabled = true;
            submitButton.textContent = savingText;
            submitButton.classList.add('opacity-70', 'cursor-not-allowed');
        });
    });
});
