<?php
// ... (namespace & use)
class UserController extends Controller
{
    // ... (behaviors)

    // ... (actionIndex, actionView)

    public function actionCreate()
    {
        $model = new User();
        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->setPassword($model->password_hash);
            $model->generateAuthKey();
            if ($model->save()) {
                Yii::$app->session->setFlash('success', "User '{$model->username}' berhasil dibuat.");
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldPassword = $model->password_hash;
        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->password_hash = empty($model->password_hash) ? $oldPassword : Yii::$app->security->generatePasswordHash($model->password_hash);
            if ($model->save()) {
                Yii::$app->session->setFlash('success', "User '{$model->username}' berhasil diperbarui.");
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $username = $model->username;
        $model->delete();
        Yii::$app->session->setFlash('success', "User '{$username}' telah dihapus.");
        return $this->redirect(['index']);
    }

    // ... (findModel)
}
