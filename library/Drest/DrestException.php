<?php
namespace Drest;

use Exception,
    Drest\Mapping;

/**
 * Base exception class for all Drest exceptions.
 *
 * @author Lee
 */
class DrestException extends Exception
{

	// Set up and configuration
    public static function metadataCacheNotConfigured()
    {
        return new self('Class Metadata Cache is not configured, ensure an instance of Doctrine\Common\Cache\Cache is passed to the Drest\Configuration::setMetadataCacheImpl()');
    }

    public static function invalidCacheInstance()
    {
        return new self('Cache must be an instance of Doctrine\Common\Cache\Cache');
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

    public static function routeAlreadyDefinedWithName($class, $name)
    {
        return new self('Route on class ' . $class . ' already exists with the name ' . $name . '. These must be unique');
    }

    public static function routeNameIsEmpty()
    {
        return new self('Route name used cannot be blank, and must only contain alphanumerics or underscore');
    }

    public static function invalidServiceCallFormat()
    {
        return new self('Service call infromation is invalid. Must be in the format service_call={"CLASSNAME", "METHODNAME"}');
    }

    public static function invalidHttpVerbUsed($verb)
    {
        return new self('Used an unknown HTTP verb of "' . $verb . '"');
    }

    public static function unknownContentOption($type)
    {
        return new self('Used an unknown content type of "' . $type . '". values ELEMENT or COLLECTION should be used.');
    }

    public static  function unknownDetectContentOption()
    {
        return new self('Content option used is invalid. Please see DETECT_CONTENT_* options in Drest\Configuration');
    }

    public static function pathToConfigFilesRequired()
    {
        return new self('Path to your configuration files are required for the driver to retrieve all class names');
    }

    public static function pathToConfigFilesMustBeDirectory($path)
    {
        return new self('The path to your configuration files must be a directory. "' . $path . '" given.');
    }

    public static function unableToLoadMetaDataFromDriver()
    {
        return new self('Unable to load metadata using supplied driver');
    }

    public static function invalidExposeRelationFetchType()
    {
        return new self('Invalid relation fetch type used. Please see Doctrine\ORM\Mapping\ClassMetadataInfo::FETCH_* for avaiable options');
    }

    public static function unknownExposeRequestOption()
    {
        return new self('Unknown expose request option used. Please see EXPOSE_REQUEST_* options in Drest\Configuration');
    }

    public static function unableToParseExposeFieldsString()
    {
        return new self('Unable to parse expose fields string. Must contain required field names to be pipe delimited with each nesting within square brackets. For example:  "username|email_address|profile[id|lastname|addresses[id]]|phone_numbers"');
    }
    public static function invalidAllowedOptionsValue()
    {
        return new self('Invalid Allow Options value, must be -1 to unset, 0 for no or 1 for yes. Or you can use boolean values');
    }

    public static function basePathMustBeAString()
    {
        return new self('Base path used is invalid. Must be a string');
    }

    public static function basePathNotRegistered()
    {
        return new self('The requested base path has not been registered');
    }

    public static function alreadyHandleDefinedForRoute(\Drest\Mapping\RouteMetaData $route)
    {
        return new self('There is a handle already defined for the route ' . $route->getName() . ' on class ' . $route->getClassMetaData()->getClassName());
    }

    public static function handleAnnotationDoesntMatchRouteName($name)
    {
        return new self('The configured handle "' . $name . '" doesn\'t match any route of that name. Ensure @Drest\Handle(for="my_route") matches @Drest\Route(name="my_route")');
    }

    public static function handleForCannotBeEmpty()
    {
        return new self('The @Drest\Handle configuration MUST contain a valid / matching "for" value');
    }

    // Service Exceptions
    public static function serviceClassNotAnInstanceOfDrestService($class)
    {
    	return new self('Service class  "' . $class . '" is not an instance of Drest\Service.');
    }

    public static function unknownServiceMethod($class, $method)
    {
        return new self('Unknown method "' . $method . '" on service class "' . $class);
    }

    public static function noMatchedRouteSet()
    {
        return new self('No matched route has been set on this service class. The content type is needed for a default service method call');
    }

    public static function dataWrapNameMustBeAString()
    {
        return new self('Data wrap name must be a string value. Eg array(\'user\' => array(...))');
    }

    public static function invalidParentKeyNameForResultSet()
    {
        return new self('Parent key name in ResultSet object is invalid. Must be an alphanumeric string (underscores allowed)');
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
}



