<?php

namespace Drest;

use Drest\DrestException,
	Drest\Mapping\Driver\AnnotationsDriver,
	Doctrine\Common\Cache\Cache,
    Doctrine\Common\Annotations\AnnotationRegistry;


class Configuration
{
    /**
     * Configuration attributes
     *
     * @var array
     */
    protected $_attributes = array();


    /**
     * Create a default instance of the annotationsDriver
     *
     * @param array $paths
     * @return AnnotationDriver
     */
    public function defaultAnnotationDriver($paths = array())
    {
        AnnotationRegistry::registerFile(__DIR__ . '/Mapping/Driver/DrestAnnotations.php');

        if ($useSimpleAnnotationReader) {
            // Register the ORM Annotations in the AnnotationRegistry
            $reader = new SimpleAnnotationReader();
            $reader->addNamespace('Doctrine\ORM\Mapping');
            $cachedReader = new CachedReader($reader, new ArrayCache());

            return new AnnotationDriver($cachedReader, (array) $paths);
        }

        return new AnnotationDriver(
            new CachedReader(new AnnotationReader(), new ArrayCache()),
            (array) $paths
        );
    }



    /**
     * Sets the cache driver implementation that is used for metadata caching.
     *
     * @param MappingDriver $driverImpl
     * @todo Force parameter to be a Closure to ensure lazy evaluation
     *       (as soon as a metadata cache is in effect, the driver never needs to initialize).
     */
    public function setMetadataDriverImpl(MappingDriver $driverImpl)
    {
        $this->_attributes['metadataDriverImpl'] = $driverImpl;
    }


    /**
     * Gets the cache driver implementation that is used for the mapping metadata.
     *
     * @throws ORMException
     * @return MappingDriver
     */
    public function getMetadataDriverImpl()
    {
        return isset($this->_attributes['metadataDriverImpl'])
            ? $this->_attributes['metadataDriverImpl']
            : null;
    }


    /**
     * Gets the cache driver implementation that is used for metadata caching.
     *
     * @return \Doctrine\Common\Cache\Cache
     */
    public function getMetadataCacheImpl()
    {
        return isset($this->_attributes['metadataCacheImpl'])
            ? $this->_attributes['metadataCacheImpl']
            : null;
    }

    /**
     * Sets the cache driver implementation that is used for metadata caching.
     *
     * @param \Doctrine\Common\Cache\Cache $cacheImpl
     */
    public function setMetadataCacheImpl(Cache $cacheImpl)
    {
        $this->_attributes['metadataCacheImpl'] = $cacheImpl;
    }


    /**
     * Ensures that this Configuration instance contains settings that are
     * suitable for a production environment.
     *
     * @throws DrestException If a configuration setting has a value that is not
     *                      suitable for a production environment.
     */
    public function ensureProductionSettings()
    {
        if ( ! $this->getMetadataCacheImpl()) {
            throw DrestException::metadataCacheNotConfigured();
        }
    }


}