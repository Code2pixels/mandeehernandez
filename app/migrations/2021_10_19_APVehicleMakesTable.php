
<?php use DeliciousBrains\WPMigrations\Database\AbstractMigration;

class APVehicleMakesTable extends AbstractMigration {

    public function run() {
        global $wpdb;

        $sql = "
            CREATE TABLE " . $wpdb->prefix . "ap_vehicle_makes (
                id bigint(20) NOT NULL auto_increment,
                make_name varchar(200) NULL,
                PRIMARY KEY (id)
            ) {$this->get_collation()};
        ";

        dbDelta( $sql );
    }
	
    public function rollback() {
        global $wpdb;
        $wpdb->query( 'DROP TABLE ' . $wpdb->prefix . 'ap_vehicle_makes');
    }
}