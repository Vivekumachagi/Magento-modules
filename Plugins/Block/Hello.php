<?php

namespace Vivek\Plugins\Block;

class Hello extends \Magento\Framework\View\Element\Template
{

    public function getText()
    {
        return "Hello World";
    }

    public function number()
    {
        return "1234567890";
    }
}
