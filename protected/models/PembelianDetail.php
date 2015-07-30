<?php

/**
 * This is the model class for table "pembelian_detail".
 *
 * The followings are the available columns in table 'pembelian_detail':
 * @property string $id
 * @property string $pembelian_id
 * @property string $barang_id
 * @property string $qty
 * @property string $harga_beli
 * @property string $harga_jual
 * @property string $harga_jual_rekomendasi
 * @property string $tanggal_kadaluwarsa
 * @property string $updated_at
 * @property string $updated_by
 * @property string $created_at
 *
 * The followings are the available model relations:
 * @property Barang $barang
 * @property Pembelian $pembelian
 * @property User $updatedBy
 * @property ReturPembelianDetail[] $returPembelianDetails
 */
class PembelianDetail extends CActiveRecord {

	public $barcode;
	public $namaBarang;
	public $subTotal;
	public $pembelianStatus;

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'pembelian_detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			 array('pembelian_id, barang_id, harga_beli, harga_jual', 'required'),
			 array('pembelian_id, barang_id, qty, updated_by', 'length', 'max' => 10),
			 array('harga_beli, harga_jual, harga_jual_rekomendasi', 'length', 'max' => 18),
			 array('tanggal_kadaluwarsa, created_at, updated_at, updated_by', 'safe'),
			 // The following rule is used by search().
			 // @todo Please remove those attributes that should not be searched.
			 array('id, pembelian_id, barang_id, qty, harga_beli, harga_jual, harga_jual_rekomendasi, tanggal_kadaluwarsa, updated_at, updated_by, created_at, barcode, namaBarang, subTotal, pembelianStatus', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			 'barang' => array(self::BELONGS_TO, 'Barang', 'barang_id'),
			 'pembelian' => array(self::BELONGS_TO, 'Pembelian', 'pembelian_id'),
			 'updatedBy' => array(self::BELONGS_TO, 'User', 'updated_by'),
			 'returPembelianDetails' => array(self::HAS_MANY, 'ReturPembelianDetail', 'pembelian_detail_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			 'id' => 'ID',
			 'pembelian_id' => 'Pembelian',
			 'barang_id' => 'Barang',
			 'qty' => 'Qty',
			 'harga_beli' => 'Harga Beli',
			 'harga_jual' => 'Harga Jual',
			 'harga_jual_rekomendasi' => 'RRP',
			 'tanggal_kadaluwarsa' => 'Tanggal Kadaluwarsa',
			 'updated_at' => 'Updated At',
			 'updated_by' => 'Updated By',
			 'created_at' => 'Created At',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search($defaultOrder = NULL) {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria();

		$criteria->compare('id', $this->id, true);
		$criteria->compare('pembelian_id', $this->pembelian_id, true);
		$criteria->compare('barang_id', $this->barang_id, true);
		$criteria->compare('qty', $this->qty, true);
		$criteria->compare('harga_beli', $this->harga_beli, true);
		$criteria->compare('harga_jual', $this->harga_jual, true);
		$criteria->compare('harga_jual_rekomendasi', $this->harga_jual_rekomendasi, true);
		$criteria->compare('tanggal_kadaluwarsa', $this->tanggal_kadaluwarsa, true);
		$criteria->compare('updated_at', $this->updated_at, true);
		$criteria->compare('updated_by', $this->updated_by, true);
		$criteria->compare('created_at', $this->created_at, true);

		$criteria->with = array('barang', 'pembelian');
		$criteria->compare('barang.barcode', $this->barcode, true);
		$criteria->compare('barang.nama', $this->namaBarang, true);
		$criteria->compare('pembelian.status', $this->pembelianStatus);

		$orderBy = is_null($defaultOrder) ? 't.id desc' : $defaultOrder;

		$sort = array(
			 'defaultOrder' => $orderBy,
			 'attributes' => array(
				  'barcode' => array(
						'asc' => 'barang.barcode',
						'desc' => 'barang.barcode desc'
				  ),
				  'namaBarang' => array(
						'asc' => 'barang.nama',
						'desc' => 'barang.nama desc'
				  ),
				  '*',
			 )
		);

		$pagination = array(
			 'pageSize' => 50
		);

		return new CActiveDataProvider($this, array(
			 'criteria' => $criteria,
			 'sort' => $sort,
			 'pagination' => $pagination
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PembelianDetail the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function beforeSave() {

		if ($this->isNewRecord) {
			$this->created_at = date('Y-m-d H:i:s');
		}
		$this->updated_at = null; // Trigger current timestamp
		$this->updated_by = Yii::app()->user->id;
		return parent::beforeSave();
	}

//	public function normalkanHarga($harga) {
//		return str_replace('.', '', $harga);
//	}

	public function getTotal() {
//		return number_format($this->qty * $this->normalkanHarga($this->harga_beli), 0, ',', '.');
		return number_format($this->qty * $this->harga_beli, 0, ',', '.');
	}

	/*
	  public function afterFind() {
	  //		if ($this->scenario != 'raw') {
	  //			$this->harga_beli = number_format($this->harga_beli, 0, ',', '.');
	  //			$this->harga_jual = number_format($this->harga_jual, 0, ',', '.');
	  //			$this->harga_jual_rekomendasi = number_format($this->harga_jual_rekomendasi, 0, ',', '.');
	  //		}
	  return parent::afterFind();
	  }

	  public function beforeValidate() {
	  //		$this->harga_beli = $this->normalkanHarga(ceil($this->harga_beli));
	  //		$this->harga_jual = $this->normalkanHarga(ceil($this->harga_jual));
	  //		$this->harga_jual_rekomendasi = $this->normalkanHarga($this->harga_jual_rekomendasi);
	  return parent::beforeValidate();
	  }
	 */
}