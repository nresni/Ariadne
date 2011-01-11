<?php
namespace Ariadne\Http\Client\Adapter;

use Zend\Http\Client\Adapter\Socket as BaseAdapter;

/**
 * Provides enhanced methods to load fixtures
 *
 * @author David Stendardi <david.stendardi@adenclassifieds.com>
 */
class Dumper extends BaseAdapter
{
    /**
     * The full path where to dump the response file
     *
     * @var string path
     */
    protected $dumpPath;

    /**
     * Where to find the fixtures
     *
     * @var string
     */
    protected $fixturesBasePath;

    /**
     * (non-PHPdoc)
     * @see Zend\Http\Client\Adapter.Socket::write()
     */
    public function write($method, $uri, $http_ver = '1.1', $headers = array(), $body = '')
    {
        $request = parent::write($method, $uri, $http_ver, $headers, $body);

        $this->dump('request', $request);

        return $request;
    }

    /**
     * (non-PHPdoc)
     * @see Zend\Http\Client\Adapter.Socket::write()
     */
    public function read()
    {
        $response = parent::read();

        $this->dump('response', $response);

        if ($this->dumpPath) {
            file_put_contents($this->dumpPath, $response);
        }

        return $response;
    }

    /**
     * dump the request/response
     */
    public function dump($phase, $content)
    {
        $return = array("\n********* START $phase ***************\n");

        $return[] = $content;

        $return[] = "\n*************** END $phase ***************\n";

        echo implode("\n", $return);
    }

    /**
     * Mock method to ease debug switching from Test to Dumper
     */
    public function setNextResponseFromFile($file)
    {
        if (false === $file) {
            $this->dumpPath = false;
        } else {
            $this->dumpPath = $this->fixturesBasePath . '/' . $file;
        }
    }

    /**
     * @param string path
     */
    public function setFixturesBasePath($path)
    {
        $this->fixturesBasePath = $path;
    }

}