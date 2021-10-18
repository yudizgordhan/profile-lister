<?php

namespace Yudiz\Freelancer\Api\Data;

interface ImageInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const ENTITY_ID = 'entity_id';
    const MULTIPLE_IMAGE = 'multiple_image';

    /**
     * Get Image Id.
     *
     * @return int
     */
    public function getEntityId();

    /**
     * Set Image Id.
     */
    public function setEntityId($entityId);

    /**
     * Get Multiple Image.
     *
     * @return varchar
     */
    public function getMultipleImage();

    /**
     * Set Multiple Image.
     */
    public function setMultipleImage($multipleImage);
}
