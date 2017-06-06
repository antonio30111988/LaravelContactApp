<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ContactApiTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseMigrations;
    
    public $baseUrl = 'http://localhost:8000';

    
    private $http;

    /**
     * Setup Guzzle HTTP Client
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->http =new \GuzzleHttp\Client(['base_uri' => 'localhost:8000']);
    }

    /**
     * Reset initial test poperties
     *
     * @return void
     */
    public function tearDown()
    {
        $this->http = null;
    }

    /**
     *  Get all contacts
     *
     * @return void
     */
    public function testGetAllContacts()
    {
        $response = $this->http->request('GET', 'contacts/list');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $userAgent = json_decode($response->getBody())->{"user-agent"};
        $this->assertRegexp('/Guzzle/', $userAgent);
    }

    /**
     *  Create new Contact
     *
     * @return void
     */
    public function testPostCreateContact()
    {
        $response = $this->client->post('/contacts/create', [
            'json' => [
                'address'     => 'Test Street 222',
                'name'    => 'Test Tester',
                'phone'    => '0175767645465',
                'company'    => 'Test Author',
                'email'    => 'test@gmail.com',
                'birth_date'    => '2002-11-11',
                'nick_name'    => 'Testko',
                'gender'    => 1
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertEquals("Testko", $data['nick_name']);
        $this->assertEquals("0175767645465", $data['phone']);
    }

    /**
     *  Failed to create new contact
     *
     * @return void
     */
    public function testPostCreateContactFailed()
    {
        $contactId = uniqid();

        $response = $this->client->post('/contacts/create', [
            'json' => [
                'id'    => $bookId,
                'address'     => '###Test Street 222',
                'name'    => 'Test Tester',
                'phone'    => '175767645465',
                'company'    => 'Test Author',
                'email'    => 'Test Author',
                'birth_date'    => '2002-11-11',
                'nick_name'    => 'Testko',
                'gender'    => 1
            ]
        ]);

        $this->assertEquals(422, $response->getStatusCode());
        $this->assertNotEquals("", $data['errors']);
        $response->assertSessionHasErrors(['phone']);
        $response->assertSessionHasErrors(['email']);
        $response->assertSessionHasErrors(['address']);
    }

      /**
     *  Update Contact
     *
     * @return void
     */
    public function testPostUpdateContact()
    {
        $contactId = uniqid();

        $response = $this->client->post('/contacts/update', [
            'json' => [
                'id'    => $contactId,
                'address'     => 'Test Street 222',
                'name'    => 'Test Tester',
                'phone'    => '0127588845465',
                'company'    => 'Test Author',
                'email'    => 'test@gmail.com',
                'birth_date'    => '2002-11-11',
                'nick_name'    => 'Testko',
                'gender'    => 1
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertEquals("0127588845465", $data['phone']);
        $this->assertEquals($contactId, $data['id']);
        $this->assertEquals("test@gmail.com", $data['email']);
    }

    /**
     *  Fail update of contact data
     *
     * @return void
     */
    public function testPostUpdateContactFailed()
    {
        $contactId = uniqid();

        $response = $this->client->post('/contacts/update', [
            'json' => [
                'id'    => $bookId,
                'address'     => 'Test Street 222',
                'name'    => 'Test Tester',
                'phone'    => '175767645465',
                'company'    => 'Test Author',
                'email'    => 'test-test.com',
                'birth_date'    => '20002-11-11',
                'nick_name'    => 'Testko',
                'gender'    => 1
            ]
        ]);

        $this->assertEquals(422, $response->getStatusCode());
        $this->assertNotEquals("", $data['errors']);
        $response->assertSessionHasErrors(['email']);
        $response->assertSessionHasErrors(['phone']);
    }

    /**
     *  Get App Audits of logged in user contacts
     *
     * @return void
     */
    public function testGetAppAudits()
    {
        $response = $this->http->request('GET', 'contacts/audits');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $userAgent = json_decode($response->getBody())->{"user-agent"};
        $this->assertRegexp('/Guzzle/', $userAgent);
    }

    /**
     *  Test Invalid Random Api call failed
     *
     * @return void
     */
    public function testInvalidEndpointCaseFailed()
    {
        $response = $this->http->request('PUT', 'user-agent-test', ['http_errors' => false]);

        $this->assertEquals(404, $response->getStatusCode());
    }
}
