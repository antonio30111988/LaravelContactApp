<?php

namespace Tests;

//use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
//use browser-kit-testing as in lravel 5.3 provided
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
}
