<?php
namespace DrestTests\Response;


use DrestTests\DrestTestCase,
 	Drest\Response,
 	Symfony\Component\HttpFoundation,
 	Zend\Http;

class ResponseTest extends DrestTestCase
{

	public function testCreateResponse()
	{
		$response = new Response();

		// Ensure default response object creates a symfony response
		$this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response->getAdapter()->getResponse());
	}

	public function testStaticCreateResponse()
	{
		$response = Response::create();
	}

	public function testCreateResponseWithZendFramework2ResponseObject()
	{
		$zfResponse = new Http\Response();
		$response = Response::create($zfResponse);

		// Ensure response object creates a zf2 response
		$this->assertInstanceOf('Zend\Http\Response', $response->getAdapter()->getResponse());
	}

	public function testCreateResponseWithSymfony2ResponseObject()
	{
		$symResponse = new HttpFoundation\Response();
		$response = Response::create($symResponse);

		// Ensure response object creates a symfony2 response
		$this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response->getAdapter()->getResponse());
	}
}

