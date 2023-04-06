<?php

namespace MD\Subscriptions\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Columns implements OptionSourceInterface
{
    /**
     * @return array[]
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'id', 'label' => __('ID')],
            ['value' => 'plan_id', 'label' => __('Plan ID')],
            ['value' => 'subscriber_name', 'label' => __('Subscriber Name')],
            ['value' => 'subscriber_email', 'label' => __('Subscriber Email')],
            ['value' => 'start_date', 'label' => __('Start Date')],
            ['value' => 'end_date', 'label' => __('End Date')],
            ['value' => 'deliveries', 'label' => __('Deliveries')],
            ['value' => 'status', 'label' => __('Status')],
        ];
    }
}