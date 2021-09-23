<?php

/**
 * Autoloader for plugin
 * 
 * Uses two PSR-4 namespaces
 * NFHubspot\\ in /src for plugin classes
 * NFHubspot\\EmailCRM\\ in /lib for files copypasted from old email-crm repo
 */
spl_autoload_register(function ($class) {

    $packagesCollection = [
        'NFHubspot\\' => __DIR__ . '/src/',
        'NFHubspot\\EmailCRM\\' => __DIR__ . '/lib/',
    ];

    foreach ($packagesCollection as $prefix => $base_dir) {

        $len = strlen($prefix);

        if (strncmp($prefix, $class, $len) === 0) {

            // get the relative class name
            $relative_class = substr($class, $len);

            // replace the namespace prefix with the base directory, replace namespace
            // separators with directory separators in the relative class name, append
            // with .php
            $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

            // if the file exists, require it
            if (file_exists($file)) {
                require $file;
            }
        }
    }
});
