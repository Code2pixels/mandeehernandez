
<?php

use DeliciousBrains\WPMigrations\Database\AbstractMigration;
use autoplusdatasync\includes\models\AutoplusQueueModel;

class AddAutoplusQueueTable extends AbstractMigration {

    public function run() {
        global $wpdb;

        $sql = "CREATE TABLE " . $wpdb->prefix . AutoplusQueueModel::AUTOPLUS_QUEUE_TABLE . " (
            " . AutoplusQueueModel::ID_COLUMN . " bigint(20) NOT NULL UNIQUE auto_increment,
            " . AutoplusQueueModel::AUTOPLUS_INVENTORY_ID_COLUMN . " bigint(20) NOT NULL,
            " . AutoplusqueueModel::AUTOPLUS_PART_NUMBER_COLUMN . " varchar(255) NOT NULL,
            " . AutoplusqueueModel::COMPRESSED_ITEM_RESPONSE_COLUMN . " BLOB NOT NULL,
            " . AutoplusqueueModel::STATUS_COLUMN . " TINYINT UNSIGNED NOT NULL,
            " . AutoplusqueueModel::SYNC_START_TIME_COLUMN . " TIMESTAMP DEFAULT NULL, 
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) {$this->get_collation()};
        ";

        dbDelta($sql);
    }
	
    public function rollback() {
        global $wpdb;
        $wpdb->query("DROP TABLE " . $wpdb->prefix . AutoplusQueueModel::AUTOPLUS_QUEUE_TABLE);
    }
}
