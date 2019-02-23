<?php
/**
 * Created by PhpStorm.
 * User: lukasz
 * Date: 08.10.16
 * Time: 01:01
 * Project: lukaszmical.pl
 */

namespace models;

use vendor\db\ActiveRecord;

/**
 * Class Rate
 * @property int $id
 * @property int $project_id
 * @property int $rate
 * @property int $analise_id
 * @package models
 * @author lukasz
 */
class Rate extends ActiveRecord{


    public function getTableName() {
        return 'rate';
    }
    
    public function getTableColumns() {
        return [
            'id',
            'project_id',
            'rate',
            'analise_id',
        ];
    }

}

