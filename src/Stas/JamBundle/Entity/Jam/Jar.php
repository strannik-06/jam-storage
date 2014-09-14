<?php

namespace Stas\JamBundle\Entity\Jam;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Stas\JamBundle\Entity\Jam\Type;
use Stas\JamBundle\Entity\Year;

/**
 * Jar
 *
 * @ORM\Table("jam_jar")
 * @ORM\Entity
 */
class Jar
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Type
     *
     * @ORM\ManyToOne(targetEntity="\Stas\JamBundle\Entity\Jam\Type", cascade={"persist"})
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     *
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * @var Year
     *
     * @ORM\ManyToOne(targetEntity="\Stas\JamBundle\Entity\Year", cascade={"persist"})
     * @ORM\JoinColumn(name="year_id", referencedColumnName="id")
     *
     * @Assert\NotBlank()
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;


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
     * Set type
     *
     * @param Type $type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set year
     *
     * @param Year $year
     *
     * @return self
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return Year
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return self
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }
}
