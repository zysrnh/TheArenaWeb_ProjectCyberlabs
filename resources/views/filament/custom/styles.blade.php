<style>
    /* Import Montserrat font */
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap');

    /* ==== FULL PAGE BACKGROUND ==== */
    html, body {
        height: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    body {
        background: url("{{ asset('images/BgAdmin.jpg') }}") no-repeat center center fixed !important;
        background-size: cover !important;
    }

    /* HAPUS background default wrapper FILAMENT */
    .fi-body {
        background: transparent !important;
    }

    /* HAPUS background biru pada layout utama */
    .filament-panels-auth-page {
        background: transparent !important;
    }

    /* Container utama juga transparent */
    .fi-simple-page {
        background: transparent !important;
    }

    /* === LOGIN CARD === */
    .filament-login-page,
    .fi-simple-main {
        background: rgba(0, 0, 0, 0.85) !important;
        border-radius: 0.5rem !important;
        backdrop-filter: blur(12px) !important;
        padding: 2.5rem !important;
        max-width: 28rem !important;
        margin: 0 auto !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
    }

    /* Logo di atas form - gunakan LogoW.png */
    .fi-logo {
        width: 7rem !important;
        height: auto !important;
        content: url("{{ asset('images/LogoR.png') }}") !important;
        filter: brightness(1.1) !important;
    }

    /* Heading/Title - SIGN IN dengan Montserrat */
    .fi-simple-header-heading {
        color: #ffffff !important;
        font-family: 'Montserrat', sans-serif !important;
        font-weight: 800 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        font-size: 1.75rem !important;
    }

    /* Label */
    .fi-fo-field-wrp label {
        color: #ffffff !important;
        font-family: 'Montserrat', sans-serif !important;
        font-weight: 600 !important;
    }

    /* Tombol */
    .fi-btn-primary {
        background-color: #43BA66 !important;
        border-radius: 0.4rem !important;
        font-weight: 700 !important;
        color: #ffffff !important;
        font-family: 'Montserrat', sans-serif !important;
        text-transform: uppercase !important;
        letter-spacing: 0.03em !important;
        padding: 0.75rem 1.5rem !important;
    }

    .fi-btn-primary:hover {
        background-color: #3aa558 !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 12px rgba(67, 186, 102, 0.3) !important;
    }

    /* Input */
    .fi-input {
        background: rgba(255, 255, 255, 0.15) !important;
        border: 1px solid rgba(255, 255, 255, 0.25) !important;
        color: #ffffff !important;
        border-radius: 0.4rem !important;
        font-family: 'Montserrat', sans-serif !important;
    }

    .fi-input::placeholder {
        color: #d0d0d0 !important;
        font-family: 'Montserrat', sans-serif !important;
    }

    .fi-input:focus {
        border-color: #43BA66 !important;
        box-shadow: 0 0 0 3px rgba(67, 186, 102, 0.25) !important;
        background: rgba(255, 255, 255, 0.2) !important;
    }

    /* Link (Forgot Password, dll) */
    .fi-link {
        color: #43BA66 !important;
        font-family: 'Montserrat', sans-serif !important;
        font-weight: 600 !important;
    }

    .fi-link:hover {
        color: #3aa558 !important;
        text-decoration: underline !important;
    }

    /* Checkbox Remember Me */
    .fi-checkbox-wrp {
        color: #ffffff !important;
        font-family: 'Montserrat', sans-serif !important;
    }

    /* Text putih untuk semua text */
    .fi-simple-page * {
        color: #ffffff;
        font-family: 'Montserrat', sans-serif !important;
    }

    /* Error message tetap merah */
    .fi-fo-field-wrp-error-message {
        color: #ff5252 !important;
        font-family: 'Montserrat', sans-serif !important;
        font-weight: 500 !important;
    }

    /* Subheading jika ada */
    .fi-simple-header-subheading {
        color: rgba(255, 255, 255, 0.8) !important;
        font-family: 'Montserrat', sans-serif !important;
    }

    /* Card tidak putih - pastikan transparent/gelap */
    .fi-simple-main,
    .fi-simple-header {
        background: transparent !important;
    }
</style>