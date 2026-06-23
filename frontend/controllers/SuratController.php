<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use common\models\SuratEkspedisi;
use yii\web\NotFoundHttpException;

/**
 * Surat controller
 */
class SuratController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Menampilkan daftar surat masuk dan keluar untuk divisi user.
     * @return string
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $divisi_id = $user->divisi_id;

        $suratMasukProvider = new ActiveDataProvider([
            'query' => SuratEkspedisi::find()->where(['divisi_tujuan_id' => $divisi_id]),
            'pagination' => ['pageSize' => 10],
            'sort' => ['defaultOrder' => ['tanggal_surat' => SORT_DESC]],
        ]);

        $suratKeluarProvider = new ActiveDataProvider([
            'query' => SuratEkspedisi::find()->where(['divisi_pengirim_id' => $divisi_id]),
            'pagination' => ['pageSize' => 10],
            'sort' => ['defaultOrder' => ['tanggal_surat' => SORT_DESC]],
        ]);

        return $this->render('index', [
            'suratMasukProvider' => $suratMasukProvider,
            'suratKeluarProvider' => $suratKeluarProvider,
        ]);
    }

    /**
     * Menampilkan detail satu record surat.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException jika model tidak ditemukan atau user tidak berhak
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Mencari model SuratEkspedisi berdasarkan ID dan hak akses user.
     * @param int $id
     * @return SuratEkspedisi the loaded model
     * @throws NotFoundHttpException if the model cannot be found or access is denied
     */
    protected function findModel($id)
    {
        $user = Yii::$app->user->identity;
        $divisi_id = $user->divisi_id;

        $model = SuratEkspedisi::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException('Halaman yang Anda cari tidak ditemukan.');
        }

        // --- Pemeriksaan Keamanan ---
        // User hanya boleh melihat surat jika divisinya adalah pengirim ATAU tujuan
        if ($model->divisi_pengirim_id != $divisi_id && $model->divisi_tujuan_id != $divisi_id) {
            throw new NotFoundHttpException('Anda tidak memiliki hak akses untuk melihat surat ini.');
        }

        return $model;
    }
}
