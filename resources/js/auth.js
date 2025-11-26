// Simple auth modal/behavior script
// - Provides focusing, simple client-side validation, and modal close handling

document.addEventListener('DOMContentLoaded', function () {
    // Try to find auth container; if not present, nothing to do
    const authContainer = document.querySelector('.auth-container');
    if (!authContainer) return;

    // Add simple validation on submit to highlight empty required fields
    function validateForm(form) {
        let valid = true;
        const requiredFields = form.querySelectorAll('[required]');
        requiredFields.forEach((field) => {
            field.classList.remove('input-error');
            const err = field.parentElement.querySelector('.error-message');
            if (err) err.style.display = 'none';
            if (!field.value || field.value.trim() === '') {
                valid = false;
                field.classList.add('input-error');
                if (err) {
                    err.style.display = 'block';
                } else {
                    const span = document.createElement('span');
                    span.className = 'text-danger error-message';
                    span.innerText = 'This field is required';
                    field.parentElement.appendChild(span);
                }
            }
        });
        return valid;
    }

    // Hook login form
    const loginForm = document.getElementById('signin-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            if (!validateForm(loginForm)) {
                e.preventDefault();
                const firstError = loginForm.querySelector('.input-error');
                if (firstError) firstError.focus();
            }
        });
    }

    // Hook register form
    const registerForm = document.getElementById('signup-form');
    if (registerForm) {
        registerForm.addEventListener('submit', function (e) {
            if (!validateForm(registerForm)) {
                e.preventDefault();
                const firstError = registerForm.querySelector('.input-error');
                if (firstError) firstError.focus();
            }
        });
    }

    // Close modal with ESC if desired (if wrapped in modal overlay)
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            const closeBtn = document.querySelector('.auth-modal-close');
            if (closeBtn) closeBtn.click();
        }
    });

    // Add simple focus style behavior: add class when input focused
    document.querySelectorAll('.form-input').forEach((input) => {
        input.addEventListener('focus', () => input.classList.add('focused'));
        input.addEventListener('blur', () => input.classList.remove('focused'));
    });
});
