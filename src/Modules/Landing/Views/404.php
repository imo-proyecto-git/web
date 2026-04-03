<?php include __DIR__ . '/layout/header.php'; ?>
<main class="flex flex-col items-center justify-center min-h-screen text-center px-8">
    <h1 class="text-9xl font-black text-primary/10 font-headline">404</h1>
    <h2 class="text-4xl font-bold text-primary -mt-12 mb-4">Página No Encontrada</h2>
    <p class="text-on-surface-variant max-w-md mb-8">Lo sentimos, la página que buscas no existe o ha sido movida.</p>
    <a href="<?= $APP_URL ?>" class="px-8 py-3 bg-primary text-white font-bold rounded-xl shadow-lg hover:shadow-primary/20 transition-all">
        Volver al Inicio
    </a>
</main>
<?php include __DIR__ . '/layout/footer.php'; ?>
