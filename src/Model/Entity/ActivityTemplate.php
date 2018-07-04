<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ActivityTemplate Entity
 *
 * @property int $id
 * @property string $activity_type
 * @property string $template
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class ActivityTemplate extends Entity {
    
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'activity_type' => true,
        'template' => true,
        'color' => true,
        'created' => true,
        'modified' => true
    ];
}
