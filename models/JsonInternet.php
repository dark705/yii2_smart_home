<?php


namespace app\models;


use Yii;
use yii\base\Model;

class JsonInternet extends Model
{
    public $request;
    public $internetStatus;
    public $gateway;
    public $configGateways;

    public function rules()
    {
        return [
            ['configGateways', 'validateSetIP']
        ];
    }

    public function validateSetIP()
    {
        if ($this->request->post('setIP')) {
            foreach ($this->configGateways as $gateway) {
                if ($gateway['ip'] === $this->request->post('setIP')) {
                    return true;
                }
            }
            $this->addError('error', 'Trying to set not valid ip address: ' . $this->request->post('setIP'));
        }
    }

    public function getData()
    {
        if ($this->request->post('checkInternet')) {
            if ($this->internetStatus->check()) {
                return 'online';
            } else {
                return 'offline';
            }
        }

        if ($this->request->post('checkInternetThroughGw')) {
            if ($this->internetStatus->checkThroughGwIP(Yii::$app->request->post('checkInternetThroughGw'))) {
                return 'online';
            } else {
                return 'offline';
            }
        }

        if ($this->request->post('setIP')) {
            return $this->gateway->setIP($this->request->post('setIP'));
        }

        return false;
    }
}
