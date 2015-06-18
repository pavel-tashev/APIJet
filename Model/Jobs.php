<?php 

namespace Model;

use Helper\Traits;
use Model;

class Jobs
{  
    use Traits\Db;
    use Traits\ErrorResponse;
    use Traits\ModelResultLimits;
   
    const NOT_VALID_POSITION_ID = 1000;
    const JOB_ID_DOES_NOT_EXIST = 1001;
    
    protected static $errorList = [
        self::NOT_VALID_POSITION_ID => "Not valid position_id",
        self::JOB_ID_DOES_NOT_EXIST => "Job id doesn't exist",
    ];
 
    public function add(array $newJob)
    {
        if (!Model\JobsPositions::isValidPossitionsId($newJob['position_id'])) {
            $this->setError(self::NOT_VALID_POSITION_ID);
            return;
        }
        
        $query = $this->execQuery('
            INSERT INTO `jobs` 
            SET 
                `position_id` = ?, 
                `description` = ?
        ', [
            $newJob['position_id'], 
            $newJob['description']
        ]);
        
        return self::getLastInsertId();
    }
    
    public function deleteById($id)
    {
        $query = $this->execQuery('
            UPDATE `jobs` 
            SET `state` = "DELETED" 
            WHERE `id` = ? && `state` = "ACTIVE" 
            LIMIT 1
        ', [$id]);
        
        return (bool) $query->rowCount();
    }
    
    private static function isExistetJobById($jobId)
    {
        return (bool) self::execQuery('
            SELECT COUNT(`id`) AS `count`
            FROM `jobs`
            WHERE `id` = ? && `state` = "ACTIVE"
        ', [$jobId])->fetchColumn();
    }
    
    public function updateById($jobId, $newJobData)
    {
        if (!Model\JobsPositions::isValidPossitionsId($newJobData['position_id'])) {
            $this->setError(self::NOT_VALID_POSITION_ID);
            return;
        }
        
        if (!self::isExistetJobById($jobId)) {
            $this->setError(self::JOB_ID_DOES_NOT_EXIST);
            return ;
        }
        
        $this->execQuery('
            UPDATE `jobs`
            SET
                `position_id` = ?,
                `description` = ?
            WHERE `id` = ? && `state` = "ACTIVE" 
            LIMIT 1
        ', [
            $newJobData['position_id'],
            $newJobData['description'],
            $jobId
        ]);
    }
    
    public function getById($jobId) 
    {
        $response = $this->execQuery('
            SELECT `jobs`.`id` , `position_id`, `jobs_positions`.`name` as `position_name`, `description`
            FROM `jobs`
            JOIN `jobs_positions` ON `jobs`.`position_id` = `jobs_positions`.`id`
            WHERE `jobs`.`id` = ? && `jobs`.`state` = "ACTIVE" 
            LIMIT 1
        ',[$jobId])->fetch();

        if ($response === false) {
            return [];
        }
        
        return $response;
    }
    
    private static function getTotal()
    {
        return (int) self::execQuery('
            SELECT COUNT(`id`) AS `count`
            FROM `jobs`
            WHERE `jobs`.`state` = "ACTIVE"
        ',[])->fetchColumn();
            
     
    }
    public function getList()
    {
        $total = self::getTotal();
        
        if ($total <= 0) {
            return [];
        }
        
        $jobsList = $this->execQuery('
            SELECT `jobs`.`id` , `position_id`, `jobs_positions`.`name` as `position_name`, `description`
            FROM `jobs`
            JOIN `jobs_positions` ON `jobs`.`position_id` = `jobs_positions`.`id`
            WHERE `jobs`.`state` = "ACTIVE"
        '.$this->getQueryLimitByReusltLimit())->fetchAll();
        
        if ($jobsList === false) {
            $jobsList = [];
        }
        
        return ['data' => $jobsList, 'total' => $total];
    }
}