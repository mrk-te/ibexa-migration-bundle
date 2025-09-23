<?php

namespace Kaliop\eZMigrationBundle\Core\FieldHandler;

use Ibexa\Core\FieldType\ImageAsset\Value;
use Kaliop\eZMigrationBundle\API\FieldValueImporterInterface;
use Kaliop\eZMigrationBundle\Core\Matcher\ContentMatcher;

class EzImageAsset extends AbstractFieldHandler implements FieldValueImporterInterface
{
    protected $contentMatcher;

    public function __construct(ContentMatcher $contentMatcher)
    {
        $this->contentMatcher = $contentMatcher;
    }

    /**
     * Creates a value object to use as the field value when setting an ez relation field type.
     *
     * @param array|string|int $fieldValue The definition of the field value, structured in the yml file
     * @param array $context The context for execution of the current migrations. Contains f.e. the path to the migration
     * @return Value
     */
    public function hashToFieldValue($fieldValue, array $context = array())
    {
        $id = null;
        $alternativeText = null;
        if (is_array($fieldValue)) {
            if (array_key_exists('destinationContentId', $fieldValue)) {
                $id = $fieldValue['destinationContentId'];
            }
            if (array_key_exists('alternativeText', $fieldValue)) {
                $alternativeText = $fieldValue['alternativeText'];
            }
        } elseif (!empty($fieldValue)) {
            // simplified format
            $id = $fieldValue;
        }

        if ($id === null) {
            return new Value();
        }

        // 1. resolve relations
        // NB: this might result in double reference-resolving when the original value is a string, given preResolveReferences...
        $id = $this->referenceResolver->resolveReference($id);
        // 2. resolve remote ids
        $id = $this->contentMatcher->matchOneByKey($id)->id;

        return new Value($id, $alternativeText);
    }
}
