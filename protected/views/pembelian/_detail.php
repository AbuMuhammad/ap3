<?php
// Bisa Edit Qty jika masih draft
if ($pembelian->status == Pembelian::STATUS_DRAFT):
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/vendor/jquery.poshytip.js', CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/vendor/jquery-editable-poshytip.min.js', CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/jquery-editable.css');
    /*
     * 	Menambahkan rutin pada saat edit qty
     * 1. Update Grid Pembelian detail
     * 2. Update Total Pembelian
     */
    Yii::app()->clientScript->registerScript('editableQty', ''
            . '$( document ).ajaxComplete(function() {'
            . '$(".editable-qty").editable({'
            . '	success: function(response, newValue) {'
            . '					if (response.sukses) {'
            . '						$.fn.yiiGridView.update("pembelian-detail-grid");'
            . '						updateTotal();'
            . '					}'
            . '				}  '
            . '});'
            . '});'
            . '$(".editable-qty").editable({'
            . '	success: function(response, newValue) {'
            . '					if (response.sukses) {'
            . '						$.fn.yiiGridView.update("pembelian-detail-grid");'
            . '						updateTotal();'
            . '					}'
            . '				}  '
            . '});', CClientScript::POS_END);
endif;
?>

<div class="small-12  columns">
    <?php
    $this->widget('BGridView', array(
        'id' => 'pembelian-detail-grid',
        'dataProvider' => $pembelianDetail->search(),
        //'filter' => $pembelianDetail,
        'summaryText' => '{start}-{end} dari {count}, Total: ' . $pembelian->total,
        'columns' => array(
            array(
                'name' => 'barcode',
                'value' => '$data->barang->barcode',
            ),
            array(
                'name' => 'namaBarang',
                'value' => '$data->barang->nama',
            ),
            array(
                'name' => 'qty',
                'value' => function($data) {
                    return '<a href="#" class="editable-qty" data-type="text" data-pk="' . $data->id . '" data-url="' . Yii::app()->controller->createUrl('updateqty') . '">' .
                            $data->qty . '</a>';
                },
                'type' => 'raw',
                'headerHtmlOptions' => array('style' => 'width:75px', 'class' => 'rata-kanan'),
                'htmlOptions' => array('class' => 'rata-kanan'),
            ),
            array(
                'name' => 'harga_beli',
                'headerHtmlOptions' => array('class' => 'rata-kanan'),
                'htmlOptions' => array('class' => 'rata-kanan'),
                'value' => 'number_format($data->harga_beli, 0, ",", ".")'
            ),
            array(
                'name' => 'harga_jual',
                'headerHtmlOptions' => array('class' => 'rata-kanan'),
                'htmlOptions' => array('class' => 'rata-kanan'),
                'value' => 'number_format($data->harga_jual, 0, ",", ".")'
            ),
            array(
                'name' => 'harga_jual_rekomendasi',
                'headerHtmlOptions' => array('class' => 'rata-kanan'),
                'htmlOptions' => array('class' => 'rata-kanan'),
                'value' => function($data) {
                    if (is_null($data->harga_jual_rekomendasi)) {
                        return 'NULL';
                    }
                    else {
                        return number_format($data->harga_jual_rekomendasi, 0, ',', '.');
                    }
                }
            ),
            array(
                'name' => 'subTotal',
                'header' => 'Total',
                'value' => '$data->total',
                'headerHtmlOptions' => array('class' => 'rata-kanan'),
                'htmlOptions' => array('class' => 'rata-kanan'),
                'filter' => false
            ),
            // Jika pembelian masih draft tampilkan tombol hapus
            array(
                'class' => 'BButtonColumn',
                'template' => $pembelian->status == 0 ? '{delete}' : '',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("pembelian/hapusdetail", array("id"=>$data->primaryKey))',
                'afterDelete' => 'function(link,success,data){ if(success) updateTotal(); }',
            ),
        ),
    ));
    ?>
</div>