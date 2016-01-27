<?php

class m160127_025621_fitur_member_poin extends CDbMigration
{
    /*
      public function up()
      {
      }

      public function down()
      {
      echo "m160127_025621_fitur_member_poin does not support migration down.\n";
      return false;
      }
     */

    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $dbEngine = 'MyISAM';
        // $dbEngine = 'InnoDB';

        $this->createTable('member_periode_poin', array(
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'nama' => 'varchar(45) NOT NULL',
            'awal' => 'tinyint(3) unsigned NOT NULL',
            'akhir' => 'tinyint(3) unsigned NOT NULL',
            'updated_at' => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP",
            'updated_by' => 'int(10) unsigned NOT NULL',
            'created_at' => "timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            'PRIMARY KEY (`id`)',
            'KEY `fk_member_periode_poin_updatedby_idx` (`updated_by`)'
                ), 'ENGINE=' . $dbEngine . '  DEFAULT CHARSET=utf8');

        /* Foreign Key Tabel member_periode_poin */
        $this->addForeignKey('fk_member_periode_poin_updatedby_idx', 'member_periode_poin', 'updated_by', 'user', 'id', 'NO ACTION', 'NO ACTION');

        /* Tambah konfigurasi untuk nilai rupiah untuk mendapatkan 1 poin */
        $this->insert('config', array('nama' => 'member.nilai_1_poin', 'nilai' => '50000', 'deskripsi' => 'Nilai rupiah untuk member mendapatkan 1 poin', 'updated_at' => '0000-00-00 00:00:00', 'updated_by' => 1, 'created_at' => '0000-00-00 00:00:00'));
    }

    public function safeDown()
    {
        
    }

}
