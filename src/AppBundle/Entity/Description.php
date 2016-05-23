<?php
namespace AppBundle\Entity;

/**
 * @ORM\Entity
 * @ORM\Table(name="description")
 */
class Description
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

}
