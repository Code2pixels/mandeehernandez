
<?php use DeliciousBrains\WPMigrations\Database\AbstractMigration;

class EnginesTable extends AbstractMigration {

    public function run() {
        global $wpdb;

        $sql = "
            CREATE TABLE " . $wpdb->prefix . "engines (
                id bigint(20) NOT NULL auto_increment,
                make_id bigint(40) NOT NULL,
                liter varchar(200) NULL,
                cc varchar(200) NULL,
                cid varchar(200) NULL,
                cylinders varchar(200) NULL,
                block_type varchar(200) NULL,
                PRIMARY KEY (id)
            ) {$this->get_collation()};
        ";

        dbDelta( $sql );
    }
	
    public function rollback() {
        global $wpdb;
        $wpdb->query( 'DROP TABLE ' . $wpdb->prefix . 'engines');
    }
}