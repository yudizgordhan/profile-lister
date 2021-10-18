<?php
namespace Yudiz\Freelancer\Model;

use Yudiz\Freelancer\Api\Data\FreelancerInterface;

class Freelancer extends \Magento\Framework\Model\AbstractModel implements FreelancerInterface
{
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'freelancer_profile';

    /**
     * @var string
     */
    protected $_cacheTag = 'freelancer_profile';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'freelancer_profile';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init(\Yudiz\Freelancer\Model\ResourceModel\Freelancer::class);
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
     * Get UserId.
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->getData(self::USER_ID);
    }

    /**
     * Set UserId.
     */
    public function setUserId($userId)
    {
        return $this->setData(self::USER_ID, $userId);
    }
    /**
     * Get ProfileImage.
     *
     * @return varchar
     */
    public function getProfileImage()
    {
        return $this->getData(self::PROFILE_IMAGE);
    }

    /**
     * Set ProfileImage.
     */
    public function setProfileImage($profileImage)
    {
        return $this->setData(self::PROFILE_IMAGE, $profileImage);
    }
    /**
     * Get Full Name.
     *
     * @return varchar
     */
    public function getFullName()
    {
        return $this->getData(self::FULL_NAME);
    }

    /**
     * Set Full Name.
     */
    public function setFullName($fullName)
    {
        return $this->setData(self::FULL_NAME, $fullName);
    }

    /**
     * Get Email Id.
     *
     * @return varchar
     */
    public function getEmailId()
    {
        return $this->getData(self::EMAIL_ID);
    }

    /**
     * Set Email Id.
     */
    public function setEmailId($emailId)
    {
        return $this->setData(self::EMAIL_ID, $emailId);
    }

    /**
     * Get Mobile Number.
     *
     * @return varchar
     */
    public function getMobileNumber()
    {
        return $this->getData(self::MOBILE_NUMBER);
    }

    /**
     * Set Mobile Number.
     */
    public function setMobileNumber($mobileNumber)
    {
        return $this->setData(self::MOBILE_NUMBER, $mobileNumber);
    }

    /**
     * Get Location Details.
     *
     * @return varchar
     */
    public function getLocationDetails()
    {
        return $this->getData(self::LOCATION_DETAILS);
    }

    /**
     * Set Location Details.
     */
    public function setLocationDetails($locationDetails)
    {
        return $this->setData(self::LOCATION_DETAILS, $locationDetails);
    }

    /**
     * Get Skill Details.
     *
     * @return varchar
     */
    public function getSkillDetails()
    {
        return $this->getData(self::SKILL_DETAILS);
    }

    /**
     * Set Skill Details.
     */
    public function setSkillDetails($skillDetails)
    {
        return $this->setData(self::SKILL_DETAILS, $skillDetails);
    }

    /**
     * Get Summary Details.
     *
     * @return varchar
     */
    public function getSummaryDetails()
    {
        return $this->getData(self::SUMMARY_DETAILS);
    }

    /**
     * Set Summary Details.
     */
    public function setSummaryDetails($summaryDetails)
    {
        return $this->setData(self::SUMMARY_DETAILS, $summaryDetails);
    }

    /**
     * Get IsActive.
     *
     * @return varchar
     */
    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * Set IsActive.
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Get Slug.
     *
     * @return varchar
     */
    public function getSlug()
    {
        return $this->getData(self::SLUG);
    }

    /**
     * Set Slug.
     */
    public function setSlug($slug)
    {
        return $this->setData(self::SLUG, $slug);
    }

    /**
     * Get UpdateTime.
     *
     * @return varchar
     */
    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * Set UpdateTime.
     */
    public function setUpdateTime($updateTime)
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }

    /**
     * Get CreatedAt.
     *
     * @return varchar
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set CreatedAt.
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }
}
