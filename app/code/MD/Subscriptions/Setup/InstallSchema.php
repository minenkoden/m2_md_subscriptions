<?php

namespace MD\Subscriptions\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        // Create subscription_plans table
        $table = $installer->getConnection()->newTable(
            $installer->getTable('md_subscription_plans')
        )->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Plan ID'
        )->addColumn(
            'name',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Plan Name'
        )->addColumn(
            'description',
            Table::TYPE_TEXT,
            '2M',
            ['nullable' => true],
            'Plan Description'
        )->addColumn(
            'minimum_deliveries',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false],
            'Minimum Deliveries'
        )->addColumn(
            'maximum_deliveries',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false],
            'Maximum Deliveries'
        )->addColumn(
            'delivery_frequency',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false],
            'Delivery Frequency (in months)'
        )->setComment('Subscription Plans');
        $installer->getConnection()->createTable($table);

        // Create subscriptions table
        $table = $installer->getConnection()->newTable(
            $installer->getTable('md_subscriptions')
        )->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Subscription ID'
        )->addColumn(
            'plan_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false],
            'Plan ID'
        )->addColumn(
            'main_order_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false],
            'Main Order ID'
        )->addColumn(
            'subscriber_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false],
            'Subscriber ID'
        )->addColumn(
            'subscriber_name',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Subscriber Name'
        )->addColumn(
            'subscriber_email',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Subscriber Email'
        )->addColumn(
            'start_date',
            Table::TYPE_DATE,
            null,
            ['nullable' => false],
            'Subscription Start Date'
        )->addColumn(
            'end_date',
            Table::TYPE_DATE,
            null,
            ['nullable' => false],
            'Subscription End Date'
        )->addColumn(
            'deliveries',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false],
            'Number of Deliveries'
        )->addColumn(
            'delivery_frequency',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false],
            'Delivery Frequency (in months)'
        )->addColumn(
            'is_canceled_by_customer',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => true],
            'Is Subscription canceled by customer'
        )->addColumn(
            'status',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false],
            'Subscription Status'
        )->addForeignKey(
            $installer->getFkName('md_subscriptions', 'plan_id', 'md_subscription_plans', 'id'),
            'plan_id',
            $installer->getTable('md_subscription_plans'),
            'id',
            Table::ACTION_CASCADE
        )->setComment('Subscriptions');
        $installer->getConnection()->createTable($table);

        // Create subscription_orders table
        $table = $installer->getConnection()->newTable(
            $installer->getTable('md_subscription_orders')
        )->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'ID'
        )->addColumn(
            'subscription_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false],
            'Subscription ID'
        )->addColumn(
            'order_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => true],
            'Order ID'
        )->addColumn(
            'delivery_date',
            Table::TYPE_DATE,
            null,
            ['nullable' => false],
            'Delivery Date'
        )->addColumn(
            'status',
            Table::TYPE_TEXT,
            20,
            ['nullable' => false],
            'Order Status'
        )->addForeignKey(
            $installer->getFkName('md_subscription_orders', 'subscription_id', 'md_subscriptions', 'id'),
            'subscription_id',
            $installer->getTable('md_subscriptions'),
            'id',
            Table::ACTION_CASCADE
        )->setComment('Subscription Orders');
        $installer->getConnection()->createTable($table);

        // Create subscription_payments table
        $table = $installer->getConnection()->newTable(
            $installer->getTable('md_subscription_payments')
        )->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Payment ID'
        )->addColumn(
            'subscription_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false],
            'Subscription ID'
        )->addColumn(
            'payment_date',
            Table::TYPE_DATE,
            null,
            ['nullable' => false],
            'Payment Date'
        )->addColumn(
            'amount',
            Table::TYPE_DECIMAL,
            '12,4',
            ['nullable' => false],
            'Payment Amount'
        )->addColumn(
            'status',
            Table::TYPE_TEXT,
            20,
            ['nullable' => false],
            'Payment Status'
        )->addForeignKey(
            $installer->getFkName('md_subscription_payments', 'subscription_id', 'md_subscriptions', 'id'),
            'subscription_id',
            $installer->getTable('md_subscriptions'),
            'id',
            Table::ACTION_CASCADE
        )->setComment('Subscription Payments');
        $installer->getConnection()->createTable($table);

        // Subscriptions item table
        $table = $installer->getConnection()->newTable(
            $installer->getTable('md_subscription_items')
        )->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'ID'
        )->addColumn(
            'subscription_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false],
            'Subscription ID'
        )->addColumn(
            'item_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false],
            'Item ID'
        )->addColumn(
            'price',
            Table::TYPE_DECIMAL,
            '12,4',
            ['nullable' => false],
            'Price'
        )->addForeignKey(
            $installer->getFkName('md_subscription_items', 'subscription_id', 'md_subscriptions', 'id'),
            'subscription_id',
            $installer->getTable('md_subscriptions'),
            'id',
            Table::ACTION_CASCADE
        )->setComment('Subscription Items');
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}