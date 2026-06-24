<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

class UserSearch extends User
{
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'divisi_id'], 'integer'],
            [['username', 'email', 'role', 'nama_lengkap'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = User::find()->with('divisi');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'divisi_id' => $this->divisi_id,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'role', $this->role])
            ->andFilterWhere(['like', 'nama_lengkap', $this->nama_lengkap]);

        return $dataProvider;
    }
}
