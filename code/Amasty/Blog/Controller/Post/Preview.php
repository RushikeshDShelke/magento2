<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Blog
 */


namespace Amasty\Blog\Controller\Post;

/**
 * Class Preview
 */
class Preview extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Amasty\Blog\Model\PostsFactory
     */
    private $postsFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    /**
     * @var \Amasty\Blog\Helper\Url
     */
    private $urlHelper;

    /**
     * @var \Magento\Store\App\Response\Redirect
     */
    private $redirect;

    /**
     * @var \Amasty\Blog\Model\PreviewSession
     */
    private $previewSession;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Registry $registry,
        \Amasty\Blog\Model\PostsFactory $postsFactory,
        \Magento\Store\App\Response\Redirect $redirect,
        \Amasty\Blog\Helper\Url $urlHelper,
        \Amasty\Blog\Model\PreviewSession $previewSession
    ) {
        parent::__construct($context);
        $this->postsFactory = $postsFactory;
        $this->registry = $registry;
        $this->urlHelper = $urlHelper;
        $this->redirect = $redirect;
        $this->previewSession = $previewSession;
    }

    /**
     * @return void
     */
    public function execute()
    {
        if ($this->previewSession->hasPostData()) {
            if (strpos($this->getRequest()->getPathInfo(), '/amp/') !== false) {
                $this->urlHelper->addAmpHeaders($this->getResponse());
            }

            $post = $this->postsFactory->create();
            $post->addData($this->previewSession->getPostData());
            $post->setIsPreviewPost(true);
            $post->setCommentsEnabled(false);

            $this->registry->unregister('current_post');
            $this->registry->register('current_post', $post);
            $this->_view->loadLayout();
            $this->_view->renderLayout();
        } else {
            $this->_redirect('noroute');
        }
    }
}
