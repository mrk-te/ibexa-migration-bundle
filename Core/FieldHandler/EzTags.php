<?php

namespace Kaliop\IbexaMigrationBundle\Core\FieldHandler;

use Kaliop\IbexaMigrationBundle\API\Exception\InvalidStepDefinitionException;
use Kaliop\IbexaMigrationBundle\API\FieldValueImporterInterface;
use Kaliop\IbexaMigrationBundle\Core\Matcher\TagMatcher;

class EzTags extends AbstractFieldHandler implements FieldValueImporterInterface
{
    protected $tagMatcher;

    public function __construct(TagMatcher $tagMatcher)
    {
        $this->tagMatcher = $tagMatcher;
    }

    /**
     * Creates a value object to use as the field value when setting an eztags field type.
     *
     * @param array $fieldValue
     * @param array $context The context for execution of the current migrations. Contains f.e. the path to the migration
     * @return \Netgen\TagsBundle\Core\FieldType\Tags\Value
     * @throws \Exception
     */
    public function hashToFieldValue($fieldValue, array $context = array())
    {
        $tags = array();
        foreach ($fieldValue as $def)
        {
            if (!is_array($def) || count($def) != 1) {
                throw new InvalidStepDefinitionException('Definition of EzTags field is incorrect: each element of the tags array must be an array with one element');
            }

            # @todo support single-value elements too? if numeric, it is a tag id, if it is a string it is... what?
            #       it could be either a tag's remote id or a keyword...

            $identifier = reset($def);
            $type = key($def);

            $identifier = $this->referenceResolver->resolveReference($identifier);

            foreach ($this->tagMatcher->match(array($type => $identifier)) as $id => $tag) {
                $tags[$id] = $tag;
            }
        }

        return new \Netgen\TagsBundle\Core\FieldType\Tags\Value(array_values($tags));
    }
}
