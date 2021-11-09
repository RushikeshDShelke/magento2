<?php

namespace Admitad\Track\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;

class ConfigObserver implements ObserverInterface
{

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var WriterInterface
     */
    private $configWriter;

    public function __construct(
        RequestInterface $request,
        WriterInterface $configWriter
    ) {
        $this->request = $request;
        $this->configWriter = $configWriter;
    }

    public function execute(EventObserver $observer)
    {
        $groups = $this->request->getParam('groups');
        if (!empty($groups['actions']['fields'])) {
            foreach ($groups['actions']['fields'] as $key => $value) {
                if (is_array($value['value'])) {
                    $value['value'] = implode(',', $value['value']);
                }
                $this->configWriter->save('admitadtrack/actions/' . $key, $value['value']);
            }
        }

        return $this;
    }
}
