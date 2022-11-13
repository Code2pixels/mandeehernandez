
<?php use DeliciousBrains\WPMigrations\Database\AbstractMigration;

class DACustomerGaragesTable extends AbstractMigration {

    public function run() {
        global $wpdb;

        $sql = "
            CREATE TABLE " . $wpdb->prefix . "da_customer_garages (
                id bigint(20) NOT NULL auto_increment,
                customer_id bigint(20) unique NOT NULL,
                PRIMARY KEY (id)
            ) {$this->get_collation()};
        ";

        dbDelta( $sql );
    }
	
    public function rollback() {
        global $wpdb;
        $wpdb->query( 'DROP TABLE ' . $wpdb->prefix . 'da_customer_garages');
    }
}