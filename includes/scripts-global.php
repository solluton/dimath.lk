<?php
// Global Scripts Component
// Usage: include 'includes/scripts-global.php';

// This component includes all necessary CSS and JS files

// Include URL helper and custom scripts helper
require_once __DIR__ . '/../config/url_helper.php';
require_once __DIR__ . '/../config/custom_scripts.php';
?>

<!-- Custom Head Scripts -->
<?php outputHeadScripts(); ?>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Global Styles (new design) -->
<link href="<?= asset('css/normalize.css') ?>" rel="stylesheet" type="text/css">
<link href="<?= asset('css/webflow.css') ?>" rel="stylesheet" type="text/css">
<link href="<?= asset('css/dimathsports-lk.webflow.css') ?>" rel="stylesheet" type="text/css">

<!-- Webflow JS -->
<script type="text/javascript">!function(o,c){var n=c.documentElement,t=" w-mod-";n.className+=t+"js",("ontouchstart"in o||o.DocumentTouch&&c instanceof DocumentTouch)&&(n.className+=t+"touch")}(window,document);</script>

<!-- Favicon -->
<link href="<?= asset('images/favicon.png') ?>" rel="shortcut icon" type="image/x-icon">
<link href="<?= asset('images/webclip.png') ?>" rel="apple-touch-icon">

<!-- Font Quality CSS -->
<style>
* {
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  -o-font-smoothing: antialiased;
}
</style>

