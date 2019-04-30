<?php


namespace app\models;


class Gateway
{
    public function getIP()
    {
        exec("ip route list", $res_arr);
        foreach ($res_arr as $res) {
            if (preg_match('/default/', $res)) {
                break;
            }
        }
        if (isset($res) and preg_match('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $res, $ip)) {
            return $ip[0];
        } else
            return false;
    }

    public function setIP($ip)
    {
        if ($ip === $this->getIP()) {
            return $ip;
        }

        exec("sudo ip route replace default via $ip metric 10");

        if ($ip === $this->getIP()) {
            return $ip;
        } else {
            return false;
        }
    }
}
