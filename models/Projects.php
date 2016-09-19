<?php

namespace models;

use db\ActiveRecord;
use Lii;

/**
 * Class Projects
 * @package models
 * @property int $id
 * @property string $url
 * @property string  $name
 * @property string  $description
 * @property string  $photo
 * @property string  $css
 * @property string  $js
 * @property int  $mark
 * @property int  $mark_count
 * @property string  $date
 * @property string  $last_update
 * @property int  $display
 * @property string  $template
 */
class Projects extends ActiveRecord {

    public function getTableName() {
        return 'projects';
    }    
    
    public function getTableColumns() {
        return [
            "id",
            "url",
            "name",
            "description",
            "photo",
            "css",
            "js",
            "mark",
            "mark_count",
            "date",
            "last_update",
            "display",
            "template",
        ];
    }

    public function getAll() {        
        return $this->db()
                ->from($this->getTableName())
                ->where('display', '=', 1)
                ->orderBy('mark', 'DESC')
                ->all();        
    }


    public function getBestProjects() {
        $result = $this->db()
            ->from($this->getTableName())
            ->where('display', '=', 1)
            ->orderBy('mark', 'DESC')
            ->limit(6)            
            ->all();
        return $result;
    }
    
    public function savePhoto() {
        $number = Lii::$app->request->post("number") * 5;
        $data = json_decode(Lii::$app->request->post("data"), true);
        
        $arr = [0,0,0,0,0,0];
        while($number>0){
           $number--;
           $arr = $this->arr($arr);
           
        }
        $name = $data["name"];
        $photos = $data["photo"];
        $str = str_split("abcdefghijklmnopqrstuvwxyz");
        
        foreach ($photos as  $photo) {
            $photoName = $str[$arr[0]] . $str[$arr[1]] . $str[$arr[2]] . $str[$arr[3]] . $str[$arr[4]] . $str[$arr[5]];
            $this->_save($name, $photoName,  $photo);
            $arr = $this->arr($arr);
        }        
    }
    
    private function arr($arr){
        for($i=5; $i>=0 ; $i--){
            if($arr[$i] == 25){
                $arr[$i] =0;
                $arr[$i-1]++;
            }
        }
        
        $arr[5]++;
        return $arr;
    }

    public function _save($name,  $str, $photo){
        $path = getcwd()."/web/video/photo/".$name;
        if(!file_exists($path)){
            mkdir($path, 0777, true);
        }
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $photo));
        
        $photoName = $path . "/" . $str . ".png";
        //echo str_($photoName);
        
        file_put_contents($photoName, $data);
    }
    
    public function getVideo() {
        $name = Lii::$app->request->post("name");
        $path = getcwd()."/web/video/photo/".$name;
        $photos = scandir ($path);
        /*foreach($photos as $key => $photo){
            if(strlen($photo)>4){
                //rename($path . "/" . $photo , $path . "/photo" . $key . ".png");
            }
        }*/
        
        var_dump($photos);
        //exec("ffmpeg -r 10 -b 1800 -i photo%05d.jpg test1800.mp4");
    }
    
    function prettyNum($num){
        while(strlen($num)<5){
            $num = "0" . $num;
        }
        return $num;
    }
    
    public function getWord() {
        $list = "alfabet|komputer|zeszyt|pies|kot|haczyk|słownik|długopis|książka";
        $list .= "heheszki|telefon|piłka|protfel|moneta|soczek|dłośnik|lampka";
        $array = explode( "|",$list);
        shuffle($array);
        return strtoupper ($array[0]);
    }
    
    public function getSong($id, $elem) {
        $this->db()->select('*')
                ->from('song');
        
        if($id<0){
            $id=  abs($id+1);
            $this->db()->orderBy('id', 'DESC');
        }
        $query = $this->db()->all();
        
        $arrayId = $id % count($query);
        $record = $query[$arrayId];
        $record["audio"] = $elem;
        return json_encode($record);
    }
}
