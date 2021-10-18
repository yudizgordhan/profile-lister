<?php

namespace Yudiz\Freelancer\Api\Data;

interface FreelancerInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const ENTITY_ID = 'entity_id';
    const USER_ID = 'user_id';
    const PROFILE_IMAGE = 'profile_image';
    const FULL_NAME = 'full_name';
    const EMAIL_ID = 'email_id';
    const MOBILE_NUMBER = 'mobile_number';
    const LOCATION_DETAILS = 'location_details';
    const SKILL_DETAILS = 'skill_details';
    const SUMMARY_DETAILS = 'summary_details';
    const IS_ACTIVE = 'is_active';
    const SLUG = 'slug';
    const CREATED_AT = 'created_at';
    const UPDATE_TIME = 'update_time';

    /**
     * Get Freelancer Id.
     *
     * @return int
     */
    public function getEntityId();

    /**
     * Set Freelancer Id.
     */
    public function setEntityId($entityId);

    /**
     * Get User Id.
     *
     * @return int
     */
    public function getUserId();

    /**
     * Set User Id.
     */
    public function setUserId($userId);

    /**
     * Get Profile Image.
     *
     * @return varchar
     */
    public function getProfileImage();

    /**
     * Set Profile Image.
     */
    public function setProfileImage($profileImage);

    /**
     * Get Full Name.
     *
     * @return varchar
     */
    public function getFullName();

    /**
     * Set Full Name.
     */
    public function setFullName($fullName);

    /**
     * Get Email ID.
     *
     * @return varchar
     */
    public function getEmailId();

    /**
     * Set Email ID.
     */
    public function setEmailId($emailId);

    /**
     * Get Mobile Number.
     *
     * @return varchar
     */
    public function getMobileNumber();

    /**
     * Set Mobile Number.
     */
    public function setMobileNumber($mobileNumber);
    /**

     * Get Location Details.
     *
     * @return varchar
     */
    public function getLocationDetails();

    /**
     * Set Location Details.
     */
    public function setLocationDetails($locationDetails);

    /**
     * Get Skill Details.
     *
     * @return varchar
     */
    public function getSkillDetails();

    /**
     * Set Skill Details.
     */
    public function setSkillDetails($skillDetails);

    /**
     * Get Summary Details.
     *
     * @return varchar
     */
    public function getSummaryDetails();

    /**
     * Set Summary Details.
     */
    public function setSummaryDetails($summaryDetails);

    /**
     * Get IsActive.
     *
     * @return varchar
     */
    public function getIsActive();

    /**
     * Set IsActive.
     */
    public function setIsActive($isActive);

    /**
     * Get Slug.
     *
     * @return varchar
     */
    public function getSlug();

    /**
     * Set Slug.
     */
    public function setSlug($slug);

    /**
     * Get UpdateTime.
     *
     * @return varchar
     */
    public function getUpdateTime();

    /**
     * Set UpdateTime.
     */
    public function setUpdateTime($updateTime);

    /**
     * Get CreatedAt.
     *
     * @return varchar
     */
    public function getCreatedAt();

    /**
     * Set CreatedAt.
     */
    public function setCreatedAt($createdAt);
}
