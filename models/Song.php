<?php


namespace models;

use db\ActiveRecord;

/**
 * Class Song
 * @property int $id
 * @property string $artist
 * @property string $title
 * @property string $cover
 * @property string $src
 * @property int $new
 * @property int $remove
 *
 * @package models
 * @author lukasz
 */
class Song extends ActiveRecord{


    public function getTableName() {
        return 'song';
    }
    
    public function getTableColumns() {
        return [
            'id',
            'artist',
            'title',
            'cover',
            'src',
            'show',
        ];
    }

    public function copySong(){
        $DIR = "/home/u421389560/public_html/";
        $image_path = $DIR . 'web/sounds/mp3player/';
        $image_new_path = $DIR . 'web/images/projects/mp3player/covers/';
        $mp3_path = $DIR . 'web/sounds/mp3player/';
        $mp3_newPath = $DIR . 'web/sounds/mp3/';

        $error = [];
        if(isset($this->id)){
            if (!rename($image_path . $this->cover, $image_new_path . $this->cover)) {
                array_push($error, "Fail copy cover");
            }
            if (!rename($mp3_path . $this->src . ".ogg", $mp3_newPath . $this->src . ".ogg")) {
                array_push($error, "Fail copy ogg file");
            }
            if (!rename($mp3_path . $this->src . ".mp3", $mp3_newPath . $this->src . ".mp3")) {
                array_push($error, "Fail copy mp3 file");
            }
        }
        else{
            array_push($error, "Fail find record bu id ");
        }

        return $error;
    }

    public function deleteSong(){
        $DIR = "/home/u421389560/public_html/";
        $image_path = $DIR . 'web/sounds/mp3player/';
        $image_new_path = $DIR . 'web/sounds/mp3removed/';
        $mp3_path = $DIR . 'web/sounds/mp3player/';
        $mp3_newPath = $DIR . 'web/sounds/mp3removed/';

        $error = [];
        if(isset($this->id)){
            if (!rename($image_path . $this->cover, $image_new_path . $this->cover)) {
                array_push($error, "Fail copy cover");
            }
            if (!rename($mp3_path . $this->src . ".ogg", $mp3_newPath . $this->src . ".ogg")) {
                array_push($error, "Fail copy ogg file");
            }
            if (!rename($mp3_path . $this->src . ".mp3", $mp3_newPath . $this->src . ".mp3")) {
                array_push($error, "Fail copy mp3 file");
            }
        }
        else{
            array_push($error, "Fail find record bu id ");
        }

        return $error;
    }

}

