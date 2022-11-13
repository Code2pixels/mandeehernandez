
<?php use DeliciousBrains\WPMigrations\Database\AbstractMigration;

class SteeringTable extends AbstractMigration {

    public function run() {
        global $wpdb;

        $sql = "
            CREATE TABLE " . $wpdb->prefix . "steering (
                id bigint(20) NOT NULL auto_increment,
                steering_type varchar(200) NULL,
                steering_system varchar(200) NULL,
                PRIMARY KEY (id)
            ) {$this->get_collation()};
        ";

        dbDelta( $sql );
    }
	
    public function rollback() {
        global $wpdb;
        $wpdb->query( 'DROP TABLE ' . $wpdb->prefix . 'steering');
    }
}