<?php
namespace Yudiz\Freelancer\Model;

use Yudiz\Freelancer\Api\Data\ImageInterface;

class Image extends \Magento\Framework\Model\AbstractModel implements ImageInterface
{
    /**
     * CMS page cache tag.
    */
    const CACHE_TAG = 'freelancer_images';
    /**
     * @var string
     */
    protected $_cacheTag = 'freelancer_images';
    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'freelancer_images';
    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init(\Yudiz\Freelancer\Model\ResourceModel\Image::class);
    }
    /**
     * Get EntityId.
     *
     * @return int
     */
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }
    /**
     * Set EntityId.
     */
    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }
    /**
     * Get MultipleImage.
     *
     * @return varchar
     */
    public function getMultipleImage()
    {
        return $this->getData(self::MULTIPLE_IMAGE);
    }
    /**
     * Set MultipleImage.
     */
    public function setMultipleImage($multipleImage)
    {
        return $this->setData(self::MULTIPLE_IMAGE, $multipleImage);
    }
}
