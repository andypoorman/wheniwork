<?php
namespace Spark\Project\DataMapper;

class ShiftMapper extends MapperAbstract
{

    protected $fpdo;

    /**
     *
     * @param \FluentPDO $fpdo
     */
    public function __construct(\FluentPDO $fpdo)
    {
        $this->fpdo = $fpdo;
    }

    /**
     *
     * @param int $employeeId
     */
    public function getFutureShiftsByEmployee($employeeId)
    {
        $query = $this->fpdo->from('shifts')
            ->where('employee_id = ?', $employeeId)
            ->where('start_time > now()')
            ->limit(25);

        if (!count($query)) {
            return null;
        }

        $shifts = [];
        foreach ($query as $row) {
            $shifts[] = $this->populate($this->create(), $row);
        }
        return $shifts;
    }

    /**
     * Return a list of shifts between a specific date
     *
     * @param int $startTime
     * @param int $endTime
     * @return NULL|array
     */
    public function getShiftsBetween($startTime, $endTime)
    {
        // this query should find shifts that start or end during range,
        // shifts that start AND end during our range,
        // and shifts that encompass our whole range
        $query = $this->fpdo->from('shifts')->where(
            'start_time between ? and ?
            OR end_time between ? and ?
            OR (start_time <= ? AND end_time >= ?)',
            $startTime,
            $endTime,
            $startTime,
            $endTime,
            $startTime,
            $endTime
        );

        $shifts = [];
        foreach ($query as $row) {
            $shifts[] = $this->populate(new ShiftModel(), $row);
        }
        return $shifts;
    }

    /**
     * Return all shifts occurring withing a week of specified date
     *
     * @param int $employeeId
     * @param string $date
     */
    public function getWeeklySummary($employeeId, $date)
    {
        $query = $this->fpdo->from('shifts')
            ->where('start_time > DATE_SUB(DATE(?), INTERVAL 1 WEEK)', $date)
            ->where('employee_id = ?', $employeeId);

        $shifts = [];
        foreach ($query as $row) {
            $shifts[] = $this->populate(new ShiftModel(), $row);
        }
        return $shifts;
    }

    /**
     * return ShiftModel
     */
    public function create()
    {
        return new ShiftModel();
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Spark\Project\DataMapper\MapperAbstract::save()
     */
    public function save(ModelAbstract $model)
    {
        if ($model->getId()) {
            return $this->update($model);
        } else {

            return $this->insert($model);
        }
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Spark\Project\DataMapper\MapperAbstract::find()
     */
    public function find($id)
    {
        $query = $this->fpdo->from('shifts')
            ->where('id = ?', (int) $id)
            ->limit(1);

        $row = $query->fetch();
        if ($row) {
            return $this->populate($this->create(), $row);
        }
        return false;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Spark\Project\DataMapper\MapperAbstract::insert()
     */
    protected function insert(ModelAbstract $model)
    {
        //todo: make this more automatic
        $values = [
            'manager_id' =>  (int) $model->getManagerId(),
            'employee_id' => (int) $model->getEmployeeId(),
            'break' => floatval($model->getBreak()),
            'start_time' => $model->getStartTime(),
            'end_time' => $model->getEndTime(),
            'created_at' => new \FluentLiteral('NOW()'),
            'updated_at' => new \FluentLiteral('NOW()'),
        ];

        return $this->fpdo->insertInto('shifts')->values($values)->execute();
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Spark\Project\DataMapper\MapperAbstract::update()
     */
    protected function update(ModelAbstract $model)
    {

    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Spark\Project\DataMapper\MapperAbstract::delete()
     */
    protected function delete(ModelAbstract $model)
    {

    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Spark\Project\DataMapper\MapperAbstract::populate()
     */
    protected function populate(ModelAbstract $model, Array $data)
    {
        if (empty($data)) {
            return null;
        }

        // Populate the properties on the ShiftModel. I could use and __set for this
        $model->setId($data['id']);
        $model->setManagerId($data['manager_id']);
        $model->setEmployeeId($data['employee_id']);
        $model->setBreak($data['break']);
        $model->setStartTime($data['start_time']);
        $model->setEndTime($data['end_time']);
        $model->setCreatedAt($data['created_at']);
        $model->setUpdatedAt($data['updated_at']);

        return $model;
    }
}
