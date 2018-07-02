<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Memo Entity
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property string $memo_file
 * @property string $celebrium_file
 * @property string $celebrium_json
 * @property string $meta_json
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 */
class Memo extends Entity {
    
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
        'name' => true,
        'user_id' => true,
        'file' => true,
        'thumb' => true,
        'celebrium_json' => true,
        'meta_json' => true,
        'created' => true,
        'modified' => true,
        'user' => true
    ];
}
