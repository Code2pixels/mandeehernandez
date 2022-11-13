
<?php use DeliciousBrains\WPMigrations\Database\AbstractMigration;

class ProductSyncAutoplusAPIStateTable extends AbstractMigration {

    public function run() {
        global $wpdb;
        
        $sql = "
            CREATE TABLE product_sync_autoplus_api_state (
                LastModified   datetime NULL,
                CurrentPage    int(8) NOT NULL
            ) {$this->get_collation()};
        ";

        dbDelta( $sql );
    }
	
    public function rollback() {
        global $wpdb;
        $wpdb->query( 'DROP TABLE product_sync_autoplus_api_state');
    }
}