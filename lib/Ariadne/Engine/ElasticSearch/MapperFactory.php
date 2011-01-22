<?php
namespace Ariadne\Engine\ElasticSearch;

/**
 * The mapper factory is used to lazy instanciate mappers.
 * Mappers are generic object that transforms generic objects
 * into an array definition that will be formatted inside the
 * request
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class MapperFactory
{
    /**
     * @var array mappers
     */
    protected $mappers = array();

    /**
     * @var array options
     */
    protected $options = array(
        'result' => 'Ariadne\Engine\ElasticSearch\Mapper\ResultMapper',
        'query'  => 'Ariadne\Engine\ElasticSearch\Mapper\QueryMapper',
        'index'  => 'Ariadne\Engine\ElasticSearch\Mapper\IndexMapper',
        'schema' => 'Ariadne\Engine\ElasticSearch\Mapper\SchemaMapper'
        );

    /**
     * Options are used to overrides the default class provided
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->options = array_merge($this->options, $options);
    }


    /**
     * Get a mapper instance
     *
     * @param string $mapper
     * @return Mapper $mapper
     */
    public function get($mapper)
    {
        if (true === isset($this->mappers[$mapper]))
        {
            return $this->mappers[$mapper];
        }

        if (false === isset($this->options[$mapper]))
        {
            throw new \InvalidArgumentException("Unknown mapper $mapper");
        }

        $class = $this->options[$mapper];

        $this->mappers[$mapper] = new $class();

        return $this->mappers[$mapper];
    }

}