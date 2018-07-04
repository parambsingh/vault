<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ActivityTemplatesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ActivityTemplatesTable Test Case
 */
class ActivityTemplatesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ActivityTemplatesTable
     */
    public $ActivityTemplates;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.activity_templates'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ActivityTemplates') ? [] : ['className' => ActivityTemplatesTable::class];
        $this->ActivityTemplates = TableRegistry::getTableLocator()->get('ActivityTemplates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ActivityTemplates);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
