<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SuratEkspedisi;

class SuratEkspedisiSearch extends SuratEkspedisi
{
    public function rules()
    {
        return [
            [['id', 'divisi_pengirim_id', 'divisi_tujuan_id'], 'integer'],
            [['nomor_surat', 'perihal', 'tanggal_surat', 'status'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = SuratEkspedisi::find()->with(['divisiPengirim', 'divisiTujuan']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'divisi_pengirim_id' => $this->divisi_pengirim_id,
            'divisi_tujuan_id' => $this->divisi_tujuan_id,
            'tanggal_surat' => $this->tanggal_surat,
        ]);

        $query->andFilterWhere(['like', 'nomor_surat', $this->nomor_surat])
              ->andFilterWhere(['like', 'perihal', $this->perihal])
              ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
