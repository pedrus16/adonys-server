<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\User;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Report
 *
 * @ORM\Table(name="`report`")
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class Report
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="reports")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     * @Expose
     */
    private $client;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="reports")
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     * @Expose
     */
    private $employee;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     * @Expose
     */
    private $status;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set client
     *
     * @param \AppBundle\Entity\User $client
     *
     * @return Report
     */
    public function setClient(\AppBundle\Entity\User $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \AppBundle\Entity\User
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set employee
     *
     * @param \AppBundle\Entity\User $employee
     *
     * @return Report
     */
    public function setEmployee(\AppBundle\Entity\User $employee = null)
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * Get employee
     *
     * @return \AppBundle\Entity\User
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Report
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }
}
