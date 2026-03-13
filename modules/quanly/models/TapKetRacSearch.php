<?php

namespace app\modules\quanly\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\quanly\models\TapKetRac;

/**
 * TapKetRacSearch represents the model behind the search form about `app\modules\quanly\models\TapKetRac`.
 */
class TapKetRacSearch extends TapKetRac
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['geom', 'ten_diem', 'phuong', 'loaihinh', 'vitri', 'quymo', 'cohatang', 'su_phu', 'kha_nang', 'to_dan_pho', 'can_bo', 'khu_vuc', 'lat', 'long', 'created_at', 'updated_at', 'file_dinhkem'], 'safe'],
            [['OBJECTID', 'stt', 'tt'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TapKetRac::find()->where(['status' => 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'OBJECTID' => $this->OBJECTID,
            'stt' => $this->stt,
            'tt' => $this->tt,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'upper(geom)', mb_strtoupper($this->geom)])
            ->andFilterWhere(['like', 'upper(ten_diem)', mb_strtoupper($this->ten_diem)])
            ->andFilterWhere(['like', 'upper(phuong)', mb_strtoupper($this->phuong)])
            ->andFilterWhere(['like', 'upper(loaihinh)', mb_strtoupper($this->loaihinh)])
            ->andFilterWhere(['like', 'upper(vitri)', mb_strtoupper($this->vitri)])
            ->andFilterWhere(['like', 'upper(quymo)', mb_strtoupper($this->quymo)])
            ->andFilterWhere(['like', 'upper(cohatang)', mb_strtoupper($this->cohatang)])
            ->andFilterWhere(['like', 'upper(su_phu)', mb_strtoupper($this->su_phu)])
            ->andFilterWhere(['like', 'upper(kha_nang)', mb_strtoupper($this->kha_nang)])
            ->andFilterWhere(['like', 'upper(to_dan_pho)', mb_strtoupper($this->to_dan_pho)])
            ->andFilterWhere(['like', 'upper(can_bo)', mb_strtoupper($this->can_bo)])
            ->andFilterWhere(['like', 'upper(khu_vuc)', mb_strtoupper($this->khu_vuc)])
            ->andFilterWhere(['like', 'upper(lat)', mb_strtoupper($this->lat)])
            ->andFilterWhere(['like', 'upper(long)', mb_strtoupper($this->long)])
            ->andFilterWhere(['like', 'upper(file_dinhkem)', mb_strtoupper($this->file_dinhkem)]);

        return $dataProvider;
    }

    public function getExportColumns()
    {
        return [
            [
                'class' => 'kartik\grid\SerialColumn',
            ],
            'id',
        'geom',
        'OBJECTID',
        'stt',
        'tt',
        'ten_diem',
        'phuong',
        'loaihinh',
        'vitri',
        'quymo',
        'cohatang',
        'su_phu',
        'kha_nang',
        'to_dan_pho',
        'can_bo',
        'khu_vuc',
        'lat',
        'long',
        'status',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'file_dinhkem',        ];
    }
}
