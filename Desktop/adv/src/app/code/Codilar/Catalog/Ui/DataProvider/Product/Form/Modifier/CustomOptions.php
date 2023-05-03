<?php

namespace Codilar\Catalog\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\CustomOptions as ExtendedCustomOptions;
use Magento\Ui\Component\Container;
use Magento\Ui\Component\Form\Element\DataType\Text;
use Magento\Ui\Component\Form\Element\Select;
use Magento\Ui\Component\Form\Field;
use Codilar\Catalog\Helper\Data;

class CustomOptions extends ExtendedCustomOptions
{

    const ATTENDEE_TYPE_TO_CHOOSE = 'attendee_type';

    /**
     * @param $sortOrder
     * @return array
     */
    protected function getCommonContainerConfig($sortOrder)
    {
        $commonContainer = [
            'arguments' => [
                'data' => [
                    'config' => [
                        'componentType' => Container::NAME,
                        'formElement' => Container::NAME,
                        'component' => 'Magento_Ui/js/form/components/group',
                        'breakLine' => false,
                        'showLabel' => false,
                        'additionalClasses' => 'admin__field-group-columns admin__control-group-equal',
                        'sortOrder' => $sortOrder,
                    ],
                ],
            ],
            'children' => [
                static::FIELD_OPTION_ID => $this->getOptionIdFieldConfig(10),
                static::FIELD_TITLE_NAME => $this->getTitleFieldConfig(
                    20,
                    [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'label' => __('Option Title'),
                                    'component' => 'Magento_Catalog/component/static-type-input',
                                    'valueUpdate' => 'input',
                                    'imports' => [
                                        'optionId' => '${ $.provider }:${ $.parentScope }.option_id',
                                        'isUseDefault' => '${ $.provider }:${ $.parentScope }.is_use_default'
                                    ]
                                ],
                            ],
                        ],
                    ]
                ),
                static::FIELD_TYPE_NAME => $this->getTypeFieldConfig(30),
                static::FIELD_IS_REQUIRE_NAME => $this->getIsRequireFieldConfig(40),
                static::ATTENDEE_TYPE_TO_CHOOSE => $this->getOptionTypeConfig(50)
            ]
        ];

        if ($this->locator->getProduct()->getStoreId()) {
            $useDefaultConfig = [
                'service' => [
                    'template' => 'Magento_Catalog/form/element/helper/custom-option-service',
                ]
            ];
            $titlePath = $this->arrayManager->findPath(static::FIELD_TITLE_NAME, $commonContainer, null)
                . static::META_CONFIG_PATH;
            $commonContainer = $this->arrayManager->merge($titlePath, $commonContainer, $useDefaultConfig);
        }

        return $commonContainer;
    }

    /**
     * @param $sortOrder
     * @return array[]
     */
    protected function getOptionTypeConfig($sortOrder)
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Attendee Type'),
                        'componentType' => Field::NAME,
                        'formElement' => Select::NAME,
                        'selectType' => 'option_title',
                        'dataScope' => static::ATTENDEE_TYPE_TO_CHOOSE,
                        'dataType' => Text::NAME,
                        'sortOrder' => $sortOrder,
                        'options' => [['label' => __('-- Please select --'), 'value' => ''],
                            ['label' => __('Live Webinar'), 'value' => Data::ONE_DIAL_ONE_ATTENDEE],
                            ['label' => __('Recorded Version'), 'value' => Data::RECORDED_VERSION],
                            ['label' => __('Recorded - USB Flash Drive'), 'value' => Data::RECORDED_USB_DRIVE]
                        ],
                        'disableLabel' => true,
                        'multiple' => false,
                        'selectedPlaceholders' => [
                            'defaultPlaceholder' => __('-- Please select --'),
                        ],
                        'validation' => [
                            'required-entry' => true
                        ],
                    ],
                ],
            ],
        ];
    }
}
