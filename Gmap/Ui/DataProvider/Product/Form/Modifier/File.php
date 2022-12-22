<?php
namespace Grc\Gmap\Ui\DataProvider\Product\Form\Modifier;

use Magento\Framework\Stdlib\ArrayManager;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
/**
 * Class File
 * @package Grc\Gmap\Model\Product\Attribute\Backend
 */
class File extends AbstractModifier
{
    /**
     * @var Magento\Framework\Stdlib\ArrayManager
     */
    protected $arrayManager;

    /**
     * @param ArrayManager $arrayManager
     */
    public function __construct(
        ArrayManager $arrayManager
    ) {
        $this->arrayManager = $arrayManager;
    }
    /**
     * function modifyMeta($array)
     */
    public function modifyMeta(array $meta)
    {
        $fieldCode = 'brochure';
        $elementPath = $this->arrayManager->findPath($fieldCode, $meta, null, 'children');
        $containerPath = $this->arrayManager->findPath(static::CONTAINER_PREFIX . $fieldCode, $meta, null, 'children');

        if (!$elementPath) {
            return $meta;
        }

        $meta = $this->arrayManager->merge(
            $containerPath,
            $meta,
            [
                'children'  => [
                    $fieldCode => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'elementTmpl'   => 'Grc_Gmap/elements/file',
                                ],
                            ],
                        ],
                    ]
                ]
            ]
        );
        return $meta;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data)
    {
        return $data;
    }
}