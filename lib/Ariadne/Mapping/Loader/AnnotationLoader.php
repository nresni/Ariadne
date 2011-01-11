<?php
namespace Ariadne\Mapping\Loader;

use Ariadne\Mapping\Element\Embed;

use Ariadne\Mapping\Element\Collection;

use Symfony\Component\Validator\Validator;

use Doctrine\Common\Annotations\AnnotationReader;
use Ariadne\Mapping\ClassMetadata;
use Ariadne\Mapping\Element;
use Ariadne\Mapping\Element\Index;
use Ariadne\Mapping\Element\Field;

/**
 *
 * Enter description here ...
 * @author dstendardi
 *
 */
class AnnotationLoader implements LoaderInterface
{
    /**
     *
     * Enter description here ...
     * @var unknown_type
     */
    protected $reader;

    /**
     *
     * Enter description here ...
     * @param unknown_type $paths
     */
    public function __construct(AnnotationReader $reader, Validator $validator, array $paths = null)
    {
        if (null === $paths) {
            $paths = array('search' => 'Ariadne\\Mapping\\Element\\');
        }

        $this->validator = $validator;

        $this->reader = $reader;

        $this->reader->setAutoloadAnnotations(true);

        foreach ($paths as $prefix => $path) {
            $this->reader->setAnnotationNamespaceAlias($path, $prefix);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function loadClassMetadata(ClassMetadata $metadata)
    {
        $reflClass = $metadata->getReflectionClass();
        $className = $reflClass->getName();
        $loaded = false;

        foreach ($this->reader->getClassAnnotations($reflClass) as $index) {
            if ($index instanceof Index) {
                $metadata->setIndex($index);
            }

            $loaded = true;
        }

        foreach ($reflClass->getProperties() as $property) {
            if ($property->getDeclaringClass()->getName() == $className) {
                foreach ($this->reader->getPropertyAnnotations($property) as $type) {
                    if ($type instanceof Field) {
                        $violations = $this->validator->validate($type);
                        if ($violations->count()) {
                            throw new \InvalidArgumentException($violations);
                        }
                        $metadata->addField($property->getName(), $type);
                    }

                    if ($type instanceof Embed) {
                        $metadata->addEmbed($property->getName(), $type);
                    }

                    $loaded = true;
                }
            }
        }

        return $loaded;
    }
}