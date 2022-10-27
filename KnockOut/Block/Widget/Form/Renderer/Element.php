<?php
/**
 * @author Vendor
 * @copyright Copyright (c) 2021 Vendor
 * @package Vendor_CustomModule
 */


namespace Vivek\KnockOut\Block\Widget\Form\Renderer;

use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * @SuppressWarnings(PHPMD.DepthOfInheritance)
 */
class Element extends \Magento\Backend\Block\Widget\Form\Renderer\Fieldset\Element
{
    /**
     * Initialize block template
     */
    protected $_template = 'Vivek_knockOut::widget/form/renderer/fieldset/element.phtml';
    /**
     * @var Validation
     */
    private $validation;

    /**
     * Element constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $html = parent::render($element);
        return $html;
    }
}
