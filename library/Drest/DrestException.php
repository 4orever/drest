<?php
namespace Drest;

use Exception;

/**
 * Base exception class for all ORM exceptions.
 *
 * @author Roman Borschel <roman@code-factory.org>
 * @since 2.0
 */
class DrestException extends Exception
{

	// Set up and configuration
    public static function metadataCacheNotConfigured()
    {
        return new self('Class Metadata Cache is not configured, ensure an instance of Doctrine\Common\Cache\Cache is passed to the Drest\Configuration::setMetadataCacheImpl()');
    }

    public static function currentlyRunningDebugMode()
    {
        return new self('Debug mode is set to on. This will cause configuration exceptions to be displayed and should be switched off in production');
    }

    public static function missingMappingDriverImpl()
    {
        return new self('It\'s a requirement to specify a Metadata Driver and pass it to Drest\\Configuration::setMetadataDriverImpl().');
    }

    public static function annotatedResourceRequiresAtLeastOneServiceDefinition($className)
    {
        return new self('The annotated resource on class ' . $className . ' doesn\'t have any service definitionions. Ensure you have "services={@Drest\Service(..)} set');
    }

    public static function serviceAlreadyDefinedWithName($class, $name)
    {
        return new self('Service on class ' . $class . ' already exists with name ' . $name . '. These must be unique');
    }

    public static function serviceNameIsEmpty()
    {
        return new self('Service name used cannot be blank, and must only contain alphanumerics or underscore');
    }

    public static function invalidHttpVerbUsed($verb)
    {
        return new self('Used an unknown HTTP verb of "' . $verb . '"');
    }

    public static function unknownContentType($type)
    {
        return new self('Used an unknown content type of "' . $type . '". values ELEMENT or COLLECTION should be used.');
    }


    // Repository Exceptions
    public static function entityRepositoryNotAnInstanceOfDrestRepository($entityClass)
    {
    	return new self('Repository class for entity "' . $entityClass . '" is not an instance of Drest\Repository. Ensure you\'ve annotated your entities to either use @Entity(repositoryClass="Drest\Repository") or setup inheritence with it');
    }

    public static function unknownRepositoryMethod($class, $method)
    {
        return new self('Unknown method "' . $method . '" on repository class "' . $class);
    }

    public static function repositoryNeedsRequestObject()
    {
        return new self('Repository needs access to the request object to determine a default method call, inject using setRequest()');
    }


    // Writer Exceptions
    public static function writerExpectsArray($class_name)
    {
    	return new self('Writer class ' . $class_name . ' expects an array when using \Doctrine\ORM\Query::HYDRATE_ARRAY data');
    }

    public static function unknownWriterClass($class_name)
    {
    	return new self('Unknown writer class "' . $class_name . '". Defined writer classes must be an instance of Drest\\Writer\\Interface');
    }

    public static function writerMustBeObjectOrString()
    {
		return new self('Writer must be an object of Drest\\Writer\\Interface or a string representing the class name');
    }

    public static function unableToMatchAWriter()
    {
        return new self('Unable to match a writer instance using Configuration::DETECT_CONTENT_* methods set');
    }

    public static function noWritersSetForService(Mapping\ServiceMetaData $service)
    {
        return new self('No writers have been set for the service "' . $service->getName() . '" for the Entity "' . $service->getClassMetaData()->name . "'");
    }


    // Request Exceptions
    public static function unknownAdapterForRequestObject($object)
    {
    	return new self('Unknown / Not yet created adapter for request object ' . get_class($object));
    }

    public static function invalidRequestObjectPassed()
    {
    	return new self('Request object passed in is invalid (not type of object)');
    }

    public static function noRequestObjectDefinedAndCantInstantiateDefaultType($className)
    {
    	return new self('No request object has been passed, and cannot instantiate the default request object: ' . $className . ' ensure this class is setup on your autoloader');
    }

    public static function unknownHttpVerb($className)
    {
    	return new self('Unable to determine a valid HTTP verb from request adapter ' . $className);
    }


    // Response Exceptions
    public static function unknownAdapterForResponseObject($object)
    {
    	return new self('Unknown / Not yet created adapter for response object ' . get_class($object));
    }

    public static function invalidResponsetObjectPassed()
    {
    	return new self('Response object passed in is invalid (not type of object)');
    }

    public static function noResponseObjectDefinedAndCantInstantiateDefaultType($className)
    {
    	return new self('No response object has been passed, and cannot instantiate the default response object: ' . $className . ' ensure this class is setup on your autoloader');
    }

    public static function invalidHttpStatusCode($code)
    {
        return new self('Invalid HTTP Status code used "' . $code . '"');
    }

    // Routing
    public static function noMatchedRoutes()
    {
        return new self('There are no routes configured to match this request path');
    }

    public static function multipleRoutesFound($services)
    {
        $helperText = '';
        foreach ($services as $service)
        {
            $helperText .= '"' . $service->getName() . '"';
        }
        return new self('Multiple routes have matched to this request. See service definitions for: ' . $helperText);
    }

}



