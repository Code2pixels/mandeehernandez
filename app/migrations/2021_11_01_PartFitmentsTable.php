
<?php use DeliciousBrains\WPMigrations\Database\AbstractMigration;

class PartFitmentsTable extends AbstractMigration {

    public function run() {
        global $wpdb;

        $sql = "
            CREATE TABLE " . $wpdb->prefix . "part_fitments (
                id bigint(20) NOT NULL auto_increment,
                part_id bigint(20) NULL,
                unique_vehicle_id bigint(20) NULL,
                algolia_object_id bigint(20) NULL,
                app_notes varchar(200) NULL,
                qty int(20) NULL,
                position_on_vehicle varchar(70) NULL,
                PRIMARY KEY (id)
            ) {$this->get_collation()};
        ";

        dbDelta( $sql );
    }
	
    public function rollback() {
        global $wpdb;
        $wpdb->query( 'DROP TABLE ' . $wpdb->prefix . 'part_fitments');
    }
}