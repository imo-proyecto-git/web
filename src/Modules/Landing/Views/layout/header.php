<!DOCTYPE html>
<html lang="<?= config('app.locale', 'es') ?>">
<head>
    <meta charset="<?= config('app.charset', 'utf-8') ?>"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= $title ?? config('app.name') ?></title>
    
    <!-- Design System - Font Loading -->
    <link href="<?= $font_url ?>" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="<?= $APP_URL ?>/assets/img/favicon.png">

    <!-- Tailwind Play CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "primary": "<?= $primary_color ?>",
              "secondary": "<?= $secondary_color ?>",
              "surface": "<?= $bg_light ?>",
              "surface-bright": "<?= $surface_light ?>",
              "outline-variant": "<?= $border_light ?>",
              "tertiary-fixed-dim": "<?= $gold_color ?>",
              "on-tertiary-container": "<?= $color_success ?>",
              "error-container": "<?= $color_warning ?>",
              "error": "<?= config('ui.colors.danger') ?>",
              "on-surface": "#131b2e",
              "on-surface-variant": "#444650",
              "primary-container": "<?= config('ui.colors.secondary') ?>",
              "surface-container-lowest": "#ffffff",
              "surface-container-low": "#f2f3ff",
              "surface-container": "#eaedff",
              "surface-container-high": "#e2e7ff",
              "surface-container-highest": "#dae2fd",
            },
            fontFamily: {
              "headline": [<?= $font_heading ?>],
              "body": [<?= $font_body ?>],
            },
            borderRadius: {
                "DEFAULT": "0.125rem", 
                "lg": "<?= config('ui.radius.sm') ?>", 
                "xl": "<?= config('ui.radius.md') ?>", 
                "full": "<?= config('ui.radius.pill') ?>"
            },
          },
        },
      }
    </script>

    <style>
      .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
      }
      .glass-card {
        background: <?= hexToRgba($surface_light, 0.7) ?>;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
      }
    </style>
</head>
<body class="bg-surface font-body text-on-surface">
<?php
/** Helper para convertir HEX a RGBA en el servidor si es necesario */
function hexToRgba($hex, $alpha = 1) {
    if (strpos($hex, 'rgba') === 0) return $hex;
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
        $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
        $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
    } else {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    }
    return "rgba($r, $g, $b, $alpha)";
}
?>
