<?php

namespace Tests\Feature\Controllers\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginControllerTest extends TestCase
{
    //use DatabaseMigrations;
    public $baseUrl = 'http://localhost:8000';

    /**
     * Check if login page available
     *
     * @return void
     */
    public function testLoginPageDisplay()
    {
        $this->visit('/login')
             ->see('Login')
             ->dontSee('Contacts Manager');
    }
    
    /**
     * Test Login Feature
     *
     * @return void
     */
    public function testLoginPass()
    {
         $this->visit('/login')
             //->type('Test Name', 'name')
             ->type('test@gmail.com', 'email')
             ->type('Lolaso888', 'password')
             ->check('remember')
             ->press('Login')
             ->seePageIs('/contacts');
    }

    /**
     * Test Login Feature Fail
     *
     * @return void
     */
    public function testLoginFail()
    {
         $this->visit('/login')
             //->type('Test Name', 'name')
             ->type('test@gsgmail.com', 'email')
             ->type('Lolaso888', 'password')
             ->check('remember')
             ->press('Login')
             ->seePageIs('/login');
    }
    
    /**
     * Check if logged in user saved in database
     *
     * @return void
     */
    public function testLoggedInUserNotInDb()
    {
        if ($this->testLoginPass()) {
            $this->dontSeeInDatabase('users', ['name' => 'Test Name','email' => 'test@name.com']);
        } else {
            return true;
        }
    }
    
    
    /**
     * Test Logout Feature
     *
     * @return void
     */
    public function testLogoutPass()
    {
            $this->visit('/contacts')
                ->click('dashboard-menu')
                ->click('Logout')
                ->seePageIs('/login');
    }
}
