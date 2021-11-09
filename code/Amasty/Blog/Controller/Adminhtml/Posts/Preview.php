<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Blog
 */


namespace Amasty\Blog\Controller\Adminhtml\Posts;

use Amasty\Blog\Api\Data\PostInterface;
use Amasty\Blog\Model\Repository\PostRepository;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\MessageInterface;
use Amasty\Blog\Model\PostsFactory;
use Amasty\Blog\Model\Source\PostStatus;

/**
 * Class
 */
class Preview extends \Magento\Backend\App\Action
{
    /**
     * @var PostsFactory
     */
    private $postsFactory;

    /**
     * @var \Amasty\Blog\Model\PreviewSession
     */
    private $previewSession;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    private $dateTime;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    private $resultJsonFactory;

    /**
     * @var \Amasty\Blog\Helper\Date
     */
    private $helperDate;

    /**
     * @var PostRepository
     */
    private $repository;

    /**
     * @var \Magento\Framework\Url
     */
    private $urlHelper;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Amasty\Blog\Model\PostsFactory $postsFactory,
        \Amasty\Blog\Model\PreviewSession $previewSession,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Amasty\Blog\Helper\Date $helperDate,
        \Amasty\Blog\Model\Repository\PostRepository $repository,
        \Magento\Framework\Url $urlHelper
    ) {
        parent::__construct($context);
        $this->postsFactory = $postsFactory;
        $this->previewSession = $previewSession;
        $this->dateTime = $dateTime;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->helperDate = $helperDate;
        $this->repository = $repository;
        $this->urlHelper = $urlHelper;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $messages = [];
        $data = $this->getPostdata();
        if ($data) {
            try {
                $post = $this->postsFactory->create(['data' => $data]);
                $this->prepareForView($post);
                $this->previewSession->setPostData($post->getData());
            } catch (\Exception $e) {
                $messages[] = __('An error occurred while execution');
                $messages[] = $e->getMessage();
            }
        } else {
            $messages[] = __('Empty Data for the post for preview');
        }

        if ($this->getRequest()->isAjax()) {
            if (!empty($messages)) {
                return $this->resultJsonFactory->create()->setData(
                    [
                        'messages' => $messages,
                        'error'    => true
                    ]
                );
            }

            return $this->resultJsonFactory->create()->setData([]);
        } else {
            if (!empty($messages)) {
                foreach ($messages as $message) {
                    $this->messageManager->addErrorMessage($message);
                }

                return $this->_redirect('*/*/');
            }

            $url = $this->urlHelper->getUrl('amblog/post/preview');
            return $this->_redirect($url);
        }
    }

    /**
     * @return array
     */
    protected function getPostdata()
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            $postId = $this->getRequest()->getParam('id', false);
            if ($postId) {
                try {
                    $post = $this->repository->getById($postId);
                    $data = $post->getData();
                } catch (NoSuchEntityException $e) {
                    $data = [];
                }
            }
        }
        return $data;
    }

    /**
     * @param $model
     */
    private function prepareForView($model)
    {
        $this->prepareImage($model, PostInterface::POST_THUMBNAIL);
        $this->prepareStatus($model);
    }

    /**
     * @param $model
     */
    public function prepareStatus($model)
    {
        $model->setStatus(PostStatus::STATUS_ENABLED);
        if (!$model->getPublishedAt()) {
            $currentTimestamp = $this->dateTime->gmtTimestamp();
            $model->setPublishedAt(date('Y-m-d H:i:s', $currentTimestamp));
        } else {
            $convertedDate = $this->helperDate->renderDate(date('Y-m-d H:i:s', strtotime($model->getPublishedAt())));
            $model->setPublishedAt($convertedDate);
        }
    }

    /**
     * @param $model
     * @param $imageName
     */
    private function prepareImage($model, $imageName)
    {
        $fileName = $imageName . '_file';
        $thumbnail = $model->getData($fileName);
        if (isset($thumbnail) && is_array($thumbnail)) {
            if (isset($thumbnail[0]['name']) && isset($thumbnail[0]['tmp_name'])) {
                $model->setData($imageName, 'tmp/' . $thumbnail[0]['name']);
            }
        }
    }
}
