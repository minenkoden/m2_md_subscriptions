<?php

namespace MD\Subscriptions\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

class Subscription extends Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_subscription';
        $this->_blockGroup = 'MD_Subscriptions';
        $this->_headerText = __('Subscriptions');
        parent::_construct();
    }
}