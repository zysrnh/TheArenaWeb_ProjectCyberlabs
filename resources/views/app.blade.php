<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- CSRF -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
    rel="stylesheet">

  @viteReactRefresh
  @vite(['resources/css/app.css', 'resources/js/app.jsx'])
  @inertiaHead
</head>

<body>
  @routes
  @inertia

  <!-- GOOGLE TRANSLATE (hidden, dikontrol dari React) -->
  <div id="google_translate_element" style="display:none;"></div>

  <script>
    function googleTranslateElementInit() {
      new google.translate.TranslateElement({
        pageLanguage: 'id',
        includedLanguages: 'id,en',
        autoDisplay: false
      }, 'google_translate_element');
    }
  </script>

  <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>

</html>