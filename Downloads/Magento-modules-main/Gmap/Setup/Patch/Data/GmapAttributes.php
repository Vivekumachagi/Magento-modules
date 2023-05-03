<?php
namespace Grc\Gmap\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Catalog\Model\ResourceModel\Product as ResourceProduct;

/**
 * Class GmapAttributes
 * @package Grc\Gmap\Setup\Patch\Data
 */
class GmapAttributes implements DataPatchInterface
{
    protected $_attributeSet;
    protected $_resourceProduct;
    /**
     * @var ModuleDataSetupInterface
     */
    private $_moduleDataSetup;
    /**
     * @var EavSetupFactory
     */
    private $_eavSetupFactory;
    /**
     * GmapAttributes constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        AttributeSet $attributeSet,
        ResourceProduct $resourceProduct
    ) {
        $this->_moduleDataSetup = $moduleDataSetup;
        $this->_eavSetupFactory = $eavSetupFactory;
        $this->_attributeSet    = $attributeSet;
        $this->_resourceProduct = $resourceProduct;
    }
    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->_eavSetupFactory->create(['setup' => $this->_moduleDataSetup]);
        /* Latitude attribute */
        $eavSetup->addAttribute(\Magento\Catalog\Model\Product::ENTITY, 'gmap_latitude', [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Latitude',
            'input' => 'text',
            'class' => 'gmap_lat_class',
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'user_defined' => false,
            'default' => '',
            'searchable' => false,
            'filterable' => false,
            'comparable' => false,
            'visible_on_front' => false,
            'used_in_product_listing' => true,
            'unique' => false,
        ]);

        /* Longitude attribute */
        $eavSetup->addAttribute(\Magento\Catalog\Model\Product::ENTITY, 'gmap_longitude', [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Longitude',
            'input' => 'text',
            'class' => 'gmap_long_class',
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'user_defined' => false,
            'default' => '',
            'searchable' => false,
            'filterable' => false,
            'comparable' => false,
            'visible_on_front' => false,
            'used_in_product_listing' => true,
            'unique' => false,
        ]);

        /* Image attribute */
        $eavSetup->addAttribute(\Magento\Catalog\Model\Product::ENTITY, 'hotel_image', [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => 'Magento\Catalog\Model\Product\Attribute\Frontend\Image',
            'label' => 'Hotel Image',
            'input' => 'media_image',
            'class' => 'hotel_image_class',
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'user_defined' => false,
            'default' => '',
            'searchable' => false,
            'filterable' => false,
            'comparable' => false,
            'visible_on_front' => false,
            'used_in_product_listing' => true,
            'unique' => false,
        ]);

        /* Route direction attribute */
        $eavSetup->addAttribute(\Magento\Catalog\Model\Product::ENTITY, 'route_direction', [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Route Direction',
            'input' => 'text',
            'class' => 'route_direction_class',
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'user_defined' => false,
            'default' => '',
            'searchable' => false,
            'filterable' => false,
            'comparable' => false,
            'visible_on_front' => false,
            'used_in_product_listing' => true,
            'unique' => false,
        ]);

        /* Brochure attribute */

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'brochure',
            [
                'group' => 'Product Details',
                'type' => 'varchar',
                'label' => 'Brochure',
                'input' => 'file',
                'backend' => 'Grc\Gmap\Model\Product\Attribute\Backend\File',
                'frontend' => '',
                'class' => '',
                'source' => '',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => '',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => false,
                'unique' => false,
                'apply_to' => 'simple,configurable', // applicable for simple and configurable product
                'used_in_product_listing' => false
            ]
        );
        // assign attribute to attribute set
        $entityType = $this->_resourceProduct->getEntityType();
        $attributeSetCollection = $this->_attributeSet->setEntityTypeFilter($entityType);
        foreach ($attributeSetCollection as $attributeSet) {
            $eavSetup->addAttributeToSet("catalog_product", $attributeSet->getAttributeSetName(), "General", "brochure");
        }

    }
    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }
    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
    /**
     * {@inheritdoc}
     */
    public static function getVersion()
    {
        return '1.0.0';
    }
}
