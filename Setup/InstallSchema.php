<?php

/**
 * Copyright 2019 Newgen Payment Gateway Pvt. Ltd. All rights reserved.
 * Distribution of this software without explicit written consent from Newgen is
 * strictly prohibited. No part of this software must not be reverse engineered,
 * copied, reproduced or modified.
 */

namespace Boostsales\CustomCheckout\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $installer, ModuleContextInterface $context)
    {
        $update = $installer->getConnection();
        
        $update->addColumn(
                $installer->getTable('quote'),
                'checkout_invoice_email',
                array(
                    'type' =>\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' => 'Custom checkout invoice email'
                ) 
        );
        $update->addColumn(
            $installer->getTable('quote'),
            'po_number',
            array(
                'type' =>\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 255,
                'comment' => 'PO Number'
            ) 
        );
        $update->addColumn(
            $installer->getTable('sales_order'),
            'checkout_invoice_email',
            array(
                'type' =>\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 255,
                'comment' => 'Custom checkout invoice email'
            ) 
        );
        $update->addColumn(
            $installer->getTable('sales_order'),
            'po_number',
            array(
                'type' =>\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 255,
                'comment' => 'PO Number'
            ) 
        );
        $installer->endSetup();
    }
    
}
