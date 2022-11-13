
<?php

use DeliciousBrains\WPMigrations\Database\AbstractMigration;
use autoplusdatasync\includes\models\AutoplusQueueLogModel;

class AddAutoplusQueueLogTable extends AbstractMigration {

    public function run() {
        global $wpdb;

        $sql = "CREATE TABLE " . $wpdb->prefix . AutoplusQueueLogModel::AUTOPLUS_QUEUE_LOG_TABLE . " (
            " . AutoplusQueueLogModel::ID_COLUMN . " bigint(20) NOT NULL UNIQUE auto_increment,
            " . AutoplusQueueLogModel::AUTOPLUS_INVENTORY_ID_COLUMN . " bigint(20) NOT NULL,
            " . AutoplusqueueLogModel::AUTOPLUS_PART_NUMBER_COLUMN . " varchar(255) NOT NULL,
            " . AutoplusqueueLogModel::ITEM_RESPONSE_COLUMN . " longtext NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) {$this->get_collation()};
        ";

        dbDelta($sql);
    }
	
    public function rollback() {
        global $wpdb;
        $wpdb->query("DROP TABLE " . $wpdb->prefix . AutoplusQueueLogModel::AUTOPLUS_QUEUE_LOG_TABLE);
    }
}
