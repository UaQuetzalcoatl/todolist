<?php

namespace Fp\AppBundle;

use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Description of BaseWebTestCase
 *
 * @author alex
 */
class BaseWebTestCase extends WebTestCase
{
    protected function assertJsonResponse($response, $status = 200)
    {
        $this->assertEquals(
            $status, $response->getStatusCode(),
            $response->getContent()
        );
        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );
    }
}
