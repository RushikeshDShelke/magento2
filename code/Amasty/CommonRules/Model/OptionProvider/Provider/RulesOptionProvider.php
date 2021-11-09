<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2018 Amasty (https://www.amasty.com)
 * @package Amasty_CommonRules
 */


namespace Amasty\CommonRules\Model\OptionProvider\Provider;

use Magento\Framework\Exception\LocalizedException;

class RulesOptionProvider implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var array|null
     */
    private $options;

    /**
     * @var \Magento\SalesRule\Api\RuleRepositoryInterface
     */
    private $ruleRepository;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaInterface
     */
    private $searchCriteria;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    public function __construct(
        \Magento\SalesRule\Api\RuleRepositoryInterface $ruleRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteria,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->ruleRepository = $ruleRepository;
        $this->searchCriteria = $searchCriteria;
        $this->logger = $logger;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        try {
            if (!$this->options) {
                $rules = [
                    [
                        'value' => '0', 'label' => ' '
                    ]
                ];
                $searchCriteria = $this->searchCriteria->addFilter(
                    \Magento\SalesRule\Model\Data\Rule::KEY_USE_AUTO_GENERATION,
                    1
                )->create();

                /** @var \Magento\SalesRule\Api\Data\RuleInterface[] $rulesCollection */
                $rulesCollection = $this->ruleRepository->getList($searchCriteria)->getItems();
                foreach ($rulesCollection as $rule) {
                    $rules[] = ['value' => $rule->getRuleId(), 'label' => $rule->getName()];
                }

                $this->options = $rules;
            }
        } catch (LocalizedException $exception) {
            $this->logger->critical($exception->getMessage());
        }

        return $this->options;
    }
}
