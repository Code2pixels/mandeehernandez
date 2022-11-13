
<?php use DeliciousBrains\WPMigrations\Database\AbstractMigration;

class AddIndexes extends AbstractMigration {

    public function run() {
        global $wpdb;

        $sql = "
            CREATE INDEX idx_part_fitements_part_id ON " . $wpdb->prefix . "part_fitments (part_id);
            CREATE INDEX idx_part_fitements_unique_vehicle_id ON " . $wpdb->prefix . "part_fitments (unique_vehicle_id);
            CREATE INDEX idx_part_fitements_algolia_object_id ON " . $wpdb->prefix . "part_fitments (algolia_object_id);
            CREATE INDEX idx_unique_vehicles_base_vehicle_id ON " . $wpdb->prefix . "unique_vehicles (base_vehicle_id);
            CREATE INDEX idx_unique_vehicles_body_type_id ON " . $wpdb->prefix . "unique_vehicles (body_type_id);
            CREATE INDEX idx_unique_vehicles_engine_id ON " . $wpdb->prefix . "unique_vehicles (engine_id);
            CREATE INDEX idx_unique_vehicles_steering_id ON " . $wpdb->prefix . "unique_vehicles (steering_id);
            CREATE INDEX idx_unique_vehicles_transmission_id ON " . $wpdb->prefix . "unique_vehicles (transmission_id);
            CREATE INDEX idx_unique_vehicles_submodel_id ON " . $wpdb->prefix . "unique_vehicles (submodel_id);
            CREATE INDEX idx_engines_make_id ON " . $wpdb->prefix . "engines (make_id);
            CREATE INDEX idx_base_vehicles_model_id ON " . $wpdb->prefix . "base_vehicles (model_id);
            CREATE INDEX idx_ap_vehicle_submodels_model_id ON " . $wpdb->prefix . "ap_vehicle_submodels (model_id);
            CREATE INDEX idx_ap_vehicle_models_make_id ON " . $wpdb->prefix . "ap_vehicle_models (make_id);
        ";

        dbDelta( $sql );
    }
	
    public function rollback() {
        global $wpdb;
        $wpdb->query("
            DROP INDEX idx_part_fitements_part_id ON " . $wpdb->prefix . "part_fitments;
            DROP INDEX idx_part_fitements_unique_vehicle_id ON " . $wpdb->prefix . "part_fitments;
            DROP INDEX idx_part_fitements_algolia_object_id ON " . $wpdb->prefix . "part_fitments;
            DROP INDEX idx_unique_vehicles_base_vehicle_id ON " . $wpdb->prefix . "unique_vehicles;
            DROP INDEX idx_unique_vehicles_body_type_id ON " . $wpdb->prefix . "unique_vehicles;
            DROP INDEX idx_unique_vehicles_engine_id ON " . $wpdb->prefix . "unique_vehicles;
            DROP INDEX idx_unique_vehicles_steering_id ON " . $wpdb->prefix . "unique_vehicles;
            DROP INDEX idx_unique_vehicles_transmission_id ON " . $wpdb->prefix . "unique_vehicles;
            DROP INDEX idx_unique_vehicles_submodel_id ON " . $wpdb->prefix . "unique_vehicles;
            DROP INDEX idx_engines_make_id ON " . $wpdb->prefix . "engines;
            DROP INDEX idx_base_vehicles_model_id ON " . $wpdb->prefix . "base_vehicles;
            DROP INDEX idx_ap_vehicle_submodels_model_id ON " . $wpdb->prefix . "ap_vehicle_submodels;
            DROP INDEX idx_ap_vehicle_models_make_id ON " . $wpdb->prefix . "ap_vehicle_models;
        ");
    }
}