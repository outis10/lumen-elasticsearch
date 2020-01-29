<?php

namespace Nord\Lumen\Elasticsearch\Tests;

use Elasticsearch\Client;
use Nord\Lumen\Elasticsearch\ElasticsearchService;
use Nord\Lumen\Elasticsearch\IndexNamePrefixer;
use Nord\Lumen\Elasticsearch\Search\Search;

/**
 * Class ServiceTest
 * @package Nord\Lumen\Elasticsearch\Tests
 */
class ServiceTest extends TestCase
{

    /**
     * @var ElasticsearchService
     */
    protected $service;

    /**
     * @var Client|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $client;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $this->client = $this->getMockBuilder(Client::class)
                             ->disableOriginalConstructor()
                             ->getMock();

        $this->service = new ElasticsearchService($this->client);
    }

    /**
     * Tests the search method.
     */
    public function testMethodSearch()
    {
        $input = [
            'index' => 'i',
            'type'  => 'd',
            'body'  => ['query' => ['match_all' => []]],
        ];

        $output = [
            'took' => 1,
            'hits' => [
                'total' => 0,
                'hits'  => [],
            ],
        ];

        $this->client->expects($this->any())
                     ->method('search')
                     ->with($input)
                     ->will($this->returnValue($output));

        $this->assertEquals($output, $this->service->search($input));
    }

    /**
     * Tests the index method.
     */
    public function testMethodIndex()
    {
        $input = [
            'index' => 'my_index',
            'type'  => 'my_type',
            'id'    => 'my_id',
            'body'  => ['field' => 'value'],
        ];

        $output = [
            '_index'   => 'my_index',
            '_type'    => 'my_type',
            '_id'      => 'my_id',
            '_version' => 1,
            'created'  => 1,
        ];

        $this->client->expects($this->any())
                     ->method('index')
                     ->with($input)
                     ->will($this->returnValue($output));

        $this->assertEquals($output, $this->service->index($input));
    }

    /**
     * Tests the reindex method.
     */
    public function testMethodReindex()
    {
        $input = [
            'source' => [
                'index' => 'my_src_index',
            ],
            'dest'   => [
                'index' => 'my_dest_index',
            ],
        ];

        $output = [
            'took'                   => 3104,
            'timed_out'              => false,
            'total'                  => 270,
            'updated'                => 0,
            'created'                => 270,
            'batches'                => 1,
            'version_conflicts'      => 0,
            'noops'                  => 0,
            'retries'                => 0,
            'throttled_millis'       => 0,
            'requests_per_second'    => 'unlimited',
            'throttled_until_millis' => 0,
            'failures'               => [],
        ];

        $this->client->expects($this->any())
                     ->method('reindex')
                     ->with($input)
                     ->will($this->returnValue($output));

        $this->assertEquals($output, $this->service->reindex($input));
    }

    public function testMethodUpdateByQuery()
    {
        $input = [];

        $output = [
            "took"                   => 5164,
            "timed_out"              => false,
            "total"                  => 270,
            "updated"                => 270,
            "batches"                => 1,
            "version_conflicts"      => 0,
            "noops"                  => 0,
            "retries"                => 0,
            "throttled_millis"       => 0,
            "requests_per_second"    => "unlimited",
            "throttled_until_millis" => 0,
            "failures"               => [],
        ];

        $this->client->expects($this->any())
                     ->method('updateByQuery')
                     ->with($input)
                     ->will($this->returnValue($output));

        $this->assertEquals($output, $this->service->updateByQuery($input));
    }

    /**
     * Tests the bulk method.
     */
    public function testMethodBulk()
    {
        $input = [];

        $output = [];

        $this->client->expects($this->any())
                     ->method('bulk')
                     ->with($input)
                     ->will($this->returnValue($output));

        $this->assertEquals($output, $this->service->bulk($input));
    }

    /**
     * Tests the delete method.
     */
    public function testMethodDelete()
    {
        $input = [
            'index' => 'my_index',
            'type'  => 'my_type',
            'id'    => 'my_id',
        ];

        $output = [
            'found'    => 1,
            '_index'   => 'my_index',
            '_type'    => 'my_type',
            '_id'      => 'my_id',
            '_version' => 2,
        ];

        $this->client->expects($this->any())
                     ->method('delete')
                     ->with($input)
                     ->will($this->returnValue($output));

        $this->assertEquals($output, $this->service->delete($input));
    }

    /**
     * Tests the delete by query method.
     */
    public function testMethodDeleteByQuery()
    {
        $input = [
            'index' => 'my_index',
            'type'  => 'my_type',
            'id'    => 'my_id',
        ];

        $output = [
            'found'    => 1,
            '_index'   => 'my_index',
            '_type'    => 'my_type',
            '_id'      => 'my_id',
            '_version' => 2,
        ];

        $this->client->expects($this->any())
                     ->method('deleteByQuery')
                     ->with($input)
                     ->will($this->returnValue($output));

        $this->assertEquals($output, $this->service->deleteByQuery($input));
    }

    /**
     * Tests the create method.
     */
    public function testMethodCreate()
    {
        $input = [
            'index' => 'my_index',
            'body'  => [
                'settings' => [
                    'number_of_shards'   => 2,
                    'number_of_replicas' => 0,
                ],
            ],
        ];

        $output = [
            'acknowledged' => 1,
        ];

        $this->client->expects($this->any())
                     ->method('create')
                     ->with($input)
                     ->will($this->returnValue($output));

        $this->assertEquals($output, $this->service->create($input));
    }

    /**
     * Tests the exists method.
     */
    public function tesMethodExists()
    {
        $input = [];

        $output = [];

        $this->client->expects($this->any())
                     ->method('exists')
                     ->with($input)
                     ->will($this->returnValue($output));

        
       // var_dump($this->service)
        $this->assertEquals($output, $this->service->exists($input));
    }

    /**
     * Tests the indices method.
     */
    public function tesMethodIndices()
    {
        $output = [];

        $this->client->expects($this->any())
                     ->method('indices')
                     ->will($this->returnValue($output));

        $this->assertEquals($output, $this->service->indices());
    }

    public function testNoPrefixDefined(): void
    {
        $this->assertEquals('foo', $this->service->getPrefixedIndexName('foo'));
        $this->assertEquals(['index' => 'foo'], $this->service->getPrefixedIndexParameters(['index' => 'foo']));
    }

    public function testPrefixDefined(): void
    {
        $this->service = new ElasticsearchService($this->client, 'dev');

        // Test with single idnex
        $this->assertEquals('dev_foo', $this->service->getPrefixedIndexName('foo'));
        $this->assertEquals(['index' => 'dev_foo'], $this->service->getPrefixedIndexParameters(['index' => 'foo']));

        // Test with multiple indices
        $this->assertEquals('dev_foo,dev_bar', $this->service->getPrefixedIndexName('foo,bar'));
        $this->assertEquals(['index' => 'dev_foo,dev_bar'],
            $this->service->getPrefixedIndexParameters(['index' => 'foo,bar']));

        // Test that execute() doesn't double-prefix index names
        /** @var Client|\PHPUnit_Framework_MockObject_MockObject $mockClient */
        $mockClient = $this->getMockBuilder(Client::class)
                           ->disableOriginalConstructor()
                           ->setMethods(['search'])
                           ->getMock();

        $mockClient->expects($this->once())
                   ->method('search')
                   ->with($this->callback(static function (array $params) {
                       return $params['index'] === 'dev_foo';
                   }));

        $this->service = new ElasticsearchService($mockClient, 'dev');
        $this->service->execute((new Search())->setIndex('foo'));
    }
}
