<?php

namespace models;

use db\ActiveRecord;

class Projects extends ActiveRecord {

    public function getTableName() {
        return 'projects';
    }

    public function getAll() {
        
        $result = $this->db()
                ->select('*')
                ->from($this->getTableName())
                ->where('display', '=', 1)
                ->orderBy('mark', 'DESC')
                ->all();
        
        return $result;
        
    }
    
    public function getInfo($url) {
        $result = $this->db()
            ->select('*')
            ->from($this->getTableName())
            ->where('url', '=', $url)
            ->one();
        
        return $result;
    }

    public function getBestProjects() {
        $result = $this->db()
            ->select('*')
            ->from($this->getTableName())
            ->where('display', '=', 1)
            ->orderBy('mark', 'DESC')
            ->limit(6)            
            ->all();
        return $result;
    }
    
    public function savePhoto() {
        $numer = $this->post("number") * 5;
        $data = json_decode($this->post("data"), true);
        
        $arr = [0,0,0,0,0,0];
        while($numer>0){
           $numer--;
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
        $path = getcwd()."/public/video/photo/".$name;
        if(!file_exists($path)){
            mkdir($path, 0777, true);
        }
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $photo));
        
        $photoName = $path . "/" . $str . ".png";
        //echo str_($photoName);
        
        file_put_contents($photoName, $data);
    }
    
    public function getVideo() {
        $name = $this->post("name");
        $path = getcwd()."/public/video/photo/".$name;
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
