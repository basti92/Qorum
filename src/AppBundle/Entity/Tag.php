<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 21.12.15
 * Time: 16:21
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Entity\TagRepository")
 * @ORM\Table(name="tag")
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @ORM\ManyToMany(targetEntity="Topic", mappedBy="tags")
     */
    protected $topics;


    /**
     * @ORM\Column(type="text")
     */
    protected $title;


    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->topics = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set title
     *
     * @param string $title
     *
     * @return Tag
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Tag
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add topic
     *
     * @param \AppBundle\Entity\Topic $topic
     *
     * @return Tag
     */
    public function addTopic(\AppBundle\Entity\Topic $topic)
    {
        $this->topics[] = $topic;

        return $this;
    }

    /**
     * Remove topic
     *
     * @param \AppBundle\Entity\Topic $topic
     */
    public function removeTopic(\AppBundle\Entity\Topic $topic)
    {
        $this->topics->removeElement($topic);
    }

    /**
     * Get topics
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTopics()
    {
        return $this->topics;
    }


    public function SizeRelatedContent()
    {
        $topics = $this->getTopics();
        $size = 0;
        if (!empty($topics)) {
            foreach ($topics as $topic) {
                /* @var $topic Topic */
                $size = $size + $topic->getPosts()->count();
            }
        }
        return $size;
    }





}
