<?php

namespace Site\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Article
 *
 * @ORM\Table(name="site_article")
 * @ORM\Entity(repositoryClass="Site\BlogBundle\Repository\ArticleRepository") 
 * @ORM\HasLifecycleCallbacks()
 */
class Article
{
    /**
   * @var int
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\OneToOne(targetEntity="Site\BlogBundle\Entity\Description", cascade={"persist"})
   */
  private $description;

  /**
   * @ORM\OneToOne(targetEntity="Site\MediaBundle\Entity\Image", cascade={"persist"})
   */
  private $image;

  /** @ORM\ManyToOne(targetEntity="Site\UserBundle\Entity\User")
   */
  private $user;

  /**
    * @var integer
    *
    * @ORM\ManytoMany(targetEntity="Site\MediaBundle\Entity\Category", cascade={"persist"})
    */
  private $categories;

  /**
   * @ORM\OneToOne(targetEntity="Site\MediaBundle\Entity\Language", cascade={"persist"})
   */
  private $language;

   /**
   * @var \DateTime
   * @ORM\Column(name="date", type="datetime")
   * @Assert\DateTime()
   */
  private $date;

  /**
   * @ORM\Column(name="updatedAt", type="datetime", nullable=true)
   */
  private $updatedAt;

   /**
   * @ORM\Column(name="published", type="boolean", nullable=true)
   */
  private $published;



  /**
    * Constructor
    */
 public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->date = new \DateTime('now');
        
    }

/**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Description
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Description
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
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
     * Set decription
     *
     * @param \Site\BlogBundle\Entity\Description $decription
     *
     * @return Article
     */
    public function setDecription(\Site\BlogBundle\Entity\Description $decription = null)
    {
        $this->decription = $decription;

        return $this;
    }

    /**
     * Get decription
     *
     * @return \Site\BlogBundle\Entity\Description
     */
    public function getDecription()
    {
        return $this->decription;
    }

    /**
     * Set image
     *
     * @param \Site\MediaBundle\Entity\Image $image
     *
     * @return Article
     */
    public function setImage(\Site\MediaBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Site\MediaBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set user
     *
     * @param \Site\UserBundle\Entity\User $user
     *
     * @return Article
     */
    public function setUser(\Site\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Site\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add category
     *
     * @param \Site\MediaBundle\Entity\Category $category
     *
     * @return Article
     */
    public function addCategory(\Site\MediaBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \Site\MediaBundle\Entity\Category $category
     */
    public function removeCategory(\Site\MediaBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set language
     *
     * @param \Site\MediaBundle\Entity\Language $language
     *
     * @return Article
     */
    public function setLanguage(\Site\MediaBundle\Entity\Language $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \Site\MediaBundle\Entity\Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set description
     *
     * @param \Site\BlogBundle\Entity\Description $description
     *
     * @return Article
     */
    public function setDescription(\Site\BlogBundle\Entity\Description $description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return \Site\BlogBundle\Entity\Description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Service
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

}
