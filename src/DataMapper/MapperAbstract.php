<?php
namespace Spark\Project\DataMapper;

// todo: convert to interface?
abstract class MapperAbstract
{

    /**
     * Save a model
     *
     * @param ModelAbstract $model
     */
    abstract public function save(ModelAbstract $model);

    /**
     * Find a model by its ID
     *
     * @param int $id
     */
    abstract public function find($id);

    /**
     * Insert a model
     *
     * @param ModelAbstract $model
     */
    abstract protected function insert(ModelAbstract $model);

    /**
     * Update a model
     *
     * @param ModelAbstract $model
     */
    abstract protected function update(ModelAbstract $model);

    /**
     * Delete a model
     *
     * @param ModelAbstract $model
     */
    abstract protected function delete(ModelAbstract $model);

    /**
     * Populate model's properties from an array
     *
     * @param ModelAbstract $model
     * @param array $data
     */
    abstract protected function populate(ModelAbstract $model, Array $data);
}
