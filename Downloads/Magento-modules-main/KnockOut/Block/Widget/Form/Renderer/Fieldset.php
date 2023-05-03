<?php
/**
 * @author Vendor
 * @copyright Copyright (c) 2021 Vendor
 * @package Vendor_CustomModule
 */

namespace Vivek\KnockOut\Block\Widget\Form\Renderer;


class Fieldset extends \Magento\Backend\Block\Widget\Form\Renderer\Fieldset
{
    protected $_template = 'Vivek_KnockOut::widget/form/renderer/fieldset.phtml';

    public function getRelationJson()
    {
        $depends = $this->getElement()->getData('depends');
        if (!$depends) {
            return '';
        }
        foreach ($depends as &$relation) {
            $relation['parent_attribute_element_uid'] = $this->getJsId(
                'form-field',
                $relation['parent_attribute_code']
            );
            $relation['depend_attribute_element_uid'] = $this->getJsId(
                'form-field',
                $relation['depend_attribute_code']
            );
        }
        $this->getElement()->setData('depends', $depends);

        return $this->getElement()->convertToJson(['depends']);
    }
}
