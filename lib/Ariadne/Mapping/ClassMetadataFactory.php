<?php
namespace Ariadne\Mapping;

/**
 * Implementation of ClassMetadataFactoryInterface
 */
use Ariadne\Mapping\Loader\LoaderInterface;
use Ariadne\Mapping;
use Doctrine\Common\Cache\AbstractCache;

class ClassMetadataFactory
{
    /**
     * The loader for loading the class metadata
     * @var LoaderInterface
     */
    protected $loader;

    /**
     * The cache for caching class metadata
     * @var AbstractCache
     */
    protected $cache;

    /**
     * Already loaded classes
     *
     * @var array
     */
    protected $loadedClasses = array();

    /**
     * Required dependencies
     *
     * @param LoaderInterface $loader
     * @param AbstractCache $cache
     */
    public function __construct(LoaderInterface $loader, AbstractCache $cache = null)
    {
        $this->loader = $loader;

        $this->cache = $cache;
    }

    /**
     * Returns the class metadata associated to the given class name
     *
     * @param string $class
     */
    public function getClassMetadata($class, $parent = null)
    {
        $class = ltrim($class, '\\');

        if (! isset($this->loadedClasses[$class])) {

            $cache = $this->getCache();

            if ($cache !== null && $cache->contains($class)) {
                $this->loadedClasses[$class] = $cache->fetch($class);
            } else {
                $metadata = $this->createClassMetaData($class);
                $this->getLoader()->loadClassMetadata($metadata);
                $embeds = $metadata->getEmbeds();
                if (! $parent) {
                    $parent = $metadata;
                }
                foreach ($metadata->getEmbeds() as $name => $embedded) {
                    $embeddedMetadata = $this->getClassMetadata($embedded->getClass(), $metadata);
                    $parent->setEmbeddedMetadata($name, $embeddedMetadata);
                }

                $this->loadedClasses[$class] = $metadata;

                if ($cache !== null) {
                    $cache->save($class, $metadata);
                }
            }
        }

        return $this->loadedClasses[$class];
    }

    public function createClassMetaData($class)
    {
        return new ClassMetadata($class);
    }

    /**
     * @return the $loader
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * @param LoaderInterface $loader
     */
    public function setLoader($loader)
    {
        $this->loader = $loader;
    }

    /**
     * @return the $cache
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @param AbstractCache $cache
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return the $loadedClasses
     */
    public function getLoadedClasses()
    {
        return $this->loadedClasses;
    }

    /**
     * @param array $loadedClasses
     */
    public function setLoadedClasses($loadedClasses)
    {
        $this->loadedClasses = $loadedClasses;
    }
}