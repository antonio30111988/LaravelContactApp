<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterTest extends DuskTestCase
{
    /**
     * TESTING USER REGISTRATION
     *
     * @return void
     */
    public function testUserSignUp()
    {
        $this->browse(function ($browser) {
            $browser->visit('/register')
                    ->type('name', 'Antonio')
                    ->type('email', 'antonio.lollic88@test.com')
                    ->type('password', 'test88')
                    ->type('password_confirmation', 'test88')
                    ->press('Sign Up')
                    ->assertPathIs('/contacts');
        });
    }

    /**
     * Check if register page available
     *
     * @return void
     */
    public function testRegisterPageDisplay()
    {
        $this->browse(function ($browser) {
            $browser->visit('/register')
                    ->assertDontSee('Contacts Manager');
        });
    }
}
