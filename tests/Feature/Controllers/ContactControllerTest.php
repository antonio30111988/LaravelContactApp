<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Http\Requests\SaveUserContacts;

class ContactControllerTest extends TestCase
{
    use WithoutMiddleware;
    
    public $baseUrl = 'http://localhost:8000';

    
    public function setUp()
    {
        parent::setUp();
        $this->rules     = (new SaveUserContacts())->rules();
        $this->validator = $this->app['validator'];
    }

    /**
     * Check if contacts homepage is accessible
     *
     * @return void
     */
    public function testContactsHomepageDisplay()
    {
        $this->visit('/contacts')
             ->see('Contacts Manager')
             ->dontSee('Github');
    }
    
    /**
     * Check if contacts audit is open on click
     *
     * @return void
     */
    public function testContactsAuditDisplayOnClick()
    {
        $this->visit('/contacts')
            ->click('View App Audit')
             ->see('Attribute')
             ->see('Old data')
             ->see('New data');
    }

     /**
     * Check if add contact from is open on click
     *
     * @return void
     */
    public function testContactFormOpenOnClick()
    {
        $this->visit('/contacts')
            ->click('Add Contact')
             ->see('Create new contact:');
    }
    
     /**
     * Check if contact search input is rendered on click
     *
     * @return void
     */
    public function testSearchInputOpenOnClick()
    {
        $this->visit('/contacts')
            ->click('Search Contacts')
             ->see('Search Contacts:');
    }
    
    /**
    * Test main route existion.
    */
    public function testHompageDisplayed()
    {
        $response=$this->call('GET', '/contacts');
        
         $this->assertEquals(200, $response->getStatusCode());
    }
    
    /**
    *  Check if exist VD contact saved succeeded
    */
    public function testSaveToVCard()
    {
        $this->visit('/contacts')
            ->click('to vCard')
            ->see('Saved');
    }

    /**
    *  Test Validation of contact form fields
    */
    public function testValidateContactFields()
    {
        $rules = [
            'name' => 'required|string|unique:contacts|max:100',
            'nick_name' => 'nullable|max:50',
            'gender' => 'nullable|max:1',
            'email' => 'required|email|unique:contacts',
            'phone' => 'required|numeric|phone_number',
            'address' => 'required|alpha_num_space',
            'company' => 'required',
            'birth_date' => 'present|date|before_or_equal:today'
        ];
        
        $data = [
            'address'     => 'Test Street',
            'name'    => 'Test Tester',
            'phone'    => '0175767645465',
            'company'    => 'Test Author',
            'email'    => 'test@tt.com',
            'birth_date'    => '2002-11-11',
            'nick_name'    => 'Testko',
            'gender'    => 1
        ];
        
        $v = $this->app['validator']->make($data, $rules);
        $this->assertTrue($v->passes());
    }

    /**
    *  Test failure of validation contact form fields
    */
    public function testValidateContactFieldsFailed()
    {
        $rules = [
            'name' => 'required|string|unique:contacts|max:100',
            'nick_name' => 'nullable|max:50',
            'gender' => 'nullable|max:1',
            'email' => 'required|email|unique:contacts',
            'phone' => 'required|numeric|phone_number',
            'address' => 'required|alpha_num_space',
            'company' => 'required',
            'birth_date' => 'present|date|before_or_equal:today'
        ];
        
        $data = [
            'address'     => 'Test Street 222',
            'name'    => 'Test Tester',
            'phone'    => '175767645465',
            'company'    => 'Test Author',
            'email'    => 'test-test.com',
            'birth_date'    => '20002-11-11',
            'nick_name'    => 'Testko',
            'gender'    => 2
        ];
        
        $v = $this->app['validator']->make($data, $rules);
        $this->assertTrue($v->fails());
    }

    /**
    *  Validate several case for form fields against rules array
    */
    public function valid_fields_cases()
    {
        $this->assertTrue($this->validateField('name', 'Ante'));
        $this->assertTrue($this->validateField('name', 'John Wick'));
        $this->assertTrue($this->validateField('name', 'Ante Hrvat'));
        $this->assertTrue($this->validateField('name', 'Ante'));
        $this->assertFalse($this->validateField('name', '98768'));
        $this->assertFalse($this->validateField('name', 'test 98768'));
        $this->assertFalse($this->validateField('name', ''));


        $this->assertTrue($this->validateField('phone', '01396876875'));
        $this->assertTrue($this->validateField('phone', '0176567565'));
        $this->assertFalse($this->validateField('phone', 'mark76576'));
        $this->assertTrue($this->validateField('phone', '01hj96876875'));
        $this->assertFalse($this->validateField('phone', 'jon1'));
        $this->assertFalse($this->validateField('phone', ''));

        $this->assertTrue($this->validateField('email', 'test@test.com'));
        $this->assertTrue($this->validateField('email', 'test@gmsil.co'));
        $this->assertTrue($this->validateField('email', 'google@net.hr'));
        $this->assertFalse($this->validateField('email', 'tester'));
        $this->assertFalse($this->validateField('email', 'te@ster'));
        $this->assertFalse($this->validateField('email', 'te.ster@ttrr'));
        $this->assertFalse($this->validateField('email', ''));


        $this->assertTrue($this->validateField('address', 'jon'));
        $this->assertFalse($this->validateField('address', 'jon1'));
        $this->assertFalse($this->validateField('address', '$%$&%/##'));
        $this->assertFalse($this->validateField('address', 'gjhgj'));
        $this->assertFalse($this->validateField('address', ''));

        $this->assertTrue($this->validateField('company', 'jon'));
        $this->assertFalse($this->validateField('company', 'jon1'));
        $this->assertFalse($this->validateField('company', ''));

        $this->assertTrue($this->validateField('birth_date', '2012-01-29'));
        $this->assertTrue($this->validateField('birth_date', '1999-05-27'));
        $this->assertTrue($this->validateField('birth_date', '2007-12-29'));
        $this->assertFalse($this->validateField('birth_date', '2019-06-11'));
        $this->assertFalse($this->validateField('birth_date', '12:23:56'));
        $this->assertFalse($this->validateField('birth_date', '01/06'));

        $this->assertTrue($this->validateField('gender', 0));
        $this->assertTrue($this->validateField('gender', 1));
        $this->assertTrue($this->validateField('gender', 2));
        $this->assertFalse($this->validateField('gender', 'female'));
        $this->assertFalse($this->validateField('gender', 'male'));
        $this->assertFalse($this->validateField('gender', 'x'));

        $this->assertTrue($this->validateField('nick_name', 'tom'));
        $this->assertFalse($this->validateField('nick_name', 96976));
    }

    protected function getFieldValidator($field, $value)
    {
       //fetching rules from UserSaveContact.php Request file and validate field value
        return $this->validator->make(
            [$field => $value],
            [$field => $this->rules[$field]]
        );
    }

    protected function validateField($field, $value)
    {
        return $this->getFieldValidator($field, $value)->passes();
    }
}
