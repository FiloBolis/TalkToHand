// Modern Login/Registration Form JavaScript

// Initialize AOS animations
AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: true
});

// Form toggle functionality (mantiene la tua logica originale)
const container = document.querySelector('.container-custom');
const registerBtn = document.querySelector('.register-btn');
const loginBtn = document.querySelector('.login-btn');

registerBtn.addEventListener('click', () => {
    container.classList.add('active');
});

loginBtn.addEventListener('click', () => {
    container.classList.remove('active');
});

// Add loading effect on page load
window.addEventListener('load', () => {
    const mainContainer = document.getElementById('mainContainer');
    if (mainContainer) {
        mainContainer.classList.add('loading');
    }
});

// Metodo per gestire il login
async function accedi() {
    const form = document.querySelector('.form-box.login form');
    const submitBtn = form.querySelector('.btn');
    const usernameInput = form.querySelector('input[type="text"]');
    const passwordInput = form.querySelector('input[type="password"]');
    
    // Validazione completa
    let isValid = true;
    
    // Pulisci errori precedenti
    clearInputError(usernameInput);
    clearInputError(passwordInput);
    
    // Valida username
    if (!usernameInput.value.trim()) {
        showInputError(usernameInput, 'Il nome utente è obbligatorio');
        isValid = false;
    }
    
    // Valida password
    if (!passwordInput.value.trim()) {
        showInputError(passwordInput, 'La password è obbligatoria');
        isValid = false;
    }
    
    if (!isValid) {
        return;
    }
    
    // Stile: Loading state
    const originalText = submitBtn.textContent;
    submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Caricamento...';
    submitBtn.disabled = true;
    
    try {
        const url = `ajax/gestoreLogin.php?username=${usernameInput.value}&password=${passwordInput.value}`;
        const result = await fetch(url);
        if(!result.ok)
            throw new Error("errore durante la fetch!");
        let txt = await result.text();
        console.log(txt);
        let datiRicevuti = JSON.parse(txt);
        console.log(datiRicevuti);

        if(datiRicevuti["status"] == "ERR") {
            showErrorMessage(datiRicevuti["msg"]);
        
            // Stile: Ripristina button
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        }else
            window.location.href = "home.php";
    } catch (error) {
        // Stile: Ripristina button in caso di errore
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
        
        // Stile: Mostra errore
        showErrorMessage('Errore durante la login');
        console.error('Errore login:', error);
    }
}

// Metodo per gestire la registrazione
async function registra() {
    const form = document.querySelector('.form-box.register form');
    const submitBtn = form.querySelector('.btn');
    const usernameInput = form.querySelector('input[type="text"]');
    const emailInput = form.querySelector('input[type="email"]');
    const passwordInput = form.querySelector('input[type="password"]');
    
    // Validazione completa
    let isValid = true;
    
    // Pulisci errori precedenti
    clearInputError(usernameInput);
    clearInputError(emailInput);
    clearInputError(passwordInput);
    
    // Valida username
    if (!usernameInput.value.trim()) {
        showInputError(usernameInput, 'Il nome utente è obbligatorio');
        isValid = false;
    }
    
    // Valida email
    if (!emailInput.value.trim()) {
        showInputError(emailInput, 'L\'email è obbligatoria');
        isValid = false;
    } else if (!isValidEmail(emailInput.value)) {
        showInputError(emailInput, 'Inserisci un indirizzo email valido');
        isValid = false;
    }
    
    // Valida password
    if (!passwordInput.value.trim()) {
        showInputError(passwordInput, 'La password è obbligatoria');
        isValid = false;
    } else if (passwordInput.value.length < 6) {
        showInputError(passwordInput, 'La password deve contenere almeno 6 caratteri');
        isValid = false;
    }
    
    if (!isValid) {
        return;
    }
    
    // Stile: Loading state
    const originalText = submitBtn.textContent;
    submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Caricamento...';
    submitBtn.disabled = true;
    
    try {
        const url = `ajax/gestoreRegister.php?username=${usernameInput.value}&password=${passwordInput.value}&email=${emailInput.value}`;
        const result = await fetch(url);
        if(!result.ok)
            throw new Error("errore durante la fetch!");
        let txt = await result.text();
        console.log(txt);
        let datiRicevuti = JSON.parse(txt);
        console.log(datiRicevuti);

        if(datiRicevuti["status"] == "ERR") {
            showErrorMessage(datiRicevuti["msg"]);
        
            // Stile: Ripristina button
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        }else
            window.location.href = "home.php";
    } catch (error) {
        // Stile: Ripristina button in caso di errore
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
        
        // Stile: Mostra errore
        showErrorMessage("Errore durante la registrazione!");
        console.error('Errore registrazione:', error);
    }
}



// Input validation helpers
function showInputError(input, message) {
    clearInputError(input);
    
    input.style.borderColor = '#e74c3c';
    input.style.backgroundColor = '#fdf2f2';
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.style.cssText = `
        color: #e74c3c;
        font-size: 0.8rem;
        margin-top: 5px;
        animation: fadeIn 0.3s ease;
    `;
    errorDiv.textContent = message;
    
    input.parentElement.appendChild(errorDiv);
}

function clearInputError(input) {
    input.style.borderColor = '';
    input.style.backgroundColor = '';
    
    const errorMessage = input.parentElement.querySelector('.error-message');
    if (errorMessage) {
        errorMessage.remove();
    }
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function showSuccessMessage(message) {
    const successDiv = document.createElement('div');
    successDiv.className = 'success-message';
    successDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #27ae60, #2ecc71);
        color: white;
        padding: 15px 20px;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(46, 204, 113, 0.3);
        z-index: 9999;
        animation: slideIn 0.5s ease;
    `;
    successDiv.innerHTML = `
        <i class="bx bx-check-circle" style="margin-right: 8px;"></i>
        ${message}
    `;
    
    document.body.appendChild(successDiv);
    
    setTimeout(() => {
        successDiv.style.animation = 'slideOut 0.5s ease forwards';
        setTimeout(() => successDiv.remove(), 500);
    }, 3000);
}

function showErrorMessage(message) {
   const errorDiv = document.createElement('div');
   errorDiv.className = 'error-message-popup';
   errorDiv.style.cssText = `
       position: fixed;
       top: 20px;
       right: 20px;
       background: linear-gradient(135deg, #e74c3c, #c0392b);
       color: white;
       padding: 15px 20px;
       border-radius: 10px;
       box-shadow: 0 10px 25px rgba(231, 76, 60, 0.3);
       z-index: 9999;
       animation: slideIn 0.5s ease;
   `;
   errorDiv.innerHTML = `
       <i class="bx bx-error-circle" style="margin-right: 8px;"></i>
       ${message}
   `;
   
   document.body.appendChild(errorDiv);
   
   setTimeout(() => {
       errorDiv.style.animation = 'slideOut 0.5s ease forwards';
       setTimeout(() => errorDiv.remove(), 500);
   }, 3000);
}

// Enhanced input focus effects
const inputs = document.querySelectorAll('input');
inputs.forEach(input => {
    input.addEventListener('focus', () => {
        input.parentElement.classList.add('focused');
        clearInputError(input);
    });
    
    input.addEventListener('blur', () => {
        if (input.value === '') {
            input.parentElement.classList.remove('focused');
        }
    });
    
    // Real-time validation
    input.addEventListener('input', () => {
        if (input.hasAttribute('data-error')) {
            clearInputError(input);
            input.removeAttribute('data-error');
        }
    });
});

// Social login handlers
const socialLinks = document.querySelectorAll('.social-icons a');
socialLinks.forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        
        const platform = link.getAttribute('title');
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            z-index: 9999;
            animation: fadeIn 0.3s ease;
        `;
        notification.textContent = `Login con ${platform} non ancora implementato`;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'fadeOut 0.3s ease forwards';
            setTimeout(() => notification.remove(), 300);
        }, 2000);
    });
});

// Password visibility toggle
function addPasswordToggle() {
    const passwordInputs = document.querySelectorAll('input[type="password"]');
    
    passwordInputs.forEach(input => {
        const toggleBtn = document.createElement('button');
        toggleBtn.type = 'button';
        toggleBtn.className = 'password-toggle';
        toggleBtn.innerHTML = '<i class="bx bx-hide"></i>';
        toggleBtn.style.cssText = `
            position: absolute;
            right: 50px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-light);
            font-size: 1rem;
            z-index: 10;
        `;
        
        toggleBtn.addEventListener('click', () => {
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            
            const icon = toggleBtn.querySelector('i');
            icon.className = type === 'password' ? 'bx bx-hide' : 'bx bx-show';
        });
        
        input.parentElement.appendChild(toggleBtn);
    });
}

addPasswordToggle();

// Keyboard navigation enhancement
document.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
        const activeInput = document.activeElement;
        if (activeInput && activeInput.tagName === 'INPUT') {
            const form = activeInput.closest('form');
            const inputs = Array.from(form.querySelectorAll('input'));
            const currentIndex = inputs.indexOf(activeInput);
            
            if (currentIndex < inputs.length - 1) {
                e.preventDefault();
                inputs[currentIndex + 1].focus();
            }
        }
    }
});

// Add CSS animations via JavaScript
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
`;
document.head.appendChild(style);