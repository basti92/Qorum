<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 21.12.15
 * Time: 15:47
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="topic")
 */
class Topic
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * One User who started topic
     * @ORM\ManyToOne(targetEntity="User", inversedBy="topicsStarted")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $author;


    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="topicsInvolved")
     * @ORM\JoinTable(name="topics_users")
     */
    protected $activeUsers;


    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="topics")
     * @ORM\JoinTable(name="topics_tags")
     */
    protected $tags;


    /**
     * A Topic can have several posts
     * @ORM\OneToMany(targetEntity="Post", mappedBy="topic")
     */
    protected $posts;


    /**
     * creation date
     * @ORM\Column(type="datetime")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $date;


    /**
     * last modified
     * @ORM\Column(type="datetime")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $lastModified;


    /**
     * @ORM\Column(type="text")
     */
    protected $headline;


    /**
     * @ORM\Column(type="text")
     */
    protected $description;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->activeUsers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Topic
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set headline
     *
     * @param string $headline
     *
     * @return Topic
     */
    public function setHeadline($headline)
    {
        $this->headline = $headline;

        return $this;
    }

    /**
     * Get headline
     *
     * @return string
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Topic
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
     * Set author
     *
     * @param \AppBundle\Entity\User $author
     *
     * @return Topic
     */
    public function setAuthor(\AppBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \AppBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Add activeUser
     *
     * @param \AppBundle\Entity\User $activeUser
     *
     * @return Topic
     */
    public function addActiveUser(\AppBundle\Entity\User $activeUser)
    {
        $this->activeUsers[] = $activeUser;

        return $this;
    }

    /**
     * Remove activeUser
     *
     * @param \AppBundle\Entity\User $activeUser
     */
    public function removeActiveUser(\AppBundle\Entity\User $activeUser)
    {
        $this->activeUsers->removeElement($activeUser);
    }

    /**
     * Get activeUsers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActiveUsers()
    {
        return $this->activeUsers;
    }

    /**
     * Add tag
     *
     * @param \AppBundle\Entity\Tag $tag
     *
     * @return Topic
     */
    public function addTag(\AppBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \AppBundle\Entity\Tag $tag
     */
    public function removeTag(\AppBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add post
     *
     * @param \AppBundle\Entity\Post $post
     *
     * @return Topic
     */
    public function addPost(\AppBundle\Entity\Post $post)
    {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Remove post
     *
     * @param \AppBundle\Entity\Post $post
     */
    public function removePost(\AppBundle\Entity\Post $post)
    {
        $this->posts->removeElement($post);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Set lastModified
     *
     * @param \DateTime $lastModified
     *
     * @return Topic
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    /**
     * Get lastModified
     *
     * @return \DateTime
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }
}
