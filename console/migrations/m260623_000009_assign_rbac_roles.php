<?php
use yii\db\Migration;

class m260623_000009_assign_rbac_roles extends Migration
{
    public function up()
    {
        $auth = Yii::$app->authManager;

        // ... (kode definisi role dan permission)
    }

    public function down()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }
}
