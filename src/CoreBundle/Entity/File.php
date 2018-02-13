<?php

namespace CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class File
 * @package CoreBundle\Entity
 *
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\FileRepository")
 * @ORM\Table(name="files")
 */
class File
{
    const SOURCE_TYPE_LOCAL_STORAGE = 'LOCAL_STORAGE';
    const SOURCE_TYPE_REMOTE_FILE = 'REMOTE_FILE';

    const META_TYPE_RAW = 'RAW';
    const META_TYPE_JSON = 'JSON';
    const META_TYPE_SERIALIZED = 'SERIALIZED';

    const TYPE_IMAGE = 'image';
    const TYPE_PLAIN = 'plain';
    const TYPE_APPLICATION = 'application';

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var User|null
     * @ORM\ManyToOne(targetEntity="User", inversedBy="files")
     * @ORM\JoinColumn(name="owner_id", nullable=true, onDelete="SET NULL")
     */
    private $owner;

    /**
     * @var File|null
     * @ORM\ManyToOne(targetEntity="File", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", nullable=true, onDelete="CASCADE")
     */
    private $parent;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $title = '';

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $description = '';

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $type = '';

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $mimeType = '';

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $source = '';

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $sourceType = self::SOURCE_TYPE_LOCAL_STORAGE;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private $meta;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private $metaType;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $originalName = '';

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $size = 0;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $image = false;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $organizedByDate = true;

    /**
     * @var integer|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $width;

    /**
     * @var integer|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $height;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @var ArrayCollection|File[]
     * @ORM\OneToMany(targetEntity="File", mappedBy="parent")
     */
    private $children;

    /**
     * @var ArrayCollection|News[]
     * @ORM\OneToMany(targetEntity="News", mappedBy="image")
     */
    private $linkToNews;

    /**
     * File constructor.
     */
    public function __construct()
    {
        $this->linkToNews = new ArrayCollection;
    }

    /**
     * @param array $data
     * @return array
     */
    public function getSerializableArray(array $data = [])
    {
        $arr = [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'mime_type' => $this->mimeType,
            'source' => $this->source,
            'source_type' => $this->sourceType,
            'meta' => $this->meta,
            'meta_type' => $this->metaType,
            'original_name' => $this->originalName,
            'size' => $this->size,
            'image' => $this->image,
            'organized_by_date' => $this->organizedByDate,
            'width' => $this->width,
            'height' => $this->height,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'owner' => $this->owner ? $this->owner->getId() : null,
            'parent' => $this->parent ? $this->parent->getId() : null,
            'rel_dir' => $this->getRelativeDirectory(),
            'rel_path' => $this->getRelativePath(),
        ];

        return count($data) ? array_intersect($arr, $data) : $arr;
    }

   

    /**
     * @param boolean $organizedByDate
     */
    public function setOrganizedByDate($organizedByDate)
    {
        $this->organizedByDate = $organizedByDate;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * @return ArrayCollection|Event[]
     */
    public function getLinkToNews()
    {
        return $this->linkToNews;
    }

    /**
     * @param ArrayCollection|News[] $linkToNews
     */
    public function setLinkToNews($linkToNews)
    {
        $this->linkToNews = $linkToNews;
    }

    /**
     * @return User|null
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param User|null $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return File|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param File|null $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * @return string
     */
    public function getSourceType()
    {
        return $this->sourceType;
    }

    /**
     * @param string $sourceType
     */
    public function setSourceType($sourceType)
    {
        $this->sourceType = $sourceType;
    }

    /**
     * @return null|string
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @param null|string $meta
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;
    }

    /**
     * @return null|string
     */
    public function getMetaType()
    {
        return $this->metaType;
    }

    /**
     * @param null|string $metaType
     */
    public function setMetaType($metaType)
    {
        $this->metaType = $metaType;
    }

    /**
     * @return string
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * @param string $originalName
     */
    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return boolean
     */
    public function isImage()
    {
        return $this->image;
    }

    /**
     * @param boolean $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return int|null
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int|null $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return int|null
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int|null $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime|null $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return ArrayCollection|File[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param ArrayCollection|File[] $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }


    public function __toString()
    {
        return (string)$this->getId();
    }

}