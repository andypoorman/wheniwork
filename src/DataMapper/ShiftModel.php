<?php
namespace Spark\Project\DataMapper;

class ShiftModel extends ModelAbstract
{

    protected $id;

    protected $managerId;

    protected $employeeId;

    protected $break;

    protected $startTime;

    protected $endTime;

    protected $createdAt;

    protected $updatedAt;

    /**
     *
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return the $managerId
     */
    public function getManagerId()
    {
        return $this->managerId;
    }

    /**
     *
     * @return the $employeeId
     */
    public function getEmployeeId()
    {
        return $this->employeeId;
    }

    /**
     *
     * @return the $break
     */
    public function getBreak()
    {
        return $this->break;
    }

    /**
     *
     * @return the $startTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     *
     * @return the $endTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     *
     * @return the $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     *
     * @return the $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @param int $managerId
     */
    public function setManagerId($managerId)
    {
        $this->managerId = $managerId;
    }

    /**
     *
     * @param int $employeeId
     */
    public function setEmployeeId($employeeId)
    {
        $this->employeeId = $employeeId;
    }

    /**
     *
     * @param float $break
     */
    public function setBreak($break)
    {
        $this->break = $break;
    }

    /**
     *
     * @param field_type $startTime
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }

    /**
     *
     * @param field_type $endTime
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }

    /**
     *
     * @param field_type $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     *
     * @param field_type $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}
