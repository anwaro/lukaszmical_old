<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace db;

/**
 * Class ActiveRecordAbstract
 * @package db
 * @author lukasz
 */
class ActiveRecordAbstract {

    /**
     * @return string
     */
    public function getTableName() {
        return '';
    }

    /**
     * @return array
     */
    public function getTableColumns(){
        return [];
    }
}
