<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ActivityTemplates Model
 *
 * @method \App\Model\Entity\ActivityTemplate get($primaryKey, $options = [])
 * @method \App\Model\Entity\ActivityTemplate newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ActivityTemplate[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ActivityTemplate|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ActivityTemplate|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ActivityTemplate patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ActivityTemplate[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ActivityTemplate findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ActivityTemplatesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('activity_templates');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('activity_type')
            ->maxLength('activity_type', 255)
            ->requirePresence('activity_type', 'create')
            ->notEmpty('activity_type');

        $validator
            ->scalar('template')
            ->maxLength('template', 255)
            ->requirePresence('template', 'create')
            ->notEmpty('template');

        return $validator;
    }
}
