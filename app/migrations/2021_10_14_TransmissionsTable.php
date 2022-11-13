
<?php use DeliciousBrains\WPMigrations\Database\AbstractMigration;

class TransmissionsTable extends AbstractMigration {

    public function run() {
        global $wpdb;

        $sql = "
            CREATE TABLE " . $wpdb->prefix . "transmissions (
                id bigint(20) NOT NULL auto_increment,
                transmission_type varchar(200) NULL,
                transmission_speeds varchar(200) NULL,
                transmission_control varchar(200) NULL,
                transmission_mfr varchar(200) NULL,
                transmission_mfr_code varchar(200) NULL,
                transmission_elec_controlled varchar(200) NULL,
                PRIMARY KEY (id)
            ) {$this->get_collation()};
        ";

        dbDelta( $sql );
    }
	
    public function rollback() {
        global $wpdb;
        $wpdb->query( 'DROP TABLE ' . $wpdb->prefix . 'transmissions');
    }
}