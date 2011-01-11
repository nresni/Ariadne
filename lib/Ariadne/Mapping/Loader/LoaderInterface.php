<?php
namespace Ariadne\Mapping\Loader;

use Ariadne\Mapping\ClassMetadata;

interface LoaderInterface
{
    /**
     * Load a Class Metadata.
     *
     * @param ClassMetadata $metadata A metadata
     *
     * @return boolean
     */
    function loadClassMetadata(ClassMetadata $metadata);
}