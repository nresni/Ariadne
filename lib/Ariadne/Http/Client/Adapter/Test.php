<?php
namespace Ariadne\Http\Client\Adapter;

use Zend\Http\Client\Adapter\Test as BaseAdapter;

/**
 * Provides enhanced methods to load fixtures
 *
 * @author David Stendardi <david.stendardi@adenclassifieds.com>
 */
class Test extends BaseAdapter
{
    /**
     * Where to find the fixtures
     *
     * @var string
     */
    protected $fixturesBasePath;

    /**
     * The requests journal
     *
     * @var array requests
     */
    protected $requests = array();

    /**
     * @param string path
     */
    public function setFixturesBasePath($path)
    {
        $this->fixturesBasePath = $path;
    }

    /**
     * Returns the last performed request
     *
     * @return array request
     */
    public function getLastRequest()
    {
        return end($this->requests);
    }

    /**
     * (non-PHPdoc)
     * @see Zend\Http\Client\Adapter.Socket::write()
     */
    public function write($method, $uri, $http_ver = '1.1', $headers = array(), $body = '')
    {
        $this->requests[] = array('method' => $method, 'uri' => $uri, 'http_ver' => $http_ver, 'headers' => $headers, 'body' => $body);

        return parent::write($method, $uri, $http_ver, $headers, $body);
    }

    /**
     * Set the next response directly from a fixture file
     *
     * @param string relative file path to the fixture
     */
    public function setNextResponseFromFile($file)
    {
        $path = $this->fixturesBasePath . '/' . $file;

        $expected = file_get_contents($path);

        $this->setResponse($expected);
    }
}