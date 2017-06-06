<?php
namespace Tests;

use Tests\TestCase;

/**
 * Controller Test Case
 *
 * Provides some convenience methods for testing Laravel Controllers.
 *
 * @author Joseph Wynn <joseph@wildlyinaccurate.com>
 */
abstract class ControllerTestCase extends TestCase
{
    /**
     * The Laravel session must be re-loaded before each test, otherwise
     * the session state is retained across multiple tests.
     */
    public function setUp()
    {
        Session::load();
    }
    /**
     * Call a controller method.
     *
     * This is basically an alias for Laravel's Controller::call() with the
     * option to specify a request method.
     *
     * @param string $destination
     * @param array $parameters
     * @param string $method
     * @param bool $ajax
     * @return \Laravel\Response
     */
    public function call($destination, $parameters = array(), $method = 'GET', $ajax = false)
    {
        Request::foundation()->setMethod($method);
        if ($ajax) {
            // Set an X-Request-With to the header request so as
            // to mock an Ajax request. This makes Request::ajax() method
            // return true
            Request::foundation()->headers->set('X-Requested-With', 'XMLHttpRequest');
        }
        return Controller::call($destination, $parameters);
    }
    /**
     * Alias for call()
     *
     * @param string $destination
     * @param array $parameters
     * @param string $method
     * @param bool $ajax
     * @return \Laravel\Response
     */
    public function get($destination, $parameters = array(), $ajax = false)
    {
        return $this->call($destination, $parameters, 'GET', $ajax);
    }
    /**
     * Make a POST request to a controller method
     *
     * @param string $destination
     * @param array $post_data
     * @param array $parameters
     * @param bool $ajax
     * @return \Laravel\Response
     */
    public function post($destination, $post_data, $parameters = array(), $ajax = false)
    {
        $this->cleanRequest();
        Request::foundation()->request->add($post_data);
        return $this->call($destination, $parameters, 'POST', $ajax);
    }
    /**
     * Make a PUT request to a controller method
     *
     * @param string $destination
     * @param array $parameters
     * @param bool $ajax
     * @return \Laravel\Response
     */
    public function put($destination, $put_data, $parameters = array(), $ajax = false)
    {
        $this->cleanRequest();
        Request::foundation()->request->add($put_data);
        return $this->call($destination, $parameters, 'PUT', $ajax);
    }
    /**
     * Make a DELETE request to a controller method
     *
     * @param string $destination
     * @param array $parameters
     * @param bool $ajax
     * @return \Laravel\Response
     */
    public function delete($destination, $parameters = array(), $ajax = false)
    {
        return $this->call($destination, $parameters, 'DELETE', $ajax);
    }
    /**
     * Clean data posted on previous request so that the
     * next request wont be merged
     *
     */
    public function cleanRequest()
    {
        $request = Request::foundation()->request;
        $keys = $request->keys();
        foreach ($keys as $key) {
            $request->remove($key);
        }
    }
}
