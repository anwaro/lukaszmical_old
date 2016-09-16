<?php

class Curl_Model extends Model {
    
    function index() {
    
    }
    
    function downloadMp3(){
        if($this->is_post('url')){
            
            $post = [
                'username' => 'user1',
                'password' => 'passuser1',
                'gender'   => 1,
            ];

            $ch = curl_init('http://www.youtube-mp3.org/pl');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

            $response = curl_exec($ch);
            curl_close($ch);

            var_dump($response);
        }
    }
            
    function getCover($name){
                // create curl resource 
        $ch = curl_init(); 

        // set url 
        $options = "%20cover";
        $options = "&imgsz=medium";
        $options .= "&rsz=8";
        
        curl_setopt($ch, CURLOPT_URL, 
                'https://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=' . $name . $options); 

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output =json_decode( curl_exec($ch), true); 
        
        $data = $output["responseData"]["results"];
        
        $out = [];
        
        foreach ($data as $image) {
            $record = [];
            $record["width"] = $image["width"];
            $record["height"] = $image["height"];
            $record["url"] = $image["url"];
            array_push($out, $record);
        }
        
        print json_encode($out);

        
        // close curl resource to free up system resources 
        curl_close($ch); 
    }
}
