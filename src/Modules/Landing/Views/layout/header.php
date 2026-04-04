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
              "tertiary": "<?= $tertiary_color ?>",
              "tertiary-container": "<?= $tertiary_container ?>",
              "on-tertiary-container": "<?= $on_tertiary_container ?>",
              "surface": "<?= $surface ?>",
              "surface-low": "<?= $surface_low ?>",
              "surface-highest": "<?= $surface_highest ?>",
              "surface-lowest": "<?= $surface_lowest ?>",
              "outline-variant": "<?= $border_light ?>",
              "error": "<?= config('ui.colors.danger', '#ba1a1a') ?>",
              "on-surface": "#131b2e",
              "on-surface-variant": "#444650",
            },
            fontFamily: {
              "headline": ["Manrope", "sans-serif"],
              "body": ["Inter", "sans-serif"],
            },
            borderRadius: {
                "none": "0",
                "sm": "<?= $radius_sm ?>", 
                "md": "<?= $radius_md ?>", 
                "lg": "8px", 
                "xl": "12px", 
                "2xl": "<?= $radius_lg ?>",
                "3xl": "<?= $radius_xl ?>",
                "full": "50rem"
            },
          },
        },
      }
    </script>

    <style>
      :root {
        --surface: <?= $surface ?>;
        --surface-low: <?= $surface_low ?>;
        --surface-lowest: <?= $surface_lowest ?>;
      }
      .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
      }
      .glass-card {
        background: <?= hexToRgba($surface_lowest, 0.7) ?>;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
      }
      .btn-primary {
        background: linear-gradient(135deg, <?= $primary_color ?>, <?= $secondary_color ?>);
        color: white;
        border-radius: 8px; /* 0.5rem equivalent */
        font-weight: 800;
        letter-spacing: -0.01em;
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
