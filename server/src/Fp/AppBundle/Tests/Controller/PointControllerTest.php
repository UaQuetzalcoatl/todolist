<?php

namespace Fp\AppBundle\Tests\Controller;

use Doctrine\ODM\MongoDB\SchemaManager;
use Fp\AppBundle\BaseWebTestCase;

/**
 * Description of PointControllerTest
 *
 * @author alex
 */
class PointControllerTest extends BaseWebTestCase
{
    protected $fixtures;

    public function setUp()
    {
        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();
        $metadatas = $dm->getMetadataFactory();
        $schemaManager = new SchemaManager($dm, $metadatas);
        $schemaManager->dropDatabases();
        $schemaManager->createDatabases();
        $this->postFixtureSetup();

        $fixtures = array(
            'Fp\AppBundle\DataFixtures\MongoDB\LoadPointData',
        );
        $this->fixtures = $this->loadFixtures($fixtures, 'default', 'doctrine_mongodb')->getReferenceRepository();
    }

    public function testGetPoints()
    {
        $client = static::createClient();

        $client->request('GET', '/points.json');
        $response = $client->getResponse();

        $this->assertJsonResponse($response);
        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(2, count($responseData));
    }

    public function testGetNotExistPoint()
    {
        $client = static::createClient();

        $client->request('GET', '/points/notexist.json');
        $response = $client->getResponse();

        $this->assertJsonResponse($response, 404);
    }

    public function testGetPoint()
    {
        $client = static::createClient();
        $pointId = $this->fixtures->getReference('point-one')->getId();
        $client->request('GET', '/points/' . $pointId . '.json');
        $response = $client->getResponse();

        $this->assertJsonResponse($response);
    }

    public function testPostPoint()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/points.json',
            ['CONTENT_TYPE' => 'application/json'],
            [],
            [],
            '{"name": "new_note", "dueDate": "2015-01-01"}'
        );

        $response = $client->getResponse();
        $this->assertJsonResponse($response, 201);
        $this->assertTrue($response->headers->has('location'));
    }

    public function testInvalidPostPoint()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/points.json',
            ['CONTENT_TYPE' => 'application/json'],
            [],
            [],
            '{"name": "", "dueDate": "2015-01-01"}'
        );

        $response = $client->getResponse();
        $this->assertJsonResponse($response, 400);
        $this->assertEquals('[{"property_path":"name","message":"This value should not be blank."}]', $response->getContent());
    }

    public function testInvalidPutPoint()
    {
        $pointId = $this->fixtures->getReference('point-one')->getId();
        $client = static::createClient();
        $client->request(
            'PUT',
            '/points/' . $pointId . '.json',
            ['CONTENT_TYPE' => 'application/json'],
            [],
            [],
            '{"name": "", "dueDate": "2015-01-01"}'
        );

        $response = $client->getResponse();
        $this->assertJsonResponse($response, 400);
        $this->assertEquals('[{"property_path":"name","message":"This value should not be blank."}]', $response->getContent());
    }

    public function testPutPoint()
    {
        $pointId = $this->fixtures->getReference('point-one')->getId();
        $client = static::createClient();
        $client->request(
            'PUT',
            '/points/' . $pointId . '.json',
            ['CONTENT_TYPE' => 'application/json'],
            [],
            [],
            '{"name": "test", "dueDate": "2015-01-01"}'
        );

        $response = $client->getResponse();
        $this->assertJsonResponse($response);
    }

    public function testDeleteNotExistPoint()
    {
        $client = static::createClient();

        $client->request('GET', '/points/notexist.json');
        $response = $client->getResponse();

        $this->assertJsonResponse($response, 404);
    }

    public function testDeletePoint()
    {
        $client = static::createClient();
        $pointId = $this->fixtures->getReference('point-two')->getId();
        $client->request('DELETE', '/points/' . $pointId . '.json');
        $response = $client->getResponse();

        $this->assertEquals(204, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('location', 'http://localhost/points'));
    }
}
