<?php
namespace api\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use common\models\LoginForm;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        return [
            'login' => ['POST'],
        ];
    }

    /**
     * Handles the login process for the API.
     *
     * @return array
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->getBodyParams(), '') && $model->login()) {
            $user = Yii::$app->user->identity;
            
            $tokenId    = base64_encode(random_bytes(32));
            $issuedAt   = time();
            $notBefore  = $issuedAt;
            $expire     = $notBefore + 3600; // Expire in 1 hour
            $serverName = Yii::$app->request->hostInfo;

            $data = [
                'iat'  => $issuedAt,         // Issued at: time when the token was generated
                'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
                'iss'  => $serverName,       // Issuer
                'nbf'  => $notBefore,        // Not before
                'exp'  => $expire,           // Expire
                'sub'  => $user->getId(),    // Subject (user id)
            ];

            $token = JWT::encode(
                $data,
                Yii::$app->params['jwtSecret'],
                'HS256'
            );

            return [
                'status' => 'success',
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                ],
                'token' => $token,
            ];

        } else {
            Yii::$app->response->statusCode = 422;
            return [
                'status' => 'error',
                'errors' => $model->errors,
            ];
        }
    }
}
