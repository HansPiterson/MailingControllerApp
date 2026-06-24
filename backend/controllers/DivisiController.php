<?php
// ...
class DivisiController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'], // Hanya role 'admin' yang diizinkan
                    ],
                ],
            ],
            // ... (verbs)
        ];
    }
    // ...
}
