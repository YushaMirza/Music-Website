<?php
include '../connection.php';
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOUND Group Authentication</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Existing styles remain unchanged */
        input::placeholder,
        textarea::placeholder {
          color: #bbb;
          font-size: 14px;
        }

        /* Specific to signup form inputs */
        #signupForm input::placeholder {
          color: #aaa;
          font-style: italic;
        }

        #loginForm input::placeholder {
          color: #aaa;
          font-style: italic;
        }
        
        .auth-modal .modal-content {
          background: linear-gradient(135deg, #1a1a2e, #16213e);
          border: 1px solid rgba(255, 255, 255, 0.1);
          border-radius: 15px;
          overflow: hidden;
          box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
        }

        .auth-modal .modal-header {
          border-bottom: 1px solid rgba(255, 255, 255, 0.1);
          padding: 20px;
          position: relative;
        }

        .auth-modal .modal-title {
          font-weight: 700;
          font-size: 24px;
          color: var(--lighter);
          font-family: 'Montserrat', sans-serif;
        }

        .auth-modal .btn-close {
          filter: invert(1);
          opacity: 0.7;
        }

        .auth-modal .modal-body {
          padding: 25px;
        }

        .auth-form .form-control {
          background: rgba(30, 30, 46, 0.7);
          border: 1px solid rgb(255 255 255 / 17%);
          color: var(--lighter);
          padding: 12px 15px;
          border-radius: 8px;
          margin-bottom: 10px; /* Reduced for error space */
          transition: all 0.3s;
        }

        .auth-form .form-control:focus {
          border-color: var(--primary);
          box-shadow: 0 0 0 0.25rem rgba(225, 48, 108, 0.25);
        }

        .auth-form .form-label {
          color: var(--light);
          margin-bottom: 8px;
          font-weight: 500;
        }

        .auth-form .btn-submit {
          background: linear-gradient(45deg, var(--primary), var(--secondary));
          border: none;
          padding: 12px 25px;
          font-weight: 600;
          border-radius: 50px;
          width: 100%;
          margin-top: 10px;
          transition: all 0.3s;
          box-shadow: 0 5px 15px rgba(225, 48, 108, 0.4);
        }

        .auth-form .btn-submit:hover {
          transform: translateY(-3px);
          box-shadow: 0 8px 20px rgba(225, 48, 108, 0.6);
        }

        .auth-form .divider {
          display: flex;
          align-items: center;
          text-align: center;
          color: var(--light);
          margin: 20px 0;
        }

        .auth-form .divider::before,
        .auth-form .divider::after {
          content: '';
          flex: 1;
          border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .auth-form .divider:not(:empty)::before {
          margin-right: .25em;
        }

        .auth-form .divider:not(:empty)::after {
          margin-left: .25em;
        }

        .auth-form .social-login {
          display: flex;
          justify-content: center;
          gap: 15px;
          margin-bottom: 20px;
        }

        .auth-form .social-btn {
          width: 45px;
          height: 45px;
          border-radius: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
          background: rgba(255, 255, 255, 0.1);
          color: var(--lighter);
          transition: all 0.3s;
        }

        .auth-form .social-btn:hover {
          transform: translateY(-3px);
          background: var(--primary);
        }

        .auth-form .auth-switch {
          text-align: center;
          margin-top: 20px;
          color: var(--light);
        }

        .auth-form .auth-switch a {
          color: var(--primary);
          text-decoration: none;
          font-weight: 600;
        }

        .auth-form .auth-switch a:hover {
          text-decoration: underline;
        }
        
        /* Validation styles */
        .error-message {
            color: #ff6b6b;
            font-size: 13px;
            margin-top: -10px;
            margin-bottom: 10px;
            display: block;
        }
        
        .input-error {
            border: 1px solid #ff6b6b !important;
        }

        .notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 25px;
    background: linear-gradient(135deg, #E1306C, #405DE6);
    color: white;
    border-radius: 10px;
    z-index: 10000;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    animation: fadeInOut 3s forwards;
    display: flex;
    align-items: center;
    gap: 10px;
}

.notification.success {
    background: linear-gradient(135deg, #4CAF50, #2E7D32);
}

.notification.error {
    background: linear-gradient(135deg, #F44336, #C62828);
}

@keyframes fadeInOut {
    0% { opacity: 0; transform: translateY(-20px); }
    10% { opacity: 1; transform: translateY(0); }
    90% { opacity: 1; transform: translateY(0); }
    100% { opacity: 0; transform: translateY(-20px); }
}
    </style>
</head>
<body>
    <div id="notification" class="notification" style="display: none;"></div>
    <!-- Login Modal -->
    <div class="modal fade auth-modal" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Login to SOUND Group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="auth-form" id="loginForm" method="POST" action="verification/login.php" autocomplete="off">
                        <div class="mb-3">
                            <label for="loginEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="loginEmail" name="useremail" placeholder="name@example.com" required autocomplete="off">
                            <div id="loginEmailError" class="error-message"></div>
                        </div>
                        <div class="mb-3">
                            <label for="loginPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="loginPassword" name="userpass" placeholder="••••••••" required autocomplete="new-password">
                            <div id="loginPasswordError" class="error-message"></div>
                        </div>
                        <button type="submit" class="btn btn-submit">Login</button>
                        <div class="auth-switch">
                            Don't have an account? <a href="#" data-bs-toggle="modal" data-bs-target="#signupModal"
                                data-bs-dismiss="modal">Sign up</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Signup Modal -->
    <div class="modal fade auth-modal" id="signupModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create an Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="auth-form" id="signupForm" action="verification/signup.php" method="POST">
                        <div class="mb-3">
                            <label for="signupName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="signupName" name="regname" placeholder="John Smith" required>
                            <div id="signupNameError" class="error-message"></div>
                        </div>
                        <div class="mb-3">
                            <label for="signupEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="signupEmail" name="regemail" placeholder="name@example.com" required autocomplete="off">
                            <div id="signupEmailError" class="error-message"></div>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="signupPassword" class="form-label">Password</label>
                            <div style="position: relative;">
                                <input type="password" class="form-control" id="signupPassword" name="regpass" placeholder="••••••••" required autocomplete="new-password">
                                <i class="bi bi-eye-slash toggle-eye" onclick="togglePassword('signupPassword', this)" style="position:absolute; top:50%; right:10px; transform:translateY(-50%); cursor:pointer;"></i>
                            </div>
                            <div id="signupPasswordError" class="error-message"></div>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="signupConfirmPassword" class="form-label">Confirm Password</label>
                            <div style="position: relative;">
                                <input type="password" class="form-control" id="signupConfirmPassword" name="regconpass" placeholder="••••••••" required autocomplete="new-password">
                                <i class="bi bi-eye-slash toggle-eye" onclick="togglePassword('signupConfirmPassword', this)" style="position:absolute; top:50%; right:10px; transform:translateY(-50%); cursor:pointer;"></i>
                            </div>
                            <div id="signupConfirmPasswordError" class="error-message"></div>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="+92334857355" required>
                            <div id="phoneError" class="error-message"></div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Sadar, Block-14 Street 11" required>
                            <div id="addressError" class="error-message"></div>
                        </div>
                        <button type="submit" class="btn btn-submit">Sign Up</button>
                        <div class="auth-switch">
                            Already have an account? <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal"
                                data-bs-dismiss="modal">Log in</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>




function togglePassword(fieldId, iconElement) {
    const input = document.getElementById(fieldId);
    if (input.type === "password") {
        input.type = "text";
        iconElement.classList.remove("bi-eye-slash");
        iconElement.classList.add("bi-eye");
    } else {
        input.type = "password";
        iconElement.classList.remove("bi-eye");
        iconElement.classList.add("bi-eye-slash");
    }
}



		
        document.addEventListener('DOMContentLoaded', function() {
    // Show notification function
    function showNotification(message, type = 'info') {
        const notification = document.getElementById('notification');
        notification.textContent = message;
        notification.className = `notification ${type}`;
        notification.style.display = 'flex';
        
        setTimeout(() => {
            notification.style.display = 'none';
        }, 3000);
    }

    // Login validation
    document.getElementById('loginForm').onsubmit = async function(e) {
    e.preventDefault();
    
    const email = document.getElementById('loginEmail').value.trim();
    const pass = document.getElementById('loginPassword').value;
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
    
    clearErrors('loginForm');
    
    let valid = true;
    
    if (!email) {
        showError('loginEmail', 'Email is required');
        valid = false;
    } else if (!emailPattern.test(email)) {
        showError('loginEmail', 'Please enter a valid email');
        valid = false;
    }
    
    if (!pass) {
        showError('loginPassword', 'Password is required');
        valid = false;
    } else if (pass.length < 8) {
        showError('loginPassword', 'Password must be at least 8 characters');
        valid = false;
    }
    
    if (valid) {
            try {
                const formData = new FormData(this);
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json(); // ✅ Correct way

                if (result.status === 'success') {
                    showNotification(result.message, 'success');

                    setTimeout(() => {
                        window.location.href = result.redirect;
                    }, 2000);
                } else {
                    showNotification(result.message || 'Login failed.', 'error');
                }
            } catch (error) {
                showNotification('Invalid email or password.', 'error');
            }
        }
};

    
    // Signup validation
    document.getElementById('signupForm').onsubmit = async function(e) {
        e.preventDefault();
        
        const name = document.getElementById('signupName').value.trim();
        const email = document.getElementById('signupEmail').value.trim();
        const pass = document.getElementById('signupPassword').value;
        const conPass = document.getElementById('signupConfirmPassword').value;
        const phone = document.getElementById('phone').value.trim();
        const address = document.getElementById('address').value.trim();
        
        const namePattern = /^[a-zA-Z][a-zA-Z0-9 ]{2,14}$/;
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
        const passwordPattern = /^[a-zA-Z0-9]+$/;
        const phonePattern = /^\+?\d{10,15}$/;
        
        clearErrors('signupForm');
        
        let valid = true;
        
        if (!name) {
            showError('signupName', 'Full name is required');
            valid = false;
        } else if (!namePattern.test(name)) {
            showError('signupName', 'Name must be 3-15 characters, start with a letter');
            valid = false;
        }

        if (!email) {
            showError('signupEmail', 'Email is required');
            valid = false;
        } else if (!emailPattern.test(email)) {
            showError('signupEmail', 'Please enter a valid email');
            valid = false;
        }
        
        if (!pass) {
            showError('signupPassword', 'Password is required');
            valid = false;
        } else if (pass.length < 8) {
            showError('signupPassword', 'Password must be at least 8 characters');
            valid = false;
        } else if (!passwordPattern.test(pass)) {
            showError('signupPassword', 'Password cannot contain special characters');
            valid = false;
        }
        
        if (!conPass) {
            showError('signupConfirmPassword', 'Please confirm your password');
            valid = false;
        } else if (pass !== conPass) {
            showError('signupConfirmPassword', 'Passwords do not match');
            valid = false;
        }
        
        if (!phone) {
            showError('phone', 'Phone number is required');
            valid = false;
        } else if (!phonePattern.test(phone)) {
            showError('phone', 'Please enter a valid phone number');
            valid = false;
        }
        
        if (!address) {
            showError('address', 'Address is required');
            valid = false;
        } else if (address.length < 10) {
            showError('address', 'Address is too short');
            valid = false;
        }
        
        if (valid) {
            try {
                const formData = new FormData(this);
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.text();
                
                if (response.ok) {
                    showNotification('Registration successful! Please login.', 'success');
                    // Switch to login modal after successful registration
                    setTimeout(() => {
                        const signupModal = bootstrap.Modal.getInstance(document.getElementById('signupModal'));
                        signupModal.hide();
                        new bootstrap.Modal(document.getElementById('loginModal')).show();
                    }, 1500);
                } else {
                    showNotification(result || 'Registration failed. Please try again.', 'error');
                }
            } catch (error) {
                showNotification('An error occurred. Please try again.', 'error');
            }
        }
    };
    
    // Helper functions
    function showError(fieldId, message) {
        const field = document.getElementById(fieldId);
        const errorElement = document.getElementById(`${fieldId}Error`);
        
        if (field && errorElement) {
            field.classList.add('input-error');
            errorElement.textContent = message;
        }
    }
    
    function clearErrors(formId) {
        const form = document.getElementById(formId);
        const errorFields = form.querySelectorAll('.input-error');
        const errorMessages = form.querySelectorAll('.error-message');
        
        errorFields.forEach(field => field.classList.remove('input-error'));
        errorMessages.forEach(el => el.textContent = '');
    }
    
    // URL parameter handling
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    const success = urlParams.get('success');
    
    if (error) showNotification(error, 'error');
    if (success) showNotification(success, 'success');
    
    // Clean URL after showing notifications
    if (error || success) {
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});
        
        // Password visibility toggle
        function togglePassword(fieldId, iconElement) {
            const input = document.getElementById(fieldId);
            if (input.type === "password") {
                input.type = "text";
                iconElement.classList.remove("bi-eye-slash");
                iconElement.classList.add("bi-eye");
            } else {
                input.type = "password";
                iconElement.classList.remove("bi-eye");
                iconElement.classList.add("bi-eye-slash");
            }
        }
    </script>
</body>
</html>