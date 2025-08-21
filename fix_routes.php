<?php

$routesFile = __DIR__ . '/routes/web.php';
$content = file_get_contents($routesFile);

// Replace Admin controller references
$content = preg_replace("/'AdminController@([a-zA-Z]+)'/", "[AdminController::class, '$1']", $content);

// Replace Student controller references  
$content = preg_replace("/'StudentController@([a-zA-Z]+)'/", "[StudentController::class, '$1']", $content);

// Replace Teacher controller references
$content = preg_replace("/'TeacherController@([a-zA-Z]+)'/", "[TeacherController::class, '$1']", $content);

// Replace SuperAdmin controller references
$content = preg_replace("/'SuperAdminController@([a-zA-Z]+)'/", "[SuperAdminController::class, '$1']", $content);

// Remove namespace groups since we're using full class imports
$content = str_replace("'namespace' => 'Student', ", "", $content);
$content = str_replace("'namespace' => 'Teacher', ", "", $content);
$content = str_replace("'namespace' => 'SuperAdmin', ", "", $content);

// Clean up empty array entries
$content = preg_replace("/\[, /", "[", $content);

file_put_contents($routesFile, $content);

echo "Routes file has been updated successfully!\n";