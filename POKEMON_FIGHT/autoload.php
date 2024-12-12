<?php
spl_autoload_register(function ($class_name) {
    $directories = ['class/', 'interface/', 'trait/'];

    foreach ($directories as $directory) {
        $file = __DIR__ . '/' . $directory . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }

    // Vous pouvez ajouter un message de débogage si la classe n'est pas trouvée
    error_log("Autoloader : Impossible de charger la classe $class_name");
});