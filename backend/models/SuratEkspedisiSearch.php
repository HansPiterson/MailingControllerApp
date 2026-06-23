<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SuratEkspedisi;

/**
 * SuratEkspedisiSearch represents the model behind the search form of `common\models\SuratEkspedisi`.
 */
class SuratEkspedisiSearch extends SuratEkspedisi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'divisi_pengirim_id', 'divisi_tujuan_id'], 'integer'],
            [['uuid', 'nomor_surat', 'nama_tujuan_orang', 'tanggal_surat', 'perihal', 'nama_penerima', 'tanggal_penerimaan', 'foto_bukti', 'foto_alamat', 'foto_hash', 'status'], 'safe'],
            [['foto_latitude', 'foto_longitude'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = SuratEkspedisi::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'divisi_pengirim_id' => $this->divisi_pengirim_id,
            'divisi_tujuan_id' => $this->divisi_tujuan_id,
            'tanggal_surat' => $this->tanggal_surat,
            'tanggal_penerimaan' => $this->tanggal_penerimaan,
            'foto_latitude' => $this->foto_latitude,
            'foto_longitude' => $this->foto_longitude,
        ]);

        $query->andFilterWhere(['like', 'uuid', $this->uuid])
            ->andFilterWhere(['like', 'nomor_surat', $this->nomor_surat])
            ->andFilterWhere(['like', 'nama_tujuan_orang', $this->nama_tujuan_orang])
            ->andFilterWhere(['like', 'perihal', $this->perihal])
            ->andFilterWhere(['like', 'nama_penerima', $this->nama_penerima])
            ->andFilterWhere(['like', 'foto_bukti', $this->foto_bukti])
            ->andFilterWhere(['like', 'foto_alamat', $this->foto_alamat])
            ->andFilterWhere(['like', 'foto_hash', $this->foto_hash])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
