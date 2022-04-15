<?php

declare(strict_types=1);

use Phoenix\Migration\AbstractMigration;

final class Migration extends AbstractMigration
{
    protected function up(): void
    {
//        $this->execute('CREATE TABLE `first_table` (
//                `id` int(11) NOT NULL AUTO_INCREMENT,
//                `1` text(50) NULL,
//                `2` text(50) NULL,
//                `4` text(16) NULL,
//                `5` text(2000) NULL,
//                `6` text(200) NULL,
//                `7` text(300) NULL,
//                `8` text(50) NULL,
//                `9` text(50) NULL,
//                `10` text(50) NULL,
//                `11` text(50) NULL,
//                `12` text(50) NULL,
//                `13` text(50) NULL,
//                `14` text(50) NULL,
//                `15` text(50) NULL,
//                `status` varchar(45) DEFAULT "",
//                `created_at` datetime NOT NULL,
//                PRIMARY KEY (`id`)
//            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
//        );
        $this->table('doctors_form')
            ->addColumn('1', 'date', ['null' => true])
            ->addColumn('2', 'text', ['null' => true, 'length' => 50])
            ->addColumn('3', 'text', ['null' => true, 'length' => 50])
            ->addColumn('4', 'text', ['null' => true, 'length' => 16])
            ->addColumn('5', 'text', ['null' => true, 'length' => 2000])
            ->addColumn('6', 'text', ['null' => true, 'length' => 200])
            ->addColumn('7', 'text', ['null' => true, 'length' => 300])
            ->addColumn('8', 'text', ['null' => true, 'length' => 50])
            ->addColumn('9', 'text', ['null' => true, 'length' => 50])
            ->addColumn('10', 'text', ['null' => true, 'length' => 50])
            ->addColumn('11', 'text', ['null' => true, 'length' => 50])
            ->addColumn('12', 'text', ['null' => true, 'length' => 50])
            ->addColumn('13', 'text', ['null' => true, 'length' => 50])
            ->addColumn('14', 'text', ['null' => true, 'length' => 50])
            ->addColumn('15', 'text', ['null' => true, 'length' => 50])
            ->addColumn('status', 'string',['default' => '', 'length' => 50])
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->create();
    }

    protected function down(): void
    {
        $this->table('doctors_form')
            ->drop();
    }
}
