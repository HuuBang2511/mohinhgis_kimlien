<?php

namespace app\modules\quanly\models;
use app\modules\quanly\base\QuanlyBaseModel;
use Yii;

/**
 * This is the model class for table "tap_ket_rac".
 *
 * @property int $id
 * @property string|null $geom
 * @property float|null $OBJECTID
 * @property float|null $stt
 * @property float|null $tt
 * @property string|null $ten_diem
 * @property string|null $phuong
 * @property string|null $loaihinh
 * @property string|null $vitri
 * @property string|null $quymo
 * @property string|null $cohatang
 * @property string|null $su_phu
 * @property string|null $kha_nang
 * @property string|null $to_dan_pho
 * @property string|null $can_bo
 * @property string|null $khu_vuc
 * @property string|null $lat
 * @property string|null $long
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string|null $file_dinhkem
 */
class TapKetRac extends QuanlyBaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tap_ket_rac';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['geom', 'lat', 'long', 'file_dinhkem'], 'string'],
            [['OBJECTID', 'stt', 'tt'], 'number'],
            [['status', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['ten_diem', 'phuong', 'loaihinh', 'vitri', 'quymo', 'cohatang', 'su_phu', 'kha_nang', 'to_dan_pho', 'can_bo', 'khu_vuc'], 'string', 'max' => 254],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'geom' => 'Geom',
            'OBJECTID' => 'Objectid',
            'stt' => 'Stt',
            'tt' => 'Tt',
            'ten_diem' => 'Tên điểm',
            'phuong' => 'Phuong',
            'loaihinh' => 'Loại hình',
            'vitri' => 'Vitri',
            'quymo' => 'Quy mô',
            'cohatang' => 'Có hạ tầng',
            'su_phu' => 'Sự phát sinh',
            'kha_nang' => 'Khả năng',
            'to_dan_pho' => 'To Dan Pho',
            'can_bo' => 'Cán bộ',
            'khu_vuc' => 'Khu vực',
            'lat' => 'Lat',
            'long' => 'Long',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'file_dinhkem' => 'File đính kèm',
        ];
    }
}
