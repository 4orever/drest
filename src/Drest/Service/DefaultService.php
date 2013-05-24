<?php

namespace Drest\Service;


use Drest\Query\ResultSet;

use Doctrine\ORM,
	Drest\Response,
	Drest\Request,
	Drest\DrestException,
	Drest\Mapping\RouteMetaData;

/**
 *
 * A default service to class - used if AbstractService isn't extended for custom use
 * @author Lee
 *
 */
class DefaultService extends AbstractService
{


	/**
	 * Default method to return a single entity item
	 */
	public function getElement()
	{
	    $classMetaData = $this->matched_route->getClassMetaData();
	    $elementName = $classMetaData->getEntityAlias();

        $qb = $this->registerExpose(
	        $this->matched_route->getExpose(),
	        $this->em->createQueryBuilder()->from($classMetaData->getClassName(), $elementName),
	        $this->em->getClassMetadata($classMetaData->getClassName())
        );

        foreach ($this->matched_route->getRouteParams() as $key => $value)
        {
            $qb->andWhere($elementName . '.' . $key  . ' = :' . $key);
            $qb->setParameter($key, $value);
        }

        try
        {
            $resultSet = $this->createResultSet($qb->getQuery()->getSingleResult(ORM\Query::HYDRATE_ARRAY));
        } catch (\Exception $e)
        {
            return $this->handleError($e, Response::STATUS_CODE_404);
        }

        $this->renderDeterminedRepresentation($resultSet);
	}

	public function getCollection()
	{
        $classMetaData = $this->matched_route->getClassMetaData();
        $elementName = $classMetaData->getEntityAlias();

	    $qb = $this->registerExpose(
	        $this->matched_route->getExpose(),
	        $this->em->createQueryBuilder()->from($classMetaData->getClassName(), $elementName),
	        $this->em->getClassMetadata($classMetaData->getClassName())
        );

        foreach ($this->matched_route->getRouteParams() as $key => $value)
        {
            $qb->andWhere($elementName . '.' . $key . ' = :' . $key);
            $qb->setParameter($key, $value);
        }
        try
        {
            $resultSet = $this->createResultSet($qb->getQuery()->getResult(ORM\Query::HYDRATE_ARRAY));
        } catch (\Exception $e)
        {
            return $this->handleError($e, Response::STATUS_CODE_404);
        }

        $this->renderDeterminedRepresentation($resultSet);
	}


	public function postElement()
	{
        $classMetaData = $this->matched_route->getClassMetaData();

        $entityClass = $classMetaData->getClassName();
        $object = new $entityClass;


        // Load the data into a representation class, and pass that into the handle


        // Run any attached handle function - @todo: this might be obsolete
        if ($this->matched_route->hasHandleCall())
        {
            $handleMethod = $this->matched_route->getHandleCall();
            $object->$handleMethod($this->request);
        }

        try
        {
            $this->em->persist($object);
            $this->em->flush($object);

            $this->response->setStatusCode(Response::STATUS_CODE_201);
            if (($location = $this->matched_route->getOriginLocation($object, $this->request->getUrl())) !== false)
            {
                $this->response->setHttpHeader('Location', $location);
            }
            $resultSet = ResultSet::create(array(($location) ? $location : 'unknown'), 'location');
        } catch (\Exception $e)
        {
            return $this->handleError($e, Response::STATUS_CODE_500);
        }

        $this->renderDeterminedRepresentation($resultSet);
	}

	public function postCollection()
	{

	}

	public function putElement()
	{
	}

	public function putCollection()
	{
	}

	public function deleteElement()
	{
	}

	public function deleteCollection()
	{
	}


	/**
	 * @todo: do we implement this, consider: https://www.owasp.org/index.php/Cross_Site_Tracing
	 * Echo's the clients request directly back to them (no entity data is used)
	 */
	protected function traceRequest()
	{
	}

	protected function optionsRequest()
	{
	}

}