<?php

/* @var $this PenerimaanController */
/* @var $model Penerimaan */

$this->breadcrumbs = array(
	 'Penerimaan' => array('index'),
	 'Index',
);

$this->boxHeader['small'] = 'Penerimaan';
$this->boxHeader['normal'] = 'Penerimaan';

$this->widget('BGridView', array(
	 'id' => 'penerimaan-grid',
	 'dataProvider' => $model->search(),
	 'filter' => $model,
	 'columns' => array(
		  array(
				'class' => 'BDataColumn',
				'name' => 'nomor',
				'header' => '<span class="ak">N</span>omor',
				'accesskey' => 'n',
				'autoFocus' => true,
				'type' => 'raw',
				'value' => array($this, 'renderLinkView'),
		  ),
		  array(
				'class' => 'BDataColumn',
				'name' => 'tanggal',
				'header' => 'Tangga<span class="ak">l</span>',
				'accesskey' => 'l',
				'type' => 'raw',
				'value' => array($this, 'renderLinkUbah')
		  ),
		  array(
				'name' => 'namaProfil',
				'value' => '$data->profil->nama'
		  ),
		  'keterangan',
		  array(
				'name' => 'kas_bank_id',
				'value' => '$data->kasBank->nama',
				'filter' => $filterKasBank
		  ),
		  array(
				'name' => 'jenis_transaksi_id',
				'value' => '$data->jenisTransaksi->nama',
				'filter' => $filterJenisTr
		  ),
		  array(
				'name' => 'kategori_id',
				'value' => '$data->kategori->nama',
				'filter' => $filterKategori
		  ),
		  'referensi',
		  'tanggal_referensi',
		  array(
				'name' => 'status',
				'value' => '$data->namaStatus',
				'filter' => $filterStatus
		  ),
        array(
            'header' => 'Total',
            'value' => '$data->getTotal()',
            'headerHtmlOptions' => array('class' => 'rata-kanan'),
            'htmlOptions' => array('class' => 'rata-kanan')
        ),
		  array(
				'class' => 'BButtonColumn',
		  ),
	 ),
));

$this->menu = array(
	 array('itemOptions' => array('class' => 'divider'), 'label' => ''),
	 array('itemOptions' => array('class' => 'has-form hide-for-small-only'), 'label' => '',
		  'items' => array(
				array('label' => '<i class="fa fa-plus"></i> <span class="ak">T</span>ambah', 'url' => $this->createUrl('tambah'), 'linkOptions' => array(
						  'class' => 'button',
						  'accesskey' => 't'
					 )),
		  ),
		  'submenuOptions' => array('class' => 'button-group')
	 ),
	 array('itemOptions' => array('class' => 'has-form show-for-small-only'), 'label' => '',
		  'items' => array(
				array('label' => '<i class="fa fa-plus"></i>', 'url' => $this->createUrl('tambah'), 'linkOptions' => array(
						  'class' => 'button',
					 )),
		  ),
		  'submenuOptions' => array('class' => 'button-group')
	 )
);