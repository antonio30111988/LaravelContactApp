<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    /**
     * Test main app title is displayed
     *
     * @return void
     */
    public function testAppTitleDisplay()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Laravel Contacts App');
        });
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testUserLogin()
    {
        $user = factory(User::class)->create([
            'email' => 'antonio.lolic@gmail.com',
        ]);

        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'test88')
                    ->press('Login')
                    ->assertSee('You are logged in!')
                    ->assertPathIs('/contacts');
        });
    }

    /**
     * Check if login page available
     *
     * @return void
     */
    public function testLoginPageDisplay()
    {
         $this->browse(function ($browser) {
            $browser->visit('/login')
             ->assertSee('Login')
             ->assertDontSee('Contacts Manager');
         });
    }
    
    /**
     * Test Logout Feature
     *
     * @return void
     */
    public function testLogoutPass()
    {
        $this->browse(function ($browser) {
            $browser->visit('/contacts')
                ->waitForText('Contacts Manager')
                ->clickLink('dashboard-menu')
                ->clickLink('Logout')
                ->assertPathIs('/');
        });
    }
}
