<?php 

namespace Controller;

use Helper\Arr;
use Model\Jobs as JobsModel;

class Jobs extends \APIJet\BaseController
{
    use \Helper\Traits\ControllerResultLimits;
    
    public function post_index()
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
    
    public function get_index($jobId)
    {
        $jobsModel = new JobsModel();
        $jobDetail = $jobsModel->getById($jobId);
        
        if (empty($jobDetail)) {
            $this->setResponseCode(404);
            return;
        }
        
        return $jobDetail;
    }
 
    public function get_list()
    {
        $jobsModel = new JobsModel();
        $this->setResponseLimitsToModel($jobsModel);
    
        $jobList = $jobsModel->getList();
    
        if (empty($jobList)) {
            $this->setResponseCode(404);
            return;
        }
    
        return $jobList;
    }

    public function put_index($jobId)
    {
        $jobsModel = new JobsModel();
        $newJobData = Arr::extract($this->getInputData(), ['position_id', 'description'], '');
      
        $jobsModel->updateById($jobId, $newJobData);
        
        if ($jobsModel->hasError()) {
            return $jobsModel->setErrorInfo($this);
        } 
        
        $this->setResponseCode(204);
    }
    
    public function delete_index($jobId)
    {
        $jobsModel = new JobsModel();
        
        if (!$jobsModel->deleteById($jobId)){
            $this->setResponseCode(404);   
            return;
        }
        
        $this->setResponseCode(204);
    }
}