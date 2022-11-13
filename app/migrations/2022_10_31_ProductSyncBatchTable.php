
<?php use DeliciousBrains\WPMigrations\Database\AbstractMigration;

class ProductSyncBatchTable extends AbstractMigration {

    public function run() {
        global $wpdb;

        $sql = "
            CREATE TABLE product_sync_batch (
                ID             int(20) NOT NULL auto_increment,
                DateStart      datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                DateCompleted  datetime NULL,
                Status         varchar(50) DEFAULT 'new',
                Message        varchar(50) NULL,
                LastModified   datetime NULL,
                Page           int(8) NULL,
                PRIMARY KEY (ID)
            ) {$this->get_collation()};
        ";

        dbDelta( $sql );
    }
	
    public function rollback() {
        global $wpdb;
        $wpdb->query( 'DROP TABLE product_sync_batch');
    }
}