<?php

namespace app\modules\quanly\models;
use app\modules\quanly\base\QuanlyBaseModel;
use Yii;

/**
 * This is the model class for table "trat_tu_do_thi".
 *
 * @property int $id
 * @property string|null $geom
 * @property float|null $OBJECTID
 * @property float|null $stt
 * @property float|null $stt_1
 * @property string|null $dia_diem
 * @property string|null $thuc_trang
 * @property string|null $danh_gia
 * @property string|null $ghi_chu
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
class TratTuDoThi extends QuanlyBaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trat_tu_do_thi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['geom', 'lat', 'long', 'file_dinhkem'], 'string'],
            [['OBJECTID', 'stt', 'stt_1'], 'number'],
            [['status', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['dia_diem', 'thuc_trang', 'danh_gia', 'ghi_chu', 'to_dan_pho', 'can_bo', 'khu_vuc'], 'string', 'max' => 254],
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
            'stt_1' => 'Stt 1',
            'dia_diem' => 'Địa điểm',
            'thuc_trang' => 'Thực trạng',
            'danh_gia' => 'Đánh giá',
            'ghi_chu' => 'Ghi Chu',
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
