<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Divisi;

class DivisiSearch extends Divisi
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['kode_divisi', 'nama_divisi'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Divisi::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'kode_divisi', $this->kode_divisi])
              ->andFilterWhere(['like', 'nama_divisi', $this->nama_divisi]);

        return $dataProvider;
    }
}
