
<?php use DeliciousBrains\WPMigrations\Database\AbstractMigration;

class ProductSyncAlgoliaStagingTable extends AbstractMigration {

    public function run() {
        global $wpdb;
        
        $sql = "
            CREATE TABLE product_sync_algolia_staging (
                ID           int(20) NOT NULL auto_increment,
                BatchID      int(20) NOT NULL,
                InventoryID  varchar(50) NULL,
                PartNo       varchar(50) NULL,
                Discontinued bit NULL,
                PRIMARY KEY (ID),
                FOREIGN KEY (BatchID) REFERENCES product_sync_batch(ID)
            ) {$this->get_collation()};
        ";

        dbDelta( $sql );
    }
	
    public function rollback() {
        global $wpdb;
        $wpdb->query( 'DROP TABLE product_sync_algolia_staging');
    }
}