<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/** @var yii\web\View $this */
/** @var \common\models\LoginForm $model */

$this->title = 'Admin Panel Login';
?>
<div class="site-login">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header text-center">
                    <h3 class="fw-light my-4"><?= Html::encode(Yii::$app->name) ?></h3>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                        <?= $form->field($model, 'username', [
                            'inputTemplate' => '<div class="input-group">{input}<span class="input-group-text"><hero-icon name="user" class="w-5 h-5 text-muted"></hero-icon></span></div>',
                        ])->textInput(['autofocus' => true, 'placeholder' => 'Username']) ?>

                        <?= $form->field($model, 'password', [
                             'inputTemplate' => '<div class="input-group">{input}<span class="input-group-text"><hero-icon name="lock-closed" class="w-5 h-5 text-muted"></hero-icon></span></div>',
                        ])->passwordInput(['placeholder' => 'Password']) ?>

                        <?= $form->field($model, 'rememberMe')->checkbox() ?>

                        <div class="d-grid mt-4">
                            <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
