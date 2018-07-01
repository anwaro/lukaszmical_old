<?php
/**
 * Created by PhpStorm.
 * User: lukasz
 * Date: 02.10.16
 * Time: 23:18
 */

namespace models;

use db\ActiveRecord;
use helper\Browser;


/**
 * Class Analise
 * @property integer $id
 * @property string $refer
 * @property string $url
 * @property string $via
 * @property string $system
 * @property string $browser
 * @property string $visit_date
 * @property string $ip
 * @property string $device
 * @property string $browser_version
 * @property int $robot
 * @package models
 */
class Analise extends ActiveRecord
{

    private $browserDetect;

    public function __construct()
    {
        $this->browserDetect =  new Browser();
        parent::__construct();
    }

    public function getTableName()
    {
        return 'analise';
    }

    public function getTableColumns()
    {
        return [
            'id',
            'refer',
            'url',
            'via',
            'system',
            'browser',
            'visit_date',
            'ip',
            'device',
            'browser_version',
            "robot",
        ];
    }


    public function register(){

        $this->refer = $this->getRefer();
        $this->url = $this->getUrl();
        $this->via = $this->getVia();
        $this->system = $this->getSystem();
        $this->browser = $this->getBrowser();
        $this->visit_date = date("Y-m-d H-i-s");
        $this->ip = $this->getIp();
        $this->device = $this->getDevice();
        $this->browser_version = $this->getBrowserVersion();
        $this->robot = $this->isRobot();
        $this->save();

        return $this->id;
    }


    public function getRefer()
    {
        return $this->_server('HTTP_REFERER');
    }

    public function getUrl()
    {
        return $this->_server('REQUEST_URI');
    }

    public function getVia()
    {
        return $this->_server('HTTP_VIA');
    }

    public function getSystem()
    {
        return $this->browserDetect->getPlatform();
    }

    public function getBrowser()
    {
        return $this->browserDetect->getBrowser();
    }

    public function getIp()
    {
        if (!empty($this->_server('HTTP_CLIENT_IP'))) {
            $ip = $this->_server('HTTP_CLIENT_IP');
        } elseif (!empty($this->_server('HTTP_X_FORWARDED_FOR'))) {
            $ip = $this->_server('HTTP_X_FORWARDED_FOR');
        } else {
            $ip = $this->_server('REMOTE_ADDR');
        }
        return $ip;
    }

    public function getDevice(){
        if($this->browserDetect->isMobile()){
            return "MOBILE";
        }
        elseif($this->browserDetect->isTablet()){
            return "TABLET";
        }
        else{
            return "DESKTOP";
        }

    }

    private function _server($name)
    {
        return isset($_SERVER[$name]) ? $_SERVER[$name] : '';

    }

    public function getBrowserVersion()
    {
        return $this->browserDetect->getVersion();
    }

    public function isRobot()
    {
        return $this->browserDetect->isRobot() ? 1 : 0;
    }
}