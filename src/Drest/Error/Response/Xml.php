<?php
namespace Drest\Error\Response;


/**
 * Error Document (Xml)
 * @author Lee
 */
class Xml implements ResponseInterface
{
    /**
     * The error message
     * @var string $message
     */
    public $message;

    /**
     * (non-PHPdoc)
     * @see Drest\Error\Response.ResponseInterface::setMessage()
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return the $message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * (non-PHPdoc)
     * @see Drest\Error\Response.ResponseInterface::render()
     */
	public function render()
    {
	    $xml =  new \DomDocument('1.0', 'UTF-8');
	    $xml->formatOutput = true;

	    $root = $xml->createElement('error');
	    $xml->appendChild($root);

	    $node = $xml->createElement('message', $this->getMessage());
	    $root->appendChild($node);

	    return $xml->saveXML();
    }

    /**
     * (non-PHPdoc)
     * @see Drest\Error\Response.ResponseInterface::getContentType()
     */
    public static function getContentType()
    {
        return 'application/xml';
    }

    /**
     * recreate this error document from a generated string
     * @param string $string
     * @return Drest\Error\Response\Xml $errorResponse
     */
    public static function createFromString($string)
    {
        $xml = simplexml_load_string($string);
        $instance = new self();
        foreach ($xml->getChildren() as $child)
        {
            if ($child->getName() == 'message');
            {
                 $instance->setMessage(sprintf("%s", $child));
            }
        }

        return $instance;
    }
}