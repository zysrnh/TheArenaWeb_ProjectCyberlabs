<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap');
    
    * {
        font-family: 'Montserrat', sans-serif !important;
    }
    
    /* ==== ANIMATIONS ==== */
    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-10px);
        }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* ==== FULL PAGE BACKGROUND ==== */
    html, body {
        height: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    body {
        background: #013064 !important;
        position: relative;
        overflow-x: hidden;
    }
    
    /* Animated Background Elements */
    body::before,
    body::after {
        content: '';
        position: fixed;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.15;
        pointer-events: none;
        z-index: 0;
    }
    
    body::before {
        width: 400px;
        height: 400px;
        background: #ffd22f;
        top: 10%;
        left: 5%;
        animation: float 6s ease-in-out infinite;
    }
    
    body::after {
        width: 500px;
        height: 500px;
        background: #ffd22f;
        bottom: 10%;
        right: 5%;
        animation: float 8s ease-in-out infinite;
        animation-delay: 2s;
    }

    /* HAPUS background default wrapper FILAMENT */
    .fi-body,
    .filament-panels-auth-page,
    .fi-simple-page {
        background: transparent !important;
        position: relative;
        z-index: 1;
    }

    /* === LOGIN CARD === */
    .fi-simple-main {
        background: rgba(255, 255, 255, 0.95) !important;
        border-radius: 1rem !important;
        backdrop-filter: blur(20px) !important;
        padding: 3rem !important;
        max-width: 28rem !important;
        margin: 0 auto !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
        animation: fadeInUp 0.6s ease-out;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
    }

    /* Logo di atas form */
    .fi-logo {
        width: 6rem !important;
        height: auto !important;
        margin-bottom: 1rem !important;
        filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
    }

    /* Heading/Title */
    .fi-simple-header-heading {
        color: #013064 !important;
        font-size: 2rem !important;
        font-weight: 800 !important;
        text-align: center !important;
        margin-bottom: 2rem !important;
        letter-spacing: -0.5px;
    }

    /* Label */
    .fi-fo-field-wrp label {
        color: #013064 !important;
        font-weight: 600 !important;
        font-size: 0.875rem !important;
        margin-bottom: 0.5rem !important;
    }

    /* Input */
    .fi-input {
        background: #ffffff !important;
        border: 2px solid #e5e7eb !important;
        color: #1f2937 !important;
        border-radius: 0.5rem !important;
        padding: 0.75rem 1rem !important;
        font-size: 1rem !important;
        transition: all 0.3s ease !important;
    }

    .fi-input::placeholder {
        color: #9ca3af !important;
    }

    .fi-input:focus {
        border-color: #ffd22f !important;
        box-shadow: 0 0 0 3px rgba(255, 210, 47, 0.2) !important;
        outline: none !important;
    }

    /* Tombol Login */
    .fi-btn-primary {
        background: linear-gradient(135deg, #ffd22f 0%, #ffb800 100%) !important;
        border: none !important;
        border-radius: 0.5rem !important;
        font-weight: 700 !important;
        color: #013064 !important;
        padding: 0.875rem 1.5rem !important;
        font-size: 1.125rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 4px 14px rgba(255, 210, 47, 0.4) !important;
    }

    .fi-btn-primary:hover {
        background: linear-gradient(135deg, #ffe066 0%, #ffd22f 100%) !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(255, 210, 47, 0.5) !important;
    }

    .fi-btn-primary:active {
        transform: translateY(0) !important;
    }

    /* Link (Forgot Password, Register) */
    .fi-link {
        color: #013064 !important;
        font-weight: 600 !important;
        transition: color 0.3s ease !important;
    }

    .fi-link:hover {
        color: #ffd22f !important;
        text-decoration: underline !important;
    }

    /* Checkbox Remember Me */
    .fi-checkbox-wrp,
    .fi-checkbox-wrp label {
        color: #4b5563 !important;
        font-weight: 500 !important;
    }

    input[type="checkbox"]:checked {
        accent-color: #ffd22f !important;
    }

    /* Text hitam untuk konten form */
    .fi-simple-main * {
        color: #1f2937 !important;
    }

    /* Kecuali label dan heading yang sudah diatur */
    .fi-simple-header-heading,
    .fi-fo-field-wrp label,
    .fi-link {
        color: inherit !important;
    }

    /* Error message tetap merah */
    .fi-fo-field-wrp-error-message,
    .fi-fo-field-wrp-error-message * {
        color: #ef4444 !important;
    }

    /* Input error state */
    .fi-input[aria-invalid="true"] {
        border-color: #ef4444 !important;
    }

    /* Footer text */
    .fi-simple-footer {
        margin-top: 2rem !important;
    }

    .fi-simple-footer * {
        color: #6b7280 !important;
        text-align: center !important;
    }

    /* Loading spinner */
    .fi-btn-primary .animate-spin {
        border-color: #013064 !important;
        border-top-color: transparent !important;
    }
</style>