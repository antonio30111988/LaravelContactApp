<?php

namespace Tests\Feature\Controllers\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginController extends TestCase
{
	use DatabaseMigrations;
	/**
     * Check if login page available
     *
     * @return void
     */
    public function testLoginPageDisplay()
    {
        $this->visit('/login')
             ->see('Login')
             ->dontSee('Contacts List');
    }
	
	/**
     * Test Login Feature
     *
     * @return void
     */
    public function testLoginPass()
    {
         $this->visit('/login')
			 ->type('Test Name', 'name')
			 ->type('test@name.com', 'email')
			 ->check('remember')
			 ->press('Login')
			 ->seePageIs('/home');
    }
	
	/**
     * Check if logged in user saved in database
     *
     * @return void
     */
    public function testLoggedInUserInDb()
    {
       if($this->testLoginPass())
	   $this->seeInDatabase('users', ['name' => 'Test Name','email' => 'test@name.com']);
		else
			return true; 
    }
	
	
	/**
     * Test Logout Feature
     *
     * @return void
     */
    public function testLogoutPass()
    {
        if($this>testLoginPass){
			$this->visit('/login')
				->click('Logout')	
				->seePageIs('/login');
		}
		else 
			return true;	
    }
}
