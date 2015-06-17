<?php 

namespace Controller;

use Helper\Arr;
use Model\Jobs as JobsModel;

class Jobs extends \APIJet\BaseController
{
    use \Helper\Traits\ControllerResultLimits;
    
    public function post_list()
    {
        $jobData = Arr::extract($this->getInputData(), ['position_id', 'description'], '');
        
        $jobsModel = new JobsModel();
        $jobId = $jobsModel->add($jobData);
        
        if ($jobsModel->hasError()) {
            return $jobsModel->setErrorInfo($this);
        }
        
        $this->setResponseCode(201);
        
        return [
            'job_id' => $jobId, 
        ];
    }
    
    public function get_list($jobId)
    {
        $jobsModel = new JobsModel();
        $this->setResponseLimitsToModel($jobsModel);
        
        $jobDetail = $jobsModel->getById($jobId);
        
        if (empty($jobDetail)) {
            $this->setResponseCode(404);
            return;
        }
        
        return $jobDetail;
    }
  
    
    public function put_list($jobId)
    {
        $jobsModel = new JobsModel();
        $newJobData = Arr::extract($this->getInputData(), ['position_id', 'description'], '');
      
        $jobsModel->updateById($jobId, $newJobData);
        
        if ($jobsModel->hasError()) {
            return $jobsModel->setErrorInfo($this);
        } 
        
        $this->setResponseCode(204);
    }
    
    public function delete_list($jobId)
    {
        $jobsModel = new JobsModel();
        
        if (!$jobsModel->deleteById($jobId)){
            $this->setResponseCode(404);   
            return;
        }
        
        $this->setResponseCode(204);
    }
}