<?php
namespace api\controllers;

use Yii;
use yii\rest\Controller;
use common\models\LoginForm;
use common\models\RefreshToken;
use common\models\User;
use Firebase\JWT\JWT;
use yii\web\UnauthorizedHttpException;

class AuthController extends Controller
{
    // ... (verbs, login action)

    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        return [
            'login' => ['POST'],
            'refresh' => ['POST'],
        ];
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->getBodyParams(), '') && $model->login()) {
            $user = Yii::$app->user->identity;
            $tokens = $this->generateJwtAndRefreshToken($user);

            return [
                'status' => 'success',
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'role' => $user->role,
                    'divisi_id' => $user->divisi_id,
                ],
                'access_token' => $tokens['access_token'],
                'refresh_token' => $tokens['refresh_token'],
            ];
        } else {
            Yii::$app->response->statusCode = 422;
            return ['status' => 'error', 'errors' => $model->errors];
        }
    }

    public function actionRefresh()
    {
        $refreshTokenStr = Yii::$app->request->post('refresh_token');
        $tokenModel = RefreshToken::findOne(['token' => $refreshTokenStr]);

        if (!$tokenModel || strtotime($tokenModel->expires_at) < time()) {
            throw new UnauthorizedHttpException('Refresh token tidak valid atau sudah kadaluwarsa.');
        }

        $user = User::findOne($tokenModel->user_id);
        $tokenModel->delete(); // Hapus token lama setelah dipakai

        $tokens = $this->generateJwtAndRefreshToken($user);

        return [
            'status' => 'success',
            'access_token' => $tokens['access_token'],
            'refresh_token' => $tokens['refresh_token'],
        ];
    }

    /**
     * Helper untuk generate JWT dan Refresh Token secara bersamaan.
     */
    protected function generateJwtAndRefreshToken($user)
    {
        // 1. Generate JWT
        $expire = time() + 3600; // 1 jam
        $payload = [
            'iat'  => time(),
            'exp'  => $expire,
            'sub'  => $user->id,
        ];
        $jwt = JWT::encode($payload, Yii::$app->params['jwtSecret'], 'HS256');

        // 2. Generate & Save Refresh Token
        $refreshToken = Yii::$app->getSecurity()->generateRandomString(64);
        $tokenModel = new RefreshToken();
        $tokenModel->user_id = $user->id;
        $tokenModel->token = $refreshToken;
        $tokenModel->expires_at = date('Y-m-d H:i:s', time() + (3600 * 24 * 30)); // 30 hari
        $tokenModel->save();

        return [
            'access_token' => $jwt,
            'refresh_token' => $refreshToken
        ];
    }
}
