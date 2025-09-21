<?php

namespace Kaliop\IbexaMigrationBundle\Core\FieldHandler;

use Kaliop\IbexaMigrationBundle\API\FieldDefinitionConverterInterface;
use Kaliop\IbexaMigrationBundle\API\FieldValueConverterInterface;

/**
 * @todo make fieldSettings independent from version of ibexa_matrix in use, by converting them from a common format
 */
class EzMatrix extends AbstractFieldHandler implements FieldValueConverterInterface
{
    public function hashToFieldValue($fieldValue, array $context = array())
    {
        /// @todo resolve refs ?

        $rows = array();
        foreach ($fieldValue as $data) {
            $rows[] = new \Ibexa\FieldTypeMatrix\FieldType\Value\Row($data);
        }
        return new \Ibexa\FieldTypeMatrix\FieldType\Value($rows);
}

    public function fieldValueToHash($fieldValue, array $context = array())
    {
        $data = array();

        foreach ($fieldValue->getRows() as $row) {
            $data[] = $row->getCells();
        }

        return $data;
    }
}
