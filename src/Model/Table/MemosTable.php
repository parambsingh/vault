<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Memos Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Memo get($primaryKey, $options = [])
 * @method \App\Model\Entity\Memo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Memo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Memo|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Memo|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Memo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Memo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Memo findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MemosTable extends Table {
    
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);
        
        $this->setTable('memos');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
        
        $this->addBehavior('Timestamp');
        
        /*$this->addBehavior('Josegonzalez/Upload.Upload', [
            'file' => [
                'nameCallback' => function ($data, $settings) {
                    $parts = pathinfo($data['name']);
                    return strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $parts['filename']) . '-' . uniqid() . '.' . $parts['extension']);
                },
                'restoreValueOnFailure' => false,
                'transformer' =>  function ($table, $entity, $data, $field, $settings) {
                    $extension = pathinfo($data['name'], PATHINFO_EXTENSION);
                
                    // Store the thumbnail in a temporary file
                    $tmp = tempnam(sys_get_temp_dir(), 'upload') . '.' . $extension;
                    
                    // Use the Imagine library to DO THE THING
                    $size = new \Imagine\Image\Box(200, 200);
                    $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
                    $imagine = new \Imagine\Gd\Imagine();
                
                    // Save that modified file to our temp file
                    $imagine->open($data['tmp_name'])
                        ->thumbnail($size, $mode)
                        ->save($tmp);
                
                    // Now return the original *and* the thumbnail
                    return [
                        $data['tmp_name'] => $data['name'],
                        $tmp => 'thumbnail-' . $data['name'],
                    ];
                },
            ]
        ]);*/
        
        
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
    }
    
    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');
        
        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');
        
        $validator
            ->scalar('celebrium_json')
            ->requirePresence('celebrium_json', 'create')
            ->notEmpty('celebrium_json');
        
        $validator
            ->scalar('meta_json')
            ->requirePresence('meta_json', 'create')
            ->notEmpty('meta_json');
        
        return $validator;
    }
    
    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        
        return $rules;
    }
}
