<?php
// CTA Section Component with Enhanced Contact Form
// This component can be included on any page that needs a contact form CTA
?>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<section class="section cta">
  <div class="container">
    <div data-w-id="1e0a1e72-4093-0d56-1d87-734221b8fb07" class="cta-content">
      <div data-w-id="1e0a1e72-4093-0d56-1d87-734221b8fb08" class="cta-contact-form-wrap">
        <div class="cta-contact-form-title-wrapper">
          <h2 class="cta-contact-form-title">Contact Us For <span class="cta-contact-form-title-span">Your Research</span> Needs!</h2>
        </div>
        <div class="cta-contact-form-content">
          <div class="cta-contact-form-block w-form">
            <form id="cta-email-form" name="cta-email-form" method="POST" action="#" class="cta-contact-form" data-wf-form="false" novalidate>
              <!-- First row: Name and Email -->
              <div class="cta-contact-form-single-wrap">
                <div class="cta-form-field-wrapper">
                  <input class="cta-contact-form-text-field w-input" maxlength="100" name="name" placeholder="Your Name*" type="text" id="cta-name" required>
                  <div class="cta-field-error" id="cta-name-error"></div>
                </div>
                <div class="cta-form-field-wrapper">
                  <input class="cta-contact-form-text-field w-input" maxlength="255" name="email" placeholder="Enter Email*" type="email" id="cta-email" required>
                  <div class="cta-field-error" id="cta-email-error"></div>
                </div>
              </div>
              
              <!-- Second row: Phone and Company -->
              <div class="cta-contact-form-single-wrap">
                <div class="cta-form-field-wrapper">
                  <input class="cta-contact-form-text-field w-input" maxlength="20" name="phone" placeholder="Contact Number" type="tel" id="cta-phone">
                  <div class="cta-field-error" id="cta-phone-error"></div>
                </div>
                <div class="cta-form-field-wrapper">
                  <input class="cta-contact-form-text-field w-input" maxlength="100" name="company" placeholder="Company Name" type="text" id="cta-company">
                  <div class="cta-field-error" id="cta-company-error"></div>
                </div>
              </div>
              
              <!-- Third row: Subject (full width) -->
              <div class="cta-form-field-wrapper">
                <select class="cta-contact-form-text-field w-input" name="subject" id="cta-subject" required>
                  <option value="">Select Inquiry Type*</option>
                  <option value="General Inquiry">General Inquiry</option>
                  <option value="Product Information">Product Information</option>
                  <option value="Partnership Opportunities">Partnership Opportunities</option>
                  <option value="Quality Assurance">Quality Assurance</option>
                  <option value="Customer Support">Customer Support</option>
                  <option value="Warehousing & Inventory">Warehousing & Inventory</option>
                  <option value="Cold Chain Logistics">Cold Chain Logistics</option>
                  <option value="Order Fulfillment">Order Fulfillment</option>
                  <option value="Pharmaceutical Distribution">Pharmaceutical Distribution</option>
                  <option value="Regulatory Compliance">Regulatory Compliance</option>
                  <option value="Pricing & Quotation">Pricing & Quotation</option>
                  <option value="Technical Support">Technical Support</option>
                  <option value="Other">Other</option>
                </select>
                <div class="cta-field-error" id="cta-subject-error"></div>
              </div>
              
              <div class="cta-contact-form-textarea-wrapper">
                <div class="cta-form-field-wrapper cta-message-wrapper">
                  <textarea placeholder="Write Message (minimum 10 characters):" maxlength="5000" id="cta-message" name="message" class="cta-contact-form-textarea w-input" required></textarea>
                  <div class="cta-field-error" id="cta-message-error"></div>
                  <div class="cta-character-count" id="cta-message-count">0/5000 characters</div>
                </div>
              </div>
              
              <input type="submit" class="cta-contact-form-submit-button w-button" value="Submit Now" id="cta-submit-btn">
              <div class="cta-form-loading" id="cta-form-loading" style="display: none;">
                <div class="cta-loading-spinner"></div>
                <span>Submitting...</span>
              </div>
            </form>
            
            <!-- Success/Error messages will be inserted here by JavaScript -->
            <div id="cta-message-container" style="margin-top: 20px;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
/* CTA Form Validation Styles */
.cta-form-field-wrapper {
  position: relative;
  margin-bottom: 15px;
}

.cta-message-wrapper {
  margin-bottom: 5px; /* Reduced margin for last field */
}

.cta-field-error {
  color: #dc3545;
  font-size: 12px;
  margin-top: 5px;
  display: none;
}

.cta-field-error.show {
  display: block;
}

.cta-contact-form-text-field.error,
.cta-contact-form-textarea.error {
  border-color: #dc3545 !important;
  box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
}

.cta-contact-form-text-field.valid,
.cta-contact-form-textarea.valid {
  border-color: #28a745 !important;
  box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
}

.cta-character-count {
  font-size: 12px;
  color: #6c757d;
  text-align: right;
  margin-top: 5px;
}

.cta-character-count.warning {
  color: #ffc107;
}

.cta-character-count.danger {
  color: #dc3545;
}

.cta-form-loading {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  margin-top: 15px;
  color: #6c757d;
}

.cta-loading-spinner {
  width: 20px;
  height: 20px;
  border: 2px solid #f3f3f3;
  border-top: 2px solid #bf1025;
  border-radius: 50%;
  animation: ctaSpin 1s linear infinite;
}

@keyframes ctaSpin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.cta-contact-form-submit-button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* Two-column layout for form rows */
.cta-contact-form-single-wrap {
  display: flex !important;
  flex-direction: row !important;
  gap: 24px !important;
  justify-content: flex-start !important;
  align-items: flex-start !important;
  margin-bottom: 15px !important;
}

.cta-contact-form-single-wrap .cta-form-field-wrapper {
  flex: 1 !important;
  margin-bottom: 0 !important;
}

/* Mobile responsive for CTA form */
@media (max-width: 768px) {
  .cta-contact-form-single-wrap {
    flex-direction: column !important;
    gap: 0 !important;
  }
  
  .cta-contact-form-single-wrap .cta-form-field-wrapper {
    width: 100% !important;
    flex: none !important;
    margin-bottom: 15px !important;
  }
  
  .cta-contact-form-single-wrap .cta-form-field-wrapper:last-child {
    margin-bottom: 0 !important;
  }
  
  .cta-contact-form-text-field {
    width: 100% !important;
  }
  
  .cta-form-field-wrapper {
    width: 100% !important;
  }
}

/* Enhanced styling for form fields */
.cta-contact-form-text-field,
.cta-contact-form-textarea {
  transition: all 0.3s ease !important;
}

.cta-contact-form-text-field:focus,
.cta-contact-form-textarea:focus {
  border-color: #bf1025 !important;
  box-shadow: 0 0 0 2px rgba(191, 16, 37, 0.2) !important;
}

/* Success message styling */
.cta-alert-success {
  background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
  color: #155724;
  padding: 20px;
  border-radius: 12px;
  margin-bottom: 25px;
  border: 1px solid #c3e6cb;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  position: relative;
  animation: ctaSlideInDown 0.5s ease-out;
}

@keyframes ctaSlideInDown {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Form overlay for loading state */
.cta-form-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  backdrop-filter: blur(5px);
}

.cta-form-overlay.show {
  display: flex;
}

.cta-overlay-content {
  background: white;
  padding: 40px;
  border-radius: 20px;
  text-align: center;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
  max-width: 400px;
  width: 90%;
}

.cta-overlay-spinner {
  width: 60px;
  height: 60px;
  border: 4px solid #f3f3f3;
  border-top: 4px solid #a00d1f;
  border-radius: 50%;
  animation: ctaSpin 1s linear infinite;
  margin: 0 auto 20px;
}

.cta-overlay-title {
  font-size: 24px;
  font-weight: 600;
  color: #a00d1f;
  margin-bottom: 10px;
}

.cta-overlay-message {
  font-size: 16px;
  color: #666;
  line-height: 1.5;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const ctaForm = document.getElementById('cta-email-form');
  if (!ctaForm) return;
  
  // Validation functions (same as contact-us.php)
  function validateName(name) {
    if (!name) return 'Name is required.';
    if (name.length < 2) return 'Name must be at least 2 characters long.';
    if (name.length > 100) return 'Name must be less than 100 characters.';
    if (!/^[a-zA-Z\s\-'\.]+$/.test(name)) return 'Name can only contain letters, spaces, hyphens, apostrophes, and periods.';
    return null;
  }
  
  function validateEmail(email) {
    if (!email) return 'Email is required.';
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) return 'Please enter a valid email address.';
    if (email.length > 255) return 'Email must be less than 255 characters.';
    return null;
  }
  
  function validatePhone(phone) {
    if (!phone) return null; // Phone is optional
    
    // Remove all non-digit characters for validation
    const digitsOnly = phone.replace(/\D/g, '');
    
    // Check if it has at least 7 digits and not more than 15
    if (digitsOnly.length < 7 || digitsOnly.length > 15) {
      return 'Invalid phone number.';
    }
    
    // Check if it contains valid characters (digits, +, -, spaces, parentheses)
    const validCharsRegex = /^[\d\+\-\s\(\)]+$/;
    if (!validCharsRegex.test(phone)) {
      return 'Invalid phone number.';
    }
    
    return null;
  }
  
  function validateSubject(subject) {
    if (!subject || subject.trim() === '') return 'Please select an inquiry type.';
    return null;
  }
  
  function validateMessage(message) {
    if (!message) return 'Message is required.';
    if (message.length < 10) return 'Message must be at least 10 characters long.';
    if (message.length > 5000) return 'Message must be less than 5000 characters.';
    return null;
  }
  
  function showFieldError(fieldName, message) {
    const errorElement = document.getElementById(`cta-${fieldName}-error`);
    const inputElement = document.getElementById(`cta-${fieldName}`);
    if (errorElement && inputElement) {
      errorElement.textContent = message;
      errorElement.classList.add('show');
      inputElement.classList.add('error');
      inputElement.classList.remove('valid');
    }
  }
  
  function clearFieldError(fieldName) {
    const errorElement = document.getElementById(`cta-${fieldName}-error`);
    const inputElement = document.getElementById(`cta-${fieldName}`);
    if (errorElement && inputElement) {
      errorElement.classList.remove('show');
      inputElement.classList.remove('error');
      inputElement.classList.add('valid');
    }
  }
  
  function clearAllErrors() {
    const errorElements = ctaForm.querySelectorAll('.cta-field-error');
    const inputElements = ctaForm.querySelectorAll('.cta-contact-form-text-field, .cta-contact-form-textarea');
    
    errorElements.forEach(el => el.classList.remove('show'));
    inputElements.forEach(el => {
      el.classList.remove('error', 'valid');
    });
  }
  
  function showFormOverlay() {
    let overlay = document.getElementById('cta-form-overlay');
    if (!overlay) {
      overlay = document.createElement('div');
      overlay.id = 'cta-form-overlay';
      overlay.className = 'cta-form-overlay';
      overlay.innerHTML = `
        <div class="cta-overlay-content">
          <div class="cta-overlay-spinner"></div>
          <div class="cta-overlay-title">Sending Message</div>
          <div class="cta-overlay-message">Please wait while we process your request...</div>
        </div>
      `;
      document.body.appendChild(overlay);
    }
    overlay.classList.add('show');
  }
  
  function hideFormOverlay() {
    const overlay = document.getElementById('cta-form-overlay');
    if (overlay) {
      overlay.classList.remove('show');
    }
  }
  
  function showSuccessMessage(message) {
    const container = document.getElementById('cta-message-container');
    if (!container) return;
    
    const successDiv = document.createElement('div');
    successDiv.className = 'cta-alert-success';
    successDiv.innerHTML = `
      <div style="display: flex; align-items: flex-start;">
        <div style="background: #28a745; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin-right: 15px; flex-shrink: 0;">
          <span style="font-size: 20px; color: white;">✓</span>
        </div>
        <div style="flex: 1;">
          <h4 style="margin: 0 0 8px 0; font-size: 18px; font-weight: 600; color: #155724;">Message Sent Successfully!</h4>
          <p style="margin: 0; font-size: 14px; line-height: 1.5; color: #155724;">${message}</p>
          <div style="margin-top: 12px; font-size: 12px; color: #6c757d;">
            <span>📧 We'll get back to you within 24 hours</span>
          </div>
        </div>
        <button onclick="this.parentElement.parentElement.remove()" style="background: none; border: none; font-size: 20px; color: #155724; margin-left: 10px; cursor: pointer; padding: 5px; border-radius: 50%; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='rgba(21,87,36,0.1)'" onmouseout="this.style.backgroundColor='transparent'">&times;</button>
      </div>
    `;
    
    container.innerHTML = '';
    container.appendChild(successDiv);
    
    // Auto-hide after 10 seconds
    setTimeout(() => {
      if (successDiv.parentNode) {
        successDiv.remove();
      }
    }, 10000);
  }
  
  // Real-time validation
  const nameInput = ctaForm.querySelector('input[name="name"]');
  const emailInput = ctaForm.querySelector('input[name="email"]');
  const phoneInput = ctaForm.querySelector('input[name="phone"]');
  const subjectSelect = ctaForm.querySelector('select[name="subject"]');
  const messageTextarea = ctaForm.querySelector('textarea[name="message"]');
  
  // Name validation
  if (nameInput) {
    nameInput.addEventListener('blur', function() {
      const error = validateName(this.value.trim());
      if (error) {
        showFieldError('name', error);
      } else {
        clearFieldError('name');
      }
    });
  }
  
  // Email validation
  if (emailInput) {
    emailInput.addEventListener('blur', function() {
      const error = validateEmail(this.value.trim());
      if (error) {
        showFieldError('email', error);
      } else {
        clearFieldError('email');
      }
    });
  }
  
  // Phone validation
  if (phoneInput) {
    phoneInput.addEventListener('blur', function() {
      const error = validatePhone(this.value.trim());
      if (error) {
        showFieldError('phone', error);
      } else {
        clearFieldError('phone');
      }
    });
  }
  
  // Subject validation
  if (subjectSelect) {
    subjectSelect.addEventListener('change', function() {
      // Add a small delay to ensure the value is properly set
      setTimeout(() => {
        const error = validateSubject(this.value);
        if (error) {
          showFieldError('subject', error);
        } else {
          clearFieldError('subject');
        }
      }, 10);
    });
  }
  
  // Message validation and character count
  if (messageTextarea) {
    const messageCount = document.getElementById('cta-message-count');
    
    messageTextarea.addEventListener('input', function() {
      const length = this.value.length;
      if (messageCount) {
        messageCount.textContent = `${length}/5000 characters`;
        messageCount.classList.remove('warning', 'danger');
        
        if (length > 4500) {
          messageCount.classList.add('danger');
        } else if (length > 4000) {
          messageCount.classList.add('warning');
        }
      }
    });
    
    messageTextarea.addEventListener('blur', function() {
      const error = validateMessage(this.value.trim());
      if (error) {
        showFieldError('message', error);
      } else {
        clearFieldError('message');
      }
    });
  }
  
  // Form submission
  ctaForm.addEventListener('submit', function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    // Clear previous errors
    clearAllErrors();
    
    // Get form values
    const name = nameInput ? nameInput.value.trim() : '';
    const email = emailInput ? emailInput.value.trim() : '';
    const phone = phoneInput ? phoneInput.value.trim() : '';
    const subject = subjectSelect ? subjectSelect.value : '';
    const message = messageTextarea ? messageTextarea.value.trim() : '';
    
    // Validate all fields
    let hasErrors = false;
    
    const nameError = validateName(name);
    if (nameError) {
      showFieldError('name', nameError);
      hasErrors = true;
    }
    
    const emailError = validateEmail(email);
    if (emailError) {
      showFieldError('email', emailError);
      hasErrors = true;
    }
    
    const phoneError = validatePhone(phone);
    if (phoneError) {
      showFieldError('phone', phoneError);
      hasErrors = true;
    }
    
    const subjectError = validateSubject(subject);
    if (subjectError) {
      showFieldError('subject', subjectError);
      hasErrors = true;
    }
    
    const messageError = validateMessage(message);
    if (messageError) {
      showFieldError('message', messageError);
      hasErrors = true;
    }
    
    if (hasErrors) {
      // Scroll to first error
      const firstError = ctaForm.querySelector('.cta-field-error.show');
      if (firstError) {
        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
      return false;
    }
    
    // Show loading state
    showFormOverlay();
    const submitBtn = ctaForm.querySelector('#cta-submit-btn');
    const loadingDiv = document.getElementById('cta-form-loading');
    
    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.style.display = 'none';
    }
    if (loadingDiv) {
      loadingDiv.style.display = 'flex';
    }
    
    // Prepare form data
    const formData = new FormData();
    formData.append('name', name);
    formData.append('email', email);
    formData.append('phone', phone);
    formData.append('company', ctaForm.querySelector('input[name="company"]')?.value.trim() || '');
    formData.append('subject', subject);
    formData.append('message', message);
    
    // Submit via AJAX
    fetch('contact-handler.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      hideFormOverlay();
      
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.style.display = 'block';
      }
      if (loadingDiv) {
        loadingDiv.style.display = 'none';
      }
      
      if (data.success) {
        try {
          showSuccessMessage(data.message);
          ctaForm.reset();
          clearAllErrors();
          
          // Reset character count
          const messageCount = document.getElementById('cta-message-count');
          if (messageCount) {
            messageCount.textContent = '0/5000 characters';
            messageCount.classList.remove('warning', 'danger');
          }
        } catch (successError) {
          // Fallback to alert if showSuccessMessage fails
          Swal.fire({
            title: 'Success!',
            text: data.message,
            icon: 'success',
            confirmButtonText: 'OK'
          });
        }
      } else {
        // Handle server-side validation errors
        if (data.errors && Object.keys(data.errors).length > 0) {
          Object.keys(data.errors).forEach(field => {
            if (field !== 'general') {
              showFieldError(field, data.errors[field]);
            }
          });
          
          // If there are field errors, don't show the general alert
          if (data.errors.general) {
            Swal.fire({
              title: 'Error',
              text: data.errors.general,
              icon: 'error',
              confirmButtonText: 'OK'
            });
          }
        } else {
          // Show general error message only if no specific field errors
          Swal.fire({
            title: 'Error',
            text: data.message || 'Please check the form and try again.',
            icon: 'error',
            confirmButtonText: 'OK'
          });
        }
      }
    })
    .catch(error => {
      hideFormOverlay();
      
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.style.display = 'block';
      }
      if (loadingDiv) {
        loadingDiv.style.display = 'none';
      }
      
      Swal.fire({
        title: 'Network Error',
        text: 'Network error. Please check your connection and try again.',
        icon: 'error',
        confirmButtonText: 'OK'
      });
    });
  });
});
</script>
