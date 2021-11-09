<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Blog
 */


namespace Amasty\Blog\Cron;

use Amasty\Blog\Api\Data\PostInterface;
use Magento\Framework\Stdlib\DateTime;
use Amasty\Blog\Model\Source\PostStatus;

/**
 * Class Scheduled
 */
class Scheduled
{
    /**
     * @var \Amasty\Blog\Api\PostRepositoryInterface
     */
    private $postRepository;

    /**
     * @var DateTime\DateTime
     */
    private $date;

    public function __construct(
        \Amasty\Blog\Api\PostRepositoryInterface $postRepository,
        DateTime\DateTime $date
    ) {
        $this->postRepository = $postRepository;
        $this->date = $date;
    }

    /**
     * @param \Magento\Cron\Model\Schedule $schedule
     * @throws \Zend_Date_Exception
     */
    public function execute(\Magento\Cron\Model\Schedule $schedule)
    {
        $posts = $this->postRepository->getPostCollection();
        $posts->addFieldToFilter(PostInterface::STATUS, PostStatus::STATUS_SCHEDULED)
            ->addFieldToFilter(PostInterface::PUBLISHED_AT, ['lt' => $this->date->gmtDate()]);

        foreach ($posts as $post) {
            $post->setStatus(PostStatus::STATUS_ENABLED);
            $this->postRepository->save($post);
        }
    }
}
