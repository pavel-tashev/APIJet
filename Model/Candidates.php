<?php 

namespace Model;

use Helper\Traits;

class Candidates
{  
    use Traits\Db;
    use Traits\ErrorResponse;
    use Traits\ModelResultLimits;
    
    public function getById($candidateId)
    {
        return $this->execQuery('
            SELECT 
                `candidates`.`id`,
                `candidates`.`name` AS `candidate_name`,
                `job_id`,
                `jobs`.`description` AS `job_description`,
                `position_id`,
                `jobs_positions`.`name` AS `position_name`
            FROM `candidates`
            JOIN `jobs` ON `jobs`.`id` = `candidates`.`job_id`
            JOIN `jobs_positions` ON `jobs_positions`.`id` = `jobs`.`position_id`
            WHERE  `candidates`.`id` = ? && `candidates`.`state` = "ACTIVE"
        ',[$candidateId])->fetch();
    }
    
    
    private static function getTotal()
    {
        return (int) self::execQuery('
            SELECT COUNT(`id`) AS `count`
            FROM `candidates`
            WHERE `candidates`.`state` = "ACTIVE"
        ',[])->fetchColumn();
    }
    
    public function getList()
    {
        $total = self::getTotal();
    
        if ($total <= 0) {
            return [];
        }
    
        $candidatesList = $this->execQuery('
            SELECT 
                `candidates`.`id`,
                `candidates`.`name` AS `candidate_name`,
                `job_id`,
                `position_id`
            FROM `candidates`
            JOIN `jobs` ON `jobs`.`id` = `candidates`.`job_id`
            JOIN `jobs_positions` ON `jobs_positions`.`id` = `jobs`.`position_id`
            WHERE  `candidates`.`state` = "ACTIVE"
        '.$this->getQueryLimitByReusltLimit())->fetchAll();
    
        if ($candidatesList === false) {
            $candidatesList = [];
        }
    
        return ['data' => $candidatesList, 'total' => $total];
    }
}