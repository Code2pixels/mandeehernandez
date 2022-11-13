    <?php

/*
 * This script is meant to drop all products and orders from a WordPress database.
 *
 * It was originally written to remove the products and orders from the staging database
 * as a way to clean it up before importing the data into the new production database.
 * The products and orders are migrated over from the existing production database anyway.
 *  
 * Requires mysqli and vlucas/phpdotenv
*/

define('PROJECT_BASE_PATH', DIR(__DIR__));
define('PROJECT_VENDOR_PATH', PROJECT_BASE_PATH.'/vendor');

// Load Composer's autoloader
require_once PROJECT_VENDOR_PATH.'/autoload.php';

// Load dotenv?
if (class_exists('Dotenv\Dotenv') && file_exists(PROJECT_BASE_PATH.'/.env')) {
    Dotenv\Dotenv::createUnsafeImmutable(PROJECT_BASE_PATH)->load();
}

ini_set('memory_limit', '2G');
$db = new mysqli(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASSWORD'), getenv('DB_NAME'), 3306);

$all_products_result = $db->query("SELECT * FROM wp_posts WHERE post_type = 'product';");
$products = $all_products_result->fetch_all(MYSQLI_ASSOC);
foreach ($products as $product) {
    $db->query("DELETE FROM wp_postmeta WHERE post_id = " . $product['ID']);
    $db->query("DELETE FROM wp_posts WHERE ID = " . $product['ID']);
    echo "Deleted product post and meta with ID " . $product['ID'] . "\n";
}
unset($products);
mysqli_free_result($all_products_result);

$db->close();
echo "\nDone\n";
