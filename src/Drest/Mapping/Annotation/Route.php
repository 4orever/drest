<?php

namespace Drest\Mapping\Annotation;


/**
 * @Annotation
 * @Target("ANNOTATION")
 */
final class Route
{
    /** @var string */
    public $name;

    /** @var string */
    public $content;

    /** @var string */
    public $routePattern;

    /** @var array */
    public $routeConditions;

    /** @var array */
    public $serviceCall;

    /** @var array */
    public $verbs;

    /** @var array */
    public $expose;

    /** @var boolean */
    public $allowOptions;

    /** @var boolean */
    public $collection;
}
