<?php
// ... (namespace & use)
class SuratEkspedisiController extends Controller
{
    // ... (behaviors)

    // ... (actionIndex, actionView)

    public function actionCreate()
    {
        $model = new SuratEkspedisi();
        $model->created_by = Yii::$app->user->id;
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Surat '{$model->nomor_surat}' berhasil dibuat.");
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->updated_by = Yii::$app->user->id;
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Surat '{$model->nomor_surat}' berhasil diperbarui.");
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $nomorSurat = $model->nomor_surat;
        $model->delete();
        Yii::$app->session->setFlash('success', "Surat '{$nomorSurat}' telah dihapus.");
        return $this->redirect(['index']);
    }

    // ... (review, lihatBukti, findModel)
}
