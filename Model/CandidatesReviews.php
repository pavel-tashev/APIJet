<?php 

namespace Model;

use Helper\Traits;

class CandidatesReviews
{  
    use Traits\Db;
    use Traits\ErrorResponse;
    
    public function getById($reviewId)
    {
        return $this->execQuery('
            SELECT `id`, `candidate_id`, `author`, `description` 
            FROM `candidates_reviews`
            WHERE `id` = ?
            LIMIT 1
        ',[$reviewId])->fetch();
    }
}