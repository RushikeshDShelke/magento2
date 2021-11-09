<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Blog
 */


namespace Amasty\Blog\Model;

use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class ImageProcessor
 */
class ImageProcessor
{
    const BLOG_MEDIA_PATH = 'amasty/blog';

    const BLOG_MEDIA_TMP_PATH = 'amasty/blog/tmp';

    /**
     * @var \Magento\Catalog\Model\ImageUploader
     */
    private $imageUploader;

    /**
     * @var \Magento\Framework\ImageFactory
     */
    private $imageFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Magento\Framework\Filesystem\Directory\WriteInterface
     */
    private $mediaDirectory;

    /**
     * @var \Magento\Framework\Filesystem
     */
    private $filesystem;

    public function __construct(
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Catalog\Model\ImageUploader $imageUploader,
        \Magento\Framework\ImageFactory $imageFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->filesystem = $filesystem;
        $this->imageUploader = $imageUploader;
        $this->imageFactory = $imageFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * @return \Magento\Framework\Filesystem\Directory\WriteInterface
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    private function getMediaDirectory()
    {
        if ($this->mediaDirectory === null) {
            $this->mediaDirectory = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        }

        return $this->mediaDirectory;
    }

    /**
     * @param $imageName
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getThumbnailUrl($imageName)
    {
        return $this->getCategoryIconMedia(self::BLOG_MEDIA_PATH) . '/' . $imageName;
    }

    /**
     * @param string $iconName
     *
     * @return string
     */
    private function getImageRelativePath($iconName)
    {
        return self::BLOG_MEDIA_PATH . DIRECTORY_SEPARATOR . $iconName;
    }

    /**
     * @param $mediaPath
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getCategoryIconMedia($mediaPath)
    {
        return $this->storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $mediaPath;
    }

    /**
     * @param $iconName
     * @throws \Magento\Framework\Exception\FileSystemException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function processCategoryIcon($iconName)
    {
        $this->imageUploader->moveFileFromTmp($iconName);

        $filename = $this->getMediaDirectory()->getAbsolutePath($this->getImageRelativePath($iconName));
        try {
            /** @var \Magento\Framework\Image $imageProcessor */
            $imageProcessor = $this->imageFactory->create(['fileName' => $filename]);
            $imageProcessor->keepAspectRatio(true);
            $imageProcessor->keepFrame(true);
            $imageProcessor->keepTransparency(true);
            $imageProcessor->backgroundColor([255, 255, 255]);
            $imageProcessor->save();
        } catch (\Exception $e) {
            null;// Unsupported image format.
        }
    }

    /**
     * @param $iconName
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function deleteImage($iconName)
    {
        $this->getMediaDirectory()->delete($this->getImageRelativePath($iconName));
    }
}
