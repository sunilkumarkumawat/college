<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH)
);

// Strip leading /public/ if present
$cleanUri = preg_replace('#^/public#', '', $uri);

// Emulate Apache's mod_rewrite for PHP built-in web server
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

if ($cleanUri !== '/' && $cleanUri !== '' && file_exists(__DIR__.'/public'.$cleanUri)) {
    $_SERVER['REQUEST_URI'] = preg_replace('#^/public#', '', $_SERVER['REQUEST_URI']);
    return false;
}

// Normalize REQUEST_URI before passing to public/index.php
if (isset($_SERVER['REQUEST_URI']) && preg_match('#^/public(/.*)?$#', $_SERVER['REQUEST_URI'], $matches)) {
    $_SERVER['REQUEST_URI'] = !empty($matches[1]) ? $matches[1] : '/';
}
if (isset($_SERVER['PHP_SELF']) && preg_match('#^/public(/.*)?$#', $_SERVER['PHP_SELF'], $matches)) {
    $_SERVER['PHP_SELF'] = !empty($matches[1]) ? $matches[1] : '/';
}

require_once __DIR__.'/public/index.php';
