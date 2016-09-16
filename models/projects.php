<?php

class projects_Model extends Model {

    
    public function index() {
            
    }
    
    public function getInfoAll() {
        $query = $this->db()->select("SELECT * FROM projects WHERE display = 1 ORDER BY mark DESC");
        return $query;
    }
    
    public function getInfo($name) {
        $query = $this->db()->select("SELECT * FROM projects WHERE url = :name", array(":name"=>$name));
        $info = array(
            "url"=>"error/index",
            "name"=>"Nie znaleziono takiego projektu",
            "descr"=>"",
            "js"=>["404"],
            "css"=>[],
            "mark"=>'',
            "number"=>'',
            "photo"=>"",
            "date"=>'' ,
            "display"=>'',
            "template"=>''           
        );
        
        if($query){
            $info["url"]="projects/".$name;
            $info["name"]=$query[0]["name"];
            $info["descr"]=$query[0]["descr"];
            $info["mark"]=$query[0]["mark"];
            $info["number"]=$query[0]["numerMark"];
            $info["photo"]=$query[0]["photo"];
            $info["date"]=$query[0]["date"];
            $info["js"]=  explode(";", $query[0]["js"]);
            $info["css"]=  explode(";", $query[0]["css"]);
            $info["display"]= $query[0]["display"];
            $info["template"]= $query[0]["template"];
        }
        return $info;
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
            $this->save($name, $photoName,  $photo);
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

    public function save($name,  $str, $photo){
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
        $array = explode( "|",$list);
        shuffle($array);
        return strtoupper ($array[0]);
    }
    
    public function getSong($id, $elem) {
        $select = "";
        if($id<0){
            $id=  abs($id+1);
            $select = " ORDER BY id DESC";
        }
        $query = $this->db()->select("SELECT * FROM song ".$select);
        
        $arrayId = $id % count($query);
        $record = $query[$arrayId];
        $record["audio"] = $elem;
        return json_encode($record);
    }
}
