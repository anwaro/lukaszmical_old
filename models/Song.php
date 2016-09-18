<?php


namespace models;

use db\ActiveRecord;

/**
 * Class Song
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
        ];
    }

}

