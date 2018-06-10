<?php
/**
 * Created by PhpStorm.
 * User: chokri
 * Date: 07/06/18
 * Time: 22:06
 */

namespace AppBundle\Entity;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Reclamation
 * @package AppBundle\Entity
 *
 */
class Reclamation
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Serializer\Type(name="integer")
     */
    private $id;
    /**
     * @var Category
     * @Serializer\Type(name="AppBundle\Entity\Category")
     * @ORM\Column(name="category", type="integer", nullable=true)
     */
    private $category;
    /**
     * @var string
     * @Serializer\Type(name="string")
     * @ORM\Column(name="name", type="string", nullable=true)
     */
    private $description;
    /**
     * @var string
     * @Serializer\Type(name="string")
     * @ORM\Column(name="photo", type="string", nullable=true)
     */
    private $photo;
    /**
     * @var string
     * @Serializer\Type(name="string")
     * @Serializer\SerializedName("latitude")
     * @ORM\Column(name="latitude", type="string", nullable=true)
     */
    private $latitude;
    /**
     * @var string
     * @Serializer\Type(name="string")
     * @ORM\Column(name="longitude", type="string", nullable=true)
     */
    private $longitude;
    /**
     * @var string
     * @Serializer\Type(name="string")
     * @Serializer\SerializedName("danger_degree")
     * @ORM\Column(name="danger_degree", type="string", nullable=true)
     */
    private $dangerDegree;
    /**
     * @var boolean
     * @Serializer\Type(name="boolean")
     */
    private $enabled;



    /**
     * Get categoryID
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set category.
     *
     * @param int|null $category
     *
     * @return Reclamation
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category.
     *
     * @return int|null
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set name.
     *
     * @param string|null $description
     *
     * @return Reclamation
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set photo.
     *
     * @param string|null $photo
     *
     * @return Reclamation
     */
    public function setPhoto($photo = null)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo.
     *
     * @return string|null
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set latitude.
     *
     * @param string|null $latitude
     *
     * @return Reclamation
     */
    public function setLatitude($latitude = null)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude.
     *
     * @return string|null
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude.
     *
     * @param string|null $longitude
     *
     * @return Reclamation
     */
    public function setLongitude($longitude = null)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude.
     *
     * @return string|null
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set dangerDegree.
     *
     * @param string|null $dangerDegree
     *
     * @return Reclamation
     */
    public function setDangerDegree($dangerDegree = null)
    {
        $this->dangerDegree = $dangerDegree;

        return $this;
    }

    /**
     * Get dangerDegree.
     *
     * @return string|null
     */
    public function getDangerDegree()
    {
        return $this->dangerDegree;
    }
    public function setEnabled($enabled = false)
    {
        $this->enabled = $enabled;

        return $this;
    }
    public function getEnabled()
    {
        return $this->enabled;
    }
}
