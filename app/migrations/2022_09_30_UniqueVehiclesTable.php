
<?php use DeliciousBrains\WPMigrations\Database\AbstractMigration;

class UniqueVehiclesTable extends AbstractMigration {

    public function run() {
        global $wpdb;

        $sql = "
            CREATE TABLE " . $wpdb->prefix . "unique_vehicles (
                id bigint(20) NOT NULL auto_increment,
                base_vehicle_id int(20) NULL,
                drive_type_id int(20) NULL,
                body_type_id int(20) NULL,
                body_num_doors int(20) NULL,
                engine_id int(20) NULL,
                aspiration_name varchar(50) NULL,
                fuel_type_name varchar(50) NULL,
                liter varchar(10) NULL,
                brake_abs_name varchar(50) NULL,
                front_brake_type varchar(50) NULL,
                rear_brake_type varchar(50) NULL,
                front_spring_type varchar(50) NULL,
                rear_spring_type varchar(50) NULL,
                steering_id int(20) NULL,
                transmission_id int(20) NULL,
                PRIMARY KEY (id),
                UNIQUE KEY completely_unique_vehicle (
                    base_vehicle_id,
                    drive_type_id,
                    body_type_id,
                    body_num_doors,
                    engine_id,
                    brake_abs_name,
                    front_brake_type,
                    rear_brake_type,
                    front_spring_type,
                    rear_spring_type,
                    steering_id,
                    transmission_id
                )
            ) {$this->get_collation()};
        ";

        dbDelta( $sql );
    }
	
    public function rollback() {
        global $wpdb;
        $wpdb->query( 'DROP TABLE ' . $wpdb->prefix . 'unique_vehicles');
    }
}