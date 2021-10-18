<?php

namespace Yudiz\Freelancer\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;

        $installer->startSetup();

        /*
         * Create table 'freelancer_profile'
         */

        $table = $installer->getConnection()->newTable(
            $installer->getTable('freelancer_profile')
        )->addColumn(
            'entity_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [
                'identity' => true,
                'nullable' => false,
                'primary' => true,
                'unsigned' => true
            ],
            'Freelancer Id'
        )->addColumn(
            'user_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true],
            'Customer/User Id'
        )->addColumn(
            'profile_image',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Profile Image'
        )->addColumn(
            'slug',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '255',
            ['nullable' => false],
            'slug'
        )->addColumn(
            'full_name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Full Name'
        )->addColumn(
            'email_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [
                'nullable' => true,
                'default' => null
            ],
            'Email Id'
        )->addColumn(
            'mobile_number',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Mobile Number'
        )->addColumn(
            'location_details',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '2M',
            ['nullable' => false],
            'Location Details'
        )->addColumn(
            'skill_details',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '2M',
            ['nullable' => false],
            'Skill Details'
        )->addColumn(
            'summary_details',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '2M',
            ['nullable' => false],
            'summary Details'
        )->addColumn(
            'is_active',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '1'],
            'Active Status'
        )->addColumn(
            'created_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            [
                'nullable' => false,
                'on_update' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT,
            ],
            'Creation Time'
        )->addColumn(
            'updated_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            [
                'nullable' => false,
                'on_update' => true,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE
            ],
            'Updated At'
        )->addIndex(
            $installer->getIdxName('freelancer_profile', ['user_id']),
            ['user_id']
        )->addForeignKey(
            $installer->getFkName('freelancer_profile', 'user_id', 'customer_entity', 'entity_id'),
            'user_id',
            $installer->getTable('customer_entity'),
            'entity_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_SET_NULL
        )->setComment('Freelancer Data Table');

        $installer->getConnection()->createTable($table);

        $installer->getConnection()->addIndex(
            $installer->getTable('freelancer_profile'),
            $setup->getIdxName(
                $installer->getTable('freelancer_profile'),
                ['full_name', 'email_id', 'mobile_number', 'location_details', 'skill_details', 'summary_details'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            ['full_name', 'email_id', 'mobile_number', 'location_details', 'skill_details', 'summary_details'],
            \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
        );

        /**
        * Create table 'freelancer_images'
        */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('freelancer_images')
        )->addColumn(
            'entity_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [
                'identity' => true,
                'nullable' => false,
                'primary' => true,
                'unsigned' => true
            ],
            'Freelancer ID'
        )->addColumn(
            'freelancer_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true],
            'Freelancer Id'
        )->addColumn(
            'multiple_image',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Multiple Image'
        )->addIndex(
            $installer->getIdxName('freelancer_images', ['freelancer_id']),
            ['freelancer_id']
        )->addForeignKey(
            $installer->getFkName('freelancer_images', 'freelancer_id', 'freelancer_profile', 'entity_id'),
            'freelancer_id',
            $installer->getTable('freelancer_profile'),
            'entity_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Freelancer Profile Multiple Images Table'
        );
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
