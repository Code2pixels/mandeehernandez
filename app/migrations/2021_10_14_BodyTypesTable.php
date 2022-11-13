
<?php use DeliciousBrains\WPMigrations\Database\AbstractMigration;

class BodyTypesTable extends AbstractMigration {

    public function run() {
        global $wpdb;

        $sql = "
            CREATE TABLE " . $wpdb->prefix . "body_types (
                id bigint(20) NOT NULL auto_increment,
                body_type_name varchar(200) NULL,
                PRIMARY KEY (id)
            ) {$this->get_collation()};
        ";

        dbDelta( $sql );
    }
	
    public function rollback() {
        global $wpdb;
        $wpdb->query( 'DROP TABLE ' . $wpdb->prefix . 'body_types');
    }
}