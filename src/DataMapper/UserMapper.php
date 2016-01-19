<?php
namespace Spark\Project\DataMapper;

class UserMapper extends MapperAbstract
{
    protected $fpdo;

    /**
     *
     * @param \FluentPDO $fpdo
     */
    public function __construct(\FluentPDO $fpdo)
    {
        //todo fix hard dependency
        $this->fpdo = $fpdo;
    }

    /**
     *
     * {@inheritDoc}
     * @see \Spark\Project\DataMapper\MapperAbstract::save()
     */
    public function save(ModelAbstract $model)
    {

    }

    /**
     *
     * {@inheritDoc}
     * @see \Spark\Project\DataMapper\MapperAbstract::find()
     */
    public function find($id)
    {
        $query = $this->fpdo->from('users')
            ->where('id = ?', (int) $id)
            ->limit(1);

        $row = $query->fetch();
        if ($row) {
            return $this->populate(new UserModel(), $row);
        }
        return false;
    }

    /**
     *
     * @param int $id
     * @param string $token
     */
    public function findByIdToken($id, $token)
    {
        $query = $this->fpdo->from('users')
            ->where('id = ?', (int) $id)
            ->where('token = ?', $token)
            ->limit(1);

        $row = $query->fetch();
        if ($row) {
            return $this->populate(new UserModel(), $row);
        }
        return false;
    }

    /**
     *
     * {@inheritDoc}
     * @see \Spark\Project\DataMapper\MapperAbstract::insert()
     */
    protected function insert(ModelAbstract $model)
    {

    }

    /**
     *
     * {@inheritDoc}
     * @see \Spark\Project\DataMapper\MapperAbstract::update()
     */
    protected function update(ModelAbstract $model)
    {

    }

    /**
     *
     * {@inheritDoc}
     * @see \Spark\Project\DataMapper\MapperAbstract::delete()
     */
    protected function delete(ModelAbstract $model)
    {

    }

    /**
     *
     * {@inheritDoc}
     * @see \Spark\Project\DataMapper\MapperAbstract::populate()
     */
    protected function populate(ModelAbstract $model, Array $data)
    {
        if (empty($data)) {
            return null;
        }

        // Populate the properties on the UserModel. I could use and __set for this
        $model->setId($data['id']);
        $model->setName($data['name']);
        $model->setRole($data['role']);
        $model->setEmail($data['email']);
        $model->setPhone($data['phone']);
        $model->setCreatedAt($data['created_at']);
        $model->setUpdatedAt($data['updated_at']);
        $model->setToken($data['token']);

        return $model;
    }
}
