<?php 

namespace Controller;

use Model\Candidates as CandidatesModel;
use Model\CandidatesReviews as CandidatesReviewsModel;

class Candidates extends \APIJet\BaseController
{
    use \Helper\Traits\ControllerResultLimits;
//     /candidates/list  - това е лист с кандидатите
//     /candidates/review/{id} това е review на кандидат
//     /candidates/search/{id} вземане на кандидат по ID
    
    public function get_list()
    {
        $candidatesModel = new CandidatesModel();
        $this->setResponseLimitsToModel($candidatesModel);
        
        $candidatesList = $candidatesModel->getList();
        
        if (empty($candidatesList)) {
            $this->setResponseCode(404);
            return;
        }
        
        return $candidatesList;
    }
    
    public function get_review($reviewId)
    {
        $candidatesModel = new CandidatesReviewsModel();
        $candidateDetail = $candidatesModel->getById($reviewId);
        
        if (empty($candidateDetail)) {
            $this->setResponseCode(404);
            return;
        }
        
        return $candidateDetail;
    }
    
    public function get_search($cadidateId)
    {
        $candidatesModel = new CandidatesModel();
        $candidateDetail = $candidatesModel->getById($cadidateId);
        
        if (empty($candidateDetail)) {
            $this->setResponseCode(404);
            return;
        }
        
        return $candidateDetail;
    }
   
}