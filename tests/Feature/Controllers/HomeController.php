<?php

namespace Tests\Unit\controllers;

use Tests\TestCase;
use App\Http\Controllers\FileConverterController as Converter;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class HomeControllerTest extends TestCase
{
	use WithoutMiddleware;
	use DatabaseMigrations;
	
	public function testSomething()
	{
		// Stop here and mark this test as incomplete.
		$this->markTestIncomplete(
		'This test has not been implemented yet.'
		);
		
		if (!extension_loaded('mysqli')) {
			$this->markTestSkipped(
			'The MySQLi extension is not available.'
			);
		}
	}

	
	/**
     * Check if contacts homepage is accessible
     *
     * @return void
     */
    public function testContactsHomepageDisplay()
    {
        $this->visit('/home')
             ->see('Contacts list')
             ->dontSee('Login')
             ->dontSee('Sign Up');
    }
	
	/**
     * Check if contacts audit is open on click
     *
     * @return void
     */
    public function testContactsAuditDisplayOnClick()
    {
        $this->visit('/home')
			->click('View Contact Log History')	
             ->seePageIs('/contacts-audit');
    }
	
	/**
	* Test main route existion.
	*/
	public function testIndex()
	{
		$this->call('GET', '/home');
		
		$response=$this->call('POST', 'downloadCSVFile');
		
		$this->assertEquals(200, $response->status());		
	} 
	
	/**
	*  Check if exist VD conatct file 
	*/
	public function testSaveToVdCard()
	{
		$this->call('POST', 'saveToVdCard');
		
		$this->assertFileExists(public_path('contacts.json'));
				
	}
	
	/**
	* 	Filter only urls using regex
	*
	*	@param string $testCase String to be validated	
	*	@dataProvider providerTestUrlValidation
	*/
    public function testUrlValidation($testCase)
    {
        //$testCase = 'https://www.google.hr/';
		
		$converter=new Converter;
		$result = $converter->isUrlValid($testCase);
		
		$this->assertNotFalse($result);
    }
	
	/**
	 * 	Data Provider
	 */
	public function providerTestUrlValidation()
	{
		return array(
			array('https://www.trivago.hr/'),
			array('https://www.hasenbraue.de/'),
			array('https://www.google.hr/'),
			array('https://www.conipo.com/'),
			array('https://www.ostalbpa.de/')	
		);
	}
	
	/**
	* 	Test for valid phone number
	*
	*	@param string $testCase String to be validated
	*	@dataProvider providerTestHotelNameValidation
	* 	
	*/
    public function testPhoneValidation($testCase)
    {
       // $testCase = 'Hotel President Solin';
		
		$converter=new Converter;
		$result = $converter->filterNameByAsciis($testCase);
		
		$this->assertTrue($result);
    }
	
	/**
	 * 	Data Provider
	 */
	public function providerTestHotelNameValidation()
	{
		return array(
			array('Hotel Amfora'),
			array('Hotel President'),
			array('Hotel Le Meridien'),
			array('Hotel Bellevue'),
			array('Hotel Sheraton')	
		);
	}
	
	/**
	* 	Check rating is positive integer
	*
	*	@param string $testCase String to be validated	
	*	@dataProvider providerTestHotelRatingValidation
	*/
    public function testEmailValidation($testCase)
    {
        //$testCase = 5;
		
		$converter=new Converter;
		$result = $converter->filterEmail($testCase);
		
		$this->assertTrue($result);
    }
	
	/**
	 * 	Testing custom emails
	 */
	public function providerTesEmailValidation()
	{
		return array(
			array("test@test.com"),
			array("ante88@yahoo.com"),
			array("ante88@yahoo.com"),
			array("zz@zz.net"),
			array("lola@king.com")	
		);
	}

	
}