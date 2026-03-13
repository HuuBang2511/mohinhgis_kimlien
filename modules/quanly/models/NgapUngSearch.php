<?php

namespace app\modules\quanly\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\quanly\models\NgapUng;

/**
 * NgapUngSearch represents the model behind the search form about `app\modules\quanly\models\NgapUng`.
 */
class NgapUngSearch extends NgapUng
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['geom', 'vi_tri', 'tinh_trang', 'danh_gia', 'to_dan_pho', 'can_bo', 'khu_vuc', 'lat', 'long', 'created_at', 'updated_at', 'file_dinhkem'], 'safe'],
            [['OBJECTID', 'stt', 'stt_1'], 'number'],
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
        $query = NgapUng::find()->where(['status' => 1]);

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
            'stt_1' => $this->stt_1,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'upper(geom)', mb_strtoupper($this->geom)])
            ->andFilterWhere(['like', 'upper(vi_tri)', mb_strtoupper($this->vi_tri)])
            ->andFilterWhere(['like', 'upper(tinh_trang)', mb_strtoupper($this->tinh_trang)])
            ->andFilterWhere(['like', 'upper(danh_gia)', mb_strtoupper($this->danh_gia)])
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
        'stt_1',
        'vi_tri',
        'tinh_trang',
        'danh_gia',
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
