<?php
/**
 * Mage SMS - SMS notification & SMS marketing
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the BSD 3-Clause License
 * It is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/BSD-3-Clause
 *
 * @category    TOPefekt
 * @package     TOPefekt_Magesms
 * @copyright   Copyright (c) 2012-2017 TOPefekt s.r.o. (http://www.mage-sms.com)
 * @license     http://opensource.org/licenses/BSD-3-Clause
 */
namespace Topefekt\Magesms\Model\Marketing\Filter; class Orderssum extends \Magento\Framework\DataObject implements FilterInterface { public $filter; public function __construct(array $ia61712c27ea241bd7a543dc2b02ea572274d0322 = []) { parent::__construct($ia61712c27ea241bd7a543dc2b02ea572274d0322); $this->cond = ['<', '>', '=', '<>']; $this->filter = [ 'title' => '∑ '.__('Order'), 'type' => 'number', 'name' => 'orderssum', 'color' => '#886543', ]; } public function getFilter(\Magento\Customer\Model\ResourceModel\Customer\Collection $iff7e46827cbb6547116c592bf800f4687428abf9, $i2d8fb6b6f17ec9aa17899ea311cc26bc493cd9a2) { $i717aafa07eeca1a7c0f40cc18a0eb90e0984de3e = []; foreach($i2d8fb6b6f17ec9aa17899ea311cc26bc493cd9a2 as $iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a) { if ($iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a instanceof $this) { $i3ca4aff6918962dee4a8054ca52f13ef3b6bab08 = $iba20acc78644ac0e9cd48ea35d8ad03b058f6b5a->getValue(); $i717aafa07eeca1a7c0f40cc18a0eb90e0984de3e[] = 'orders_sum '.$this->cond[$i3ca4aff6918962dee4a8054ca52f13ef3b6bab08[0]].' '.(float)$i3ca4aff6918962dee4a8054ca52f13ef3b6bab08[1]; } } if (count($i717aafa07eeca1a7c0f40cc18a0eb90e0984de3e)) { if (strpos($iff7e46827cbb6547116c592bf800f4687428abf9->getSelect(), $iff7e46827cbb6547116c592bf800f4687428abf9->getTable('sales/order_grid')) === false) $iff7e46827cbb6547116c592bf800f4687428abf9->joinTable('sales/order_grid', 'customer_id=entity_id', ['entity_id']); $iff7e46827cbb6547116c592bf800f4687428abf9->getSelect() ->columns('SUM('.$iff7e46827cbb6547116c592bf800f4687428abf9->getTable('sales/order_grid').'.`grand_total`) AS orders_sum') ->having(implode(' AND ', $i717aafa07eeca1a7c0f40cc18a0eb90e0984de3e)) ->group('e.entity_id'); } return $iff7e46827cbb6547116c592bf800f4687428abf9; } public function setValue($if2eee0665f163a28f4adcfe84e3fc666bf1bcd89) { $this->filter['cond'] = $this->cond[$if2eee0665f163a28f4adcfe84e3fc666bf1bcd89[0]]; return parent::setValue($if2eee0665f163a28f4adcfe84e3fc666bf1bcd89); } } 