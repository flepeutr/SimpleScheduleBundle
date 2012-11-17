<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\SimpleScheduleBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * This entity is based on the VEVENT Component from the RFC2445
 *
 * Purpose: Provide a grouping of component properties that describe a todo.
 *
 * @ORM\Entity
 */
class Todo extends LocalizableCalendarEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * completed
     *
     * This property defines the date and time that a to-do was
     * actually completed.
     *
     * * @ORM\Column(type="datetime", nullable=true)
     */
    protected $completed;

    /**
     * percent
     *
     * This property is used by an assignee or delegatee of a to-do
     * to convey the percent completion of a to-do to the Organizer.
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *      min = "0",
     *      max = "100",
     *      minMessage = "percent must be at least 0%",
     *      maxMessage = "percent must be at max 100%"
     * )
     */
    protected $percent;

    /**
     * due
     *
     * This property defines the date and time that a to-do is
     * expected to be completed.
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $due;
}