<?php

declare(strict_types=1);

namespace MicroModule\Common\Domain\ValueObject;

use MicroModule\ValueObject\Structure\Dictionary;
use SplFixedArray;

class FindCriteria extends Dictionary
{
    protected const KEYS_TO_EXCLUDE = [
        'version',
    ];

    public function __construct(SplFixedArray $keyValuePairs)
    {
        parent::__construct($this->excludeKeys($keyValuePairs));
    }

    /**
     * Exclude default keys from the criteria
     *
     * @todo Need refactor
     * @todo It looks creepy
     */
    protected function excludeKeys(SplFixedArray $keyValuePairs): SplFixedArray
    {
        $filteredArray = new SplFixedArray($keyValuePairs->getSize());
        $i = 0;

        foreach ($keyValuePairs as $value) {
            if (in_array($value->getKey()->toNative(), self::KEYS_TO_EXCLUDE, true)) {
                continue;
            }

            $filteredArray->offsetSet($i++, $value);
        }

        $filteredArray->setSize($i);

        return $filteredArray;
    }
}
