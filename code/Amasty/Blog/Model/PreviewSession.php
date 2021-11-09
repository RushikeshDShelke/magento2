<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Blog
 */


namespace Amasty\Blog\Model;

/**
 * Class PreviewSession
 */
class PreviewSession extends \Magento\Framework\Session\SessionManager
{
    /**
     * @param array $postData
     * @return $this
     */
    public function setPostData($postData = [])
    {
        $this->storage->setData('post_data', $postData);
        return $this;
    }

    /**
     * @return array
     */
    public function getPostData()
    {
        $postData = $this->storage->getData('post_data');
        return is_array($postData) ? $postData : [];
    }

    /**
     * @return bool
     */
    public function hasPostData()
    {
        return !empty($this->getPostData());
    }
}
