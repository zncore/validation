<?php

namespace ZnCore\Validation\Helpers;

use ZnCore\Validation\Entities\ValidationErrorEntity;
use ZnCore\Validation\Exceptions\UnprocessibleEntityException;
use ZnCore\Collection\Libs\Collection;

class UnprocessableHelper
{

    public static function throwItem(string $field, string $mesage): void
    {
        $errorCollection = new Collection();
        $validationErrorEntity = new ValidationErrorEntity($field, $mesage);
        $errorCollection->add($validationErrorEntity);
        throw new UnprocessibleEntityException($errorCollection);
    }

    public static function throwItems(array $errorArray): void
    {
        $errorCollection = ErrorCollectionHelper::flatArrayToCollection($errorArray);
        throw new UnprocessibleEntityException($errorCollection);
    }
}
