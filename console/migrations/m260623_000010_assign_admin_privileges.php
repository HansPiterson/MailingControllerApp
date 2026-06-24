<?php
use yii\db\Migration;
use common\models\User;

class m260623_000010_assign_admin_privileges extends Migration
{
    public function up()
    {
        $auth = Yii::$app->authManager;
        $user = User::findOne(['username' => 'admin']);
        
        if ($user) {
            $adminRole = $auth->getRole('admin');
            if ($adminRole) {
                // Berikan peran admin secara resmi di tabel auth_assignment
                $auth->assign($adminRole, $user->id);
            }
        }
    }

    public function down()
    {
        $auth = Yii::$app->authManager;
        $user = User::findOne(['username' => 'admin']);
        if ($user) {
            $adminRole = $auth->getRole('admin');
            $auth->revoke($adminRole, $user->id);
        }
    }
}
