<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MemosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MemosTable Test Case
 */
class MemosTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MemosTable
     */
    public $Memos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.memos',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Memos') ? [] : ['className' => MemosTable::class];
        $this->Memos = TableRegistry::getTableLocator()->get('Memos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Memos);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
