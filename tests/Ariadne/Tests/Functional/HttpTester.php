<?php
namespace Ariadne\Tests\Functional;

use Zend\Http\Response;
use Symfony\Component\Yaml\Yaml;
use Ariadne\Tests\Functional\BaseTest;

/**
 * An http client tester
 *
 * @author dstendardi
 */
class HttpTester
{
    /**
     * Body comparaison will use YAML::load
     *
     * @var int
     */
    const PARSER_YAML = 1;

    /**
     * body comparaison will use json decode
     *
     * @var integer
     */
    const PARSER_JSON = 2;

    /**
     * @var int expected body parser
     */
    protected $expectedBodyParser = self::PARSER_YAML;

    /**
     * Set the last request as the subject for the following assertions
     *
     * @param FunctionalTest $test
     */
    public function __construct(BaseTest $test)
    {
        $this->test = $test;

        $this->request = preg_split('|(?:\r?\n){2}|m', $this->test->getHttpClient()->getLastRequest(), 2);

        if ( ! $this->request[0]) {
            $this->test->fail("no request found");
        }
    }

    /**
     *
     * @return $this
     */
    public function setExpectedBodyParser($parser)
    {
        $this->expectedBodyParser = $parser;

        return $this;
    }


    /**
     * Compare the given fixture with the request
     *
     * @param string $file
     */
    public function compare($file)
    {
        $expected = file_get_contents($this->test->getFixtureBasePath() . '/' . $file);

        list ($headers, $body) = preg_split('|(?:\r?\n){2}|m', $expected, 2);

        $this->test->assertStringMatchesFormat($this->clean($headers), $this->clean($this->request[0]));

        if ($body) {
            $this->compareBody($body);
        }
    }

    /**
     * @param string $input
     * @return string cleaned
     */
    public function clean($input)
    {
        return trim(str_replace("\r", "", $input));
    }

    /**
     * Asserts that the body match the given json structure
     *
     * @param array $content
     */
    public function compareBody($expected)
    {
        $given = $this->request[1];

        if (! $given) {
            $this->test->fail("the last request does not contain a body");
        }

        switch ($this->expectedBodyParser) {
            case self::PARSER_YAML:
                $expected = Yaml::load($expected);
                break;
            case self::PARSER_JSON:
                $expected = json_decode($expected);
                break;
            default:
                $expected = $this->clean($expected);
        }

        $given = $this->expectedBodyParser ? json_decode($given, true) : $this->clean($given);

        $this->test->assertEquals($expected, $given, "body is a valid and expected json structure : " . $given);
    }
}