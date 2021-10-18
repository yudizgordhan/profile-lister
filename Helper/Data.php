<?php

namespace Yudiz\Freelancer\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Validation\ValidationException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $_storeManager;
    protected $context;
    protected $_mediaDirectory;
    protected $_fileUploaderFactory;
    public $messageManager;
    protected $filesystem;
    protected $adapterFactory;
    public $imageFactory;

    public function __construct(
        Context $context,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Yudiz\Freelancer\Model\ImageFactory $imageFactory,
        \Magento\Framework\Filesystem\Driver\File $file,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\Image\AdapterFactory $adapterFactory,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory
    ) {
        $this->context = $context;
        $this->_storeManager = $storeManager;
        $this->messageManager = $messageManager;
        $this->filesystem = $filesystem;
        $this->_file = $file;
        $this->imageFactory = $imageFactory;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->adapterFactory = $adapterFactory;
        $this->_mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        parent::__construct($context);
    }

    public function getMediaUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

    public function isEnable()
    {
        return $this->scopeConfig->getValue('freelancer/general/enable', ScopeInterface::SCOPE_STORE);
    }

    public function getSlug($title, $model)
    {
        $slug = strtolower($title);
        $new_slug = str_replace(' ', '-', $slug);
        $count = $model->getCollection()->addFieldToFilter('slug', ['slug', $new_slug])->count();
        $data['slug'] = $new_slug;
        if ($count > 0) {
            $data['slug'] = $new_slug . '-' . $count;
        }

        return $data['slug'];
    }

    public function checkEmail($inputemail, $entityId, $model)
    {
        $emailcount = $model->getCollection()->addFieldToFilter('email_id', $inputemail)
                        ->addFieldToFilter('entity_id', ['neq' => $entityId])
                        ->count();
        if ($emailcount <= 0) {
            return true;
        }
        return false;
    }

    public function checkMobile($inputmobile, $entityId, $model)
    {
        $mobilecount = $model->getCollection()
            ->addFieldToFilter('mobile_number', $inputmobile)
            ->addFieldToFilter('entity_id', ['neq' => $entityId])
            ->count();
        if ($mobilecount <= 0) {
            return true;
        }
        return false;
    }

    public function getprofileImage($data)
    {
        try {
            $target = $this->_mediaDirectory->getAbsolutePath('freelancer/profile');
            $targetOne = 'freelancer/profile/';
            $uploader = $this->_fileUploaderFactory->create(['fileId' => 'profile_image']);
            $this->validateImages($uploader);
            $result = $uploader->save($target);
            $imagePath = $targetOne.$result['file'];
            $data['profile_image'] = $imagePath;
            return $data['profile_image'];
        } catch (ValidationException $e) {
            throw new LocalizedException(__('Upload valid profile image. Only JPG, JPEG and PNG are allowed'));
        } catch (\Exception $e) {
            //if an except is thrown, no image has been uploaded
            throw new LocalizedException(__($e->getMessage()));
        }
    }

    public function getCoverImage($files, $lastId, $data)
    {
        try {
            $file1 = $files['multiple_image'];
            foreach ($file1 as $images => $value) {
                $field_name = "multiple_image[" . $images . "]";
                if (!empty($file1[$images])) {
                    $imagemodel = $this->imageFactory->create(); // Model load of Cover image
                    $target = $this->_mediaDirectory->getAbsolutePath('freelancer/coverimage');
                    $targetOne = 'freelancer/coverimage/';
                    $uploader = $this->_fileUploaderFactory->create(['fileId' => $field_name]);
                    $this->validateImages($uploader);
                    $result = $uploader->save($target);
                    $imagePath = $targetOne.$result['file'];
                    $data['multiple_image'] = $imagePath;
                    $imagemodel->setMultipleImage($data['multiple_image']);
                    $imagemodel->setFreelancerId($lastId);
                    $imagemodel->save();
                }
            }
        } catch (ValidationException $e) {
            throw new LocalizedException(__('Upload valid cover image. Only JPG, JPEG and PNG are allowed'));
        } catch (\Exception $e) {
            //if an except is thrown, no image has been uploaded
            throw new LocalizedException(__('Something went wrong'));
        }
    }

    protected function validateImages($uploader)
    {
        $uploader->setAllowedExtensions(['jpg', 'jpeg', 'png']);
        $imageAdapter = $this->adapterFactory->create();
        $uploader->setAllowRenameFiles(true);
        $uploader->validateFile();
    }
}
