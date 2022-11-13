
<?php

use DeliciousBrains\WPMigrations\Database\AbstractMigration;

class DAProductTable extends AbstractMigration {

    public function run() {
        global $wpdb;

        $sql = "
            CREATE TABLE " . $wpdb->prefix . "da_products (
                id bigint(20) NOT NULL auto_increment,
                product_id bigint(20) NOT NULL UNIQUE,
                autoplus_inventory_id bigint(20) NOT NULL UNIQUE,
                vehicle_applications_hash text NULL,
                last_updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (id)
            ) {$this->get_collation()};
        ";

        dbDelta( $sql );
    }
	
    public function rollback() {
        global $wpdb;
        $wpdb->query("DROP TABLE {$wpdb->prefix}da_products");
    }
}
