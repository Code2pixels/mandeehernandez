
<?php use DeliciousBrains\WPMigrations\Database\AbstractMigration;

class BaseVehiclesTable extends AbstractMigration {

    public function run() {
        global $wpdb;

        $sql = "
            CREATE TABLE " . $wpdb->prefix . "base_vehicles (
                id bigint(20) NOT NULL auto_increment,
                model_id bigint(20) NOT NULL,
                make_id bigint(20) NOT NULL,
                submodel_id bigint(20) NOT NULL,
                year smallint(20) NULL,
                PRIMARY KEY (id)
            ) {$this->get_collation()};
        ";

        dbDelta( $sql );
    }
	
    public function rollback() {
        global $wpdb;
        $wpdb->query( 'DROP TABLE ' . $wpdb->prefix . 'base_vehicles');
    }
}