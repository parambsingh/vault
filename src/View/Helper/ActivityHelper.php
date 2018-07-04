<?php

namespace App\View\Helper;

use Cake\View\Helper;

class ActivityHelper extends Helper {
    
    public function readyTemplate($activity) {
        return str_replace('{MemoName}', $activity->activity_on, $activity->activity_template->template);
    }
}

?>
