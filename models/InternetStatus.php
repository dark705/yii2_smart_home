<?php


namespace app\models;


class InternetStatus
{
    private $checkIP;

    public function __construct($ip = '8.8.8.8')
    {
        $this->checkIP = $ip;
    }

    public function check()
    {
        exec("ping $this->checkIP -c 1 -w 2", $noneed, $res);
        if ($res == 0)
            return true;
        else
            return false;
    }

    private function ipToMac($ip)
    {
        exec("sudo nmap -sP -q $ip", $out, $code);
        foreach ($out as $str) {
            if (preg_match('/([a-fA-F0-9]{2}[:|\-]?){6}/', $str, $matches)) {
                return $matches[0];
            }
        }
        return false;
    }

    private function checkThroughGwMAC($mac)
    {
        exec("sudo nping -c 1 --icmp --dest-mac $mac $this->checkIP", $out, $code);
        foreach ($out as $str) {
            if (preg_match('/Echo reply/', $str)) {
                return true;
            }
        }
        return false;
    }

    public function checkThroughGwIP($ip)
    {
        $mac = $this->ipToMac($ip);
        if ($mac) {
            return $this->checkThroughGwMAC($mac);
        } else {
            return false;
        }
    }
}
