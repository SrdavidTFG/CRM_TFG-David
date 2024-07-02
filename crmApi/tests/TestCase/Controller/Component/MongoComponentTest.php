<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\MongoComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\MongoComponent Test Case
 */
class MongoComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\MongoComponent
     */
    public $Mongo;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Mongo = new MongoComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Mongo);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
