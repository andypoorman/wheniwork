<?php
namespace Spark\Project\DataMapper;

abstract class ModelAbstract
{

    protected $id;

    abstract public function getId();

    abstract public function setId($id);
}
