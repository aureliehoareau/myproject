<?php

namespace Site\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description
 *
 * @ORM\Table(name="site_description")
 * @ORM\Entity(repositoryClass="Site\BlogBundle\Repository\DescriptionRepository") 
 * @ORM\HasLifecycleCallbacks()
 */
class Description 
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
   * @var string
   * @Gedmo\Translatable
   * @ORM\Column(name="subtitle", type="string", length=255)
   * @Assert\NotBlank()
   * @Assert\Length(
     *      min = "1",
     *      max = "255",
     *      minMessage = "Le sous-titre doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le sous-titre ne peut pas être plus long que {{ limit }} caractères"
     * )
   */
  private $subtitle;


  /**
   * @var string
   * @Gedmo\Translatable
   * @ORM\Column(name="preview", type="string", length=255)
   * @Assert\NotBlank()
   * @Assert\Length(
     *      min = "1",
     *      max = "255",
     *      minMessage = " Le résumé doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le résumé ne peut pas être plus long que {{ limit }} caractères"
     * )
   */
  private $preview;

  /**
   * @var string
   * @Gedmo\Translatable
   * @Assert\NotBlank()
   * @ORM\Column(name="content", type="text")
   * @Assert\Length(
     *      min = "1",
     *      minMessage = " Le contenu doit faire au moins {{ limit }} caractères" 
     * )
   */
  private $content;

 



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
     * Set subtitle
     *
     * @param string $subtitle
     *
     * @return Description
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     * Get subtitle
     *
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set preview
     *
     * @param string $preview
     *
     * @return Description
     */
    public function setPreview($preview)
    {
        $this->preview = $preview;

        return $this;
    }

    /**
     * Get preview
     *
     * @return string
     */
    public function getPreview()
    {
        return $this->preview;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Description
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    

   

    


}
