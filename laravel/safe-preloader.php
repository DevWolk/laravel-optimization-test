<?php

declare(strict_types=1);

register_shutdown_function(static function (): void {
    $error = error_get_last();

    if (!$error) {
        return;
    }

    echo 'Preloader Script has stopped with an error:' . PHP_EOL;
    echo 'Message: ' . $error['message'] . PHP_EOL;
    echo 'File: ' . $error['file'] . PHP_EOL;
});

require_once __DIR__ . '/preloader.php';
