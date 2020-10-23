<?php

declare(strict_types=1);

namespace api\controllers\common;

use filsh\yii2\oauth2server\filters\auth\CompositeAuth;
use filsh\yii2\oauth2server\filters\ErrorToExceptionFilter;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;

class ApiController extends Controller
{
    public $enableAuth;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->enableAuth = Yii::$app->params['enableAuth'];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // remove authentication filter
        $auth = $behaviors['authenticator'];

        if ($this->enableAuth) {
            $auth = ArrayHelper::merge($auth, [
                'class' => CompositeAuth::class,
                'except' => ['site/index', 'oauth2/rest/token'],
                'authMethods' => [
                    ['class' => HttpBearerAuth::class,],
//                ['class' => QueryParamAuth::class, 'tokenParam' => 'accessToken'],
                ],
            ]);
        }

        $behaviors['exceptionFilter'] = [
            'class' => ErrorToExceptionFilter::class,
        ];

        unset($behaviors['authenticator']);

        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Allow-Origin' => ['*'],
                'Access-Control-Expose-Headers' => [
                    'X-Pagination-Current-Page',
                    'X-Pagination-Page-Count',
                    'X-Pagination-Per-Page',
                    'X-Pagination-Total-Count'
                ],
            ],
        ];

        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options'];

        return $behaviors;
    }
}
