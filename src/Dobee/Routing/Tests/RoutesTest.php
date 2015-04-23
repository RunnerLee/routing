<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/4/23
 * Time: 下午12:20
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace Dobee\Routing\Tests;

class RoutesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Dobee\Routing\Router
     */
    private $router;

    public function setUp()
    {
        if (!class_exists('\Routes')) {
            include __DIR__ . '/../Routes.php';
        }

        $this->router = \Routes::getRouter();
    }

    public function testSetRoutes()
    {
        /**
         * get
         */
        \Routes::get(['/welcome', 'name' => 'welcome'], function () {
            return 'welcome';
        });

        $route = $this->router->matchRoute('/welcome', $this->router->getRoute('welcome'));

        $callback = $route->getCallback();

        $this->assertEquals('welcome', $callback());

        /**
         * post
         */
        \Routes::post(['/post', 'name' => 'post'], function () {
            return 'post';
        });

        $route = $this->router->matchRoute('/post', $this->router->getRoute('post'));

        $this->assertEquals(array('POST'), $route->getMethods());
    }

    public function testDynamic()
    {
        \Routes::any(['/one/{name}', 'name' => 'one'], function ($name) {
            return $name;
        })->setDefaults(array('name' => 'janHuang'));

        $route = $this->router->getRoute('one');
        $route = $this->router->matchRoute('/one/jan', $route);

        $this->assertEquals(array('name' => 'janHuang'), $route->getDefaults());
        $this->assertEquals(array('name'), $route->getArguments());
        $this->assertEquals(array('name' => 'jan'), $route->getParameters());
    }
}