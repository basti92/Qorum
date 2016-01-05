<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 20.12.15
 * Time: 16:17
 */

namespace AppBundle\Entity;


use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_fos")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @ORM\OneToMany(targetEntity="Topic", mappedBy="author")
     */
    protected $topicsStarted;


    /**
     * @ORM\ManyToMany(targetEntity="Topic", mappedBy="activeUsers")
     */
    protected $topicsInvolved;


    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="author")
     */
    protected $posts;





    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Add topicsStarted
     *
     * @param \AppBundle\Entity\Topic $topicsStarted
     *
     * @return User
     */
    public function addTopicsStarted(\AppBundle\Entity\Topic $topicsStarted)
    {
        $this->topicsStarted[] = $topicsStarted;

        return $this;
    }

    /**
     * Remove topicsStarted
     *
     * @param \AppBundle\Entity\Topic $topicsStarted
     */
    public function removeTopicsStarted(\AppBundle\Entity\Topic $topicsStarted)
    {
        $this->topicsStarted->removeElement($topicsStarted);
    }

    /**
     * Get topicsStarted
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTopicsStarted()
    {
        return $this->topicsStarted;
    }

    /**
     * Add topicsInvolved
     *
     * @param \AppBundle\Entity\Topic $topicsInvolved
     *
     * @return User
     */
    public function addTopicsInvolved(\AppBundle\Entity\Topic $topicsInvolved)
    {
        $this->topicsInvolved[] = $topicsInvolved;

        return $this;
    }

    /**
     * Remove topicsInvolved
     *
     * @param \AppBundle\Entity\Topic $topicsInvolved
     */
    public function removeTopicsInvolved(\AppBundle\Entity\Topic $topicsInvolved)
    {
        $this->topicsInvolved->removeElement($topicsInvolved);
    }

    /**
     * Get topicsInvolved
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTopicsInvolved()
    {
        return $this->topicsInvolved;
    }

    /**
     * Add post
     *
     * @param \AppBundle\Entity\Post $post
     *
     * @return User
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




}
