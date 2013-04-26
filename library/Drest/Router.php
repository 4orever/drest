<?php
namespace Drest;


/**
 * Drest Router
 * @author Lee
 */
class Router
{

	/**
	 * A collection of registered service objects
	 * @var array $routes
	 */
	protected $routes = array();


	/**
	 * Get matched routes
	 * @param RequestInterface $request
	 * @param boolean $matchVerb - Whether you want to match the route using the request HTTP verb
	 * @return array $routes sends back an array of routes that have matched
	 */
	public function getMatchedRoutes(Request $request, $matchVerb = true)
	{
		$matches = array();

		foreach ($this->routes as $route)
		{
		    if ($route->matches($request, $matchVerb))
		    {
		        $matches[] = $route;
		    }

		}
		return $matches;
	}

	/**
	 * Register a route definition (pulled from annotations) into the router stack
	 * @param \Drest\Mapping\ServiceMetaData $service
	 */
	public function registerRoute($service)
	{
		$this->routes[$service->getName()] = $service;
	}

	/**
	 *
	 * A check to see if the router object has already been populated with a route object by $name
	 * @param sting $name
	 */
	public function hasRoute($name)
	{
		return isset($this->routes[$name]);
	}
}