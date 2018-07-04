<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class ActivityManagerComponent extends Component {
    
    public function create($activity) {
        
        $activitiesTable = TableRegistry::get('Activities');
        
        
        $activityEntity = $activitiesTable->newEntity();
        
        $activityEntity->user_id = $activity['user_id'];
        $activityEntity->activity_type = $activity['type'];
        $activityEntity->activity_on = $activity['on'];
        $activityEntity->activity_template_id = $this->getTemplateId($activity);
        $activityEntity->activity_status = $activity['status'];
        
        $activitiesTable->save($activityEntity);
        
    }
    
    
    
    public function getTemplateId($activity) {
        $activityTemplatesTable = TableRegistry::get('ActivityTemplates');
        $activityTemplate = $activityTemplatesTable->find()->where(['activity_type' => $activity['type']])->first();
        
        return $activityTemplate->id;
    }
}

?>
