<?php
// Simple debug script to check fee data
require_once 'vendor/autoload.php';

try {
    echo "=== Fee Management Debug ===\n\n";
    
    // Check if ClassFee model exists
    if (class_exists('App\Models\ClassFee')) {
        echo "✓ ClassFee model exists\n";
    } else {
        echo "✗ ClassFee model missing\n";
    }
    
    // Check if routes exist
    $routes_file = file_get_contents('routes/web.php');
    if (strpos($routes_file, 'admin.fees') !== false) {
        echo "✓ Fee routes registered\n";
    } else {
        echo "✗ Fee routes missing\n";
    }
    
    // Check if controller exists
    if (file_exists('app/Http/Controllers/Admin/FeeController.php')) {
        echo "✓ FeeController exists\n";
    } else {
        echo "✗ FeeController missing\n";
    }
    
    // Check if views exist
    if (file_exists('resources/views/admin/fee/index.blade.php')) {
        echo "✓ Fee index view exists\n";
    } else {
        echo "✗ Fee index view missing\n";
    }
    
    echo "\n=== Recommendations ===\n";
    echo "1. Check browser console for JavaScript errors\n";
    echo "2. Verify you're logged in as admin\n";
    echo "3. Check if session school_id is set\n";
    echo "4. Try adding a test fee first\n";
    echo "5. Check database connection\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>