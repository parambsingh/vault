<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Activity Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $activity_type
 * @property string $activity_on
 * @property string $activity_comment
 * @property string $activity_status
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\User $user
 */
class Activity extends Entity
{

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
        'user_id' => true,
        'activity_type' => true,
        'activity_on' => true,
        'activity_comment' => true,
        'activity_status' => true,
        'color' => true,
        'created' => true,
        'user' => true
    ];
}
