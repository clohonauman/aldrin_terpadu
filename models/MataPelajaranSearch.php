<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MataPelajaran;

class MataPelajaranSearch extends MataPelajaran
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['mata_pelajaran', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Method untuk mencari data berdasarkan filter
     */
    public function search($params)
    {
        $query = MataPelajaran::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10, // Menentukan jumlah data per halaman
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC, // Mengurutkan data berdasarkan ID secara descending
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Filter berdasarkan input
        $query->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['like', 'mata_pelajaran', $this->mata_pelajaran])
            ->andFilterWhere(['>=', 'created_at', $this->created_at])
            ->andFilterWhere(['>=', 'updated_at', $this->updated_at]);

        return $dataProvider;
    }
}
