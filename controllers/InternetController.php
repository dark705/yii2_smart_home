<?php

namespace app\controllers;

use app\models\Gateway;
use app\models\InternetStatus;
use app\models\JsonInternet;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class InternetController extends Controller
{
    public function actionIndex()
    {
        $internetStatus = Yii::createObject(InternetStatus::class);
        $gateway = Yii::createObject(Gateway::class);
        $configGateways = Yii::$app->params['gateway'];

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $jsonInternet = Yii::createObject([
                'class' => JsonInternet::class,
                'request' => Yii::$app->request,
                'internetStatus' => $internetStatus,
                'gateway' => $gateway,
                'configGateways' => $configGateways
            ]);

            if($jsonInternet->validate()){
                return $jsonInternet->data;
            } else {
                return $jsonInternet->errors;
            }
        }

        if (Yii::$app->request->isGet) {
            $currentGatewayIp = $gateway->getIP();

            return $this->render('index', compact(['configGateways', 'currentGatewayIp']));
        }
    }
}
