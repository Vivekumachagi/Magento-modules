<?php 

namespace Grc\Corporatetraining\Model\Source;

class Industry implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Retrieve options array.
     *
     * @return array
     */
    public function toOptionArray()
    {
        $result = [];

        foreach (self::getOptionArray() as $index => $value) {
            $result[] = ['value' => $index, 'label' => $value];
        }

        return $result;
    }

    /**
     * Retrieve option array
     *
     * @return string[]
     */
    public static function getOptionArray()
    {
        return [1 => __('Pharmaceuticals'), 2 => __('Medical Devices'), 3 => __('Biotechnology'), 4 => __('Clinical Trials & Research'), 5 => __('Healthcare Compliance'), 6 => __('Food Safety & Dietary Supplement'), 7 => __('Lab Compliance Life Sciences'), 8 => __('Human Resource (HR)'), 9 => __('Banking & Finance Services (BFSI)'), 10 => __('Finance'), 11 => __('Not Specified')];
    }

    /**
     * Retrieve option array with empty value
     *
     * @return string[]
     */
    public function getAllOptions()
    {
        $result = [];

        foreach (self::getOptionArray() as $index => $value) {
            $result[] = ['value' => $index, 'label' => $value];
        }

        return $result;
    }

    /**
     * Retrieve option text by option value
     *
     * @param string $optionId
     * @return string
     */
    public function getOptionText($optionId)
    {
        $options = self::getOptionArray();

        return isset($options[$optionId]) ? $options[$optionId] : null;
    }
}