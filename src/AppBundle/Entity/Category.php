<?php
/**
 * Created by PhpStorm.
 * User: chokri
 * Date: 03/06/18
 * Time: 22:01
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Class Category
 * @package AppBundle\Entity
 *
 * @ExclusionPolicy("all")
 */
class Category
{
    /**
     * @var integer $categoryID
     * @ORM\Column(name="category_id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Expose
     * @Serializer\Type(name="integer")
     * @Serializer\SerializedName("categoryID")
     */
    private $categoryID;
    /**
     * @var string $categoryTitle
     * @Expose()
     * @Serializer\SerializedName("categoryTitle")
     * @Serializer\Type(name="string")
     * @ORM\Column(name="category_title", type="string", nullable=true)
     */
    private $categoryTitle;
    /**
     * @ORM\Column(name="category_description", type="text", nullable=true)
     * @Expose
     * @Serializer\SerializedName("categoryDescription")
     * @Serializer\Type(name="string")
     */
    private $categoryDescription;
    /**
     * @ORM\Column(name="category_image", type="string", nullable=true)
     * @Expose
     * @Serializer\SerializedName("categoryImage")
     * @Serializer\Type(name="string")
     */
    private $categoryImage;

    public function __toString()
    {
        return (string)$this->getCategoryTitle();
    }

    /**
     * Get categoryID
     *
     * @return integer
     */
    public function getCategoryId()
    {
        return $this->categoryID;
    }

    /**
     * Set categoryTitle
     *
     * @param string $categoryTitle
     *
     * @return Category
     */
    public function setCategoryTitle($categoryTitle)
    {
        $this->categoryTitle = $categoryTitle;

        return $this;
    }

    /**
     * Get categoryTitle
     *
     * @return string
     */
    public function getCategoryTitle()
    {
        return $this->categoryTitle;
    }

    /**
     * Set categoryDescription
     *
     * @param string $categoryDescription
     *
     * @return Category
     */
    public function setCategoryDescription($categoryDescription)
    {
        $this->categoryDescription = $categoryDescription;

        return $this;
    }

    /**
     * Get categoryDescription
     *
     * @return string
     */
    public function getCategoryDescription()
    {
        return $this->categoryDescription;
    }

    /**
     * Set categoryImage
     *
     * @param string $categoryImage
     *
     * @return Category
     */
    public function setCategoryImage($categoryImage)
    {
        $this->categoryImage = $categoryImage;

        return $this;
    }

    /**
     * Get categoryImage
     *
     * @return string
     */
    public function getCategoryImage()
    {
        return $this->categoryImage;
    }
}
