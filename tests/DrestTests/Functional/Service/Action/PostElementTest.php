<?php
namespace DrestTests\Functional\Service\Action;

use DrestTests\DrestFunctionalTestCase;

class PostElementTests extends DrestFunctionalTestCase
{

    public function testPostElementRequest()
    {
        $dm = $this->_getDrestManager($this->_em);
        $representation = new \Drest\Representation\Json();

        // id's added for comparison but not used for persistence (see DrestTests\Entities\CMS\User::populatePost())
        $user = array(
            'id' => 1,
            'username' => 'leedavis81',
            'email_address' => 'hello@somewhere.com',
            'phone_numbers' => array(
                array('id' => 1, 'number' => '02087856589'),
                array('id' => 2, 'number' => '07584565445'),
                array('id' => 3, 'number' => '02078545896'),
            )
        );

        $representation->write(\Drest\Query\ResultSet::create($user, 'user'));

        $request = \Symfony\Component\HttpFoundation\Request::create(
            '/user',
            'POST',
            array(),
            array(),
            array(),
            array('HTTP_CONTENT_TYPE' => $representation->getContentType()),
            $representation->__toString()
        );

        $response = $dm->dispatch($request);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertNotEmpty($response->getHttpHeader('Location'));

        // Ensure this item exists in persistence
        $query = $this->_em->createQuery('SELECT u, p FROM DrestTests\Entities\CMS\User u JOIN u.phone_numbers p');
        $this->assertEquals($user, $query->getSingleResult(\Doctrine\ORM\Query::HYDRATE_ARRAY));
    }

}