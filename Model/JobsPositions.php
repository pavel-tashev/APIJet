<?php 

namespace Model;

use Helper\Traits;

class JobsPositions
{  
    use Traits\Db;
    
    public static function isValidPossitionsId($id) {
        
        $query = self::execQuery('
            SELECT COUNT(`id`) AS `isValid` 
            FROM `jobs_positions` 
            WHERE `id` = ? && `state` = "ACTIVE"
        ', [$id]);
        
        return (bool) $query->fetchColumn();
    }
}