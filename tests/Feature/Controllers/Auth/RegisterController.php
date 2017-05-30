<?php

namespace Tests\Feature\Controllers\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterController extends TestCase
{
    use DatabaseMigrations;
	
	/**
     * Test Sign Up Feature
     *
     * @return void
     */
    public function testSignUpPass()
    {
         $this->visit('/register')
			 ->type('Test Name', 'name')
			 ->type('test@name.com', 'email')
			 ->type('password111test', 'password')
			 ->type('password111test', 'password-confirmation')
			 ->press('Sign Up')
			 ->seePageIs('/login');
    }
	
	/**
     * Check if register page available
     *
     * @return void
     */
    public function testRegisterPageDisplay()
    {
        $this->visit('/register')
             ->see('Sign Up')
             ->dontSee('Contacts List');
    }
	
	 /**
     * Check if register user saved in database
     *
     * @return void
     */
    public function testRegisteredUserInDb()
    {
       if($this->testSignUpPass())
	   $this->seeInDatabase('users', ['name' => 'Test Name','email' => 'test@name.com']);
		else
			return true;
    }
}
