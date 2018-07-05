<?php

use Migrations\AbstractSeed;

/**
 * Hashtags Seed
 */
class ActivityTemplatesSeed extends AbstractSeed {
    
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run() {
        $data = [
            [
                'activity_type' => 'Added Celebrium',
                'template' => '<b>{MemoName}</b> Celebrium added successfully at {time}',
                'color' => '#bbeaa1',
            ],
            [
                'activity_type' => 'Added Memo',
                'template' => '<b>{MemoName}</b> Memo added successfully at {time}',
                'color' => '#bbeaa1'
            ],
            [
                'activity_type' => 'Added Celebrium Failed',
                'template' => 'You tried to add the <b>{MemoName}</b> Celebrium at {time}, but failed',
                'color' => '#eaa1a1'
            ],
            [
                'activity_type' => 'Added Memo Failed',
                'template' => 'You tried to add the <b>{MemoName}</b> Memo at {time}, but failed',
                'color' => '#ffffff'
            ],
            [
                'activity_type' => 'Added Celebrium Already Exists',
                'template' => '<b>{MemoName}</b> Celebrium has already been added',
                'color' => '#ffffff'
            ],
            [
                'activity_type' => 'Added Memo Already Exists',
                'template' => '<b>{MemoName}</b> Memo has already been added',
                'color' => '#ffffff'
            ],
            [
                'activity_type' => 'Memo Backed up',
                'template' => '<b>{MemoName}</b> Memo has already been backed up at {time}',
                'color' => '#ffffff'
            ],
            [
                'activity_type' => 'Memo Exported',
                'template' => '<b>{MemoName}</b> Memo has already been exported at {time}',
                'color' => '#3366CE'
            ]
        
        ];
        
        $table = $this->table('activity_templates');
        
        $table->insert($data)->save();
    }
    
}
