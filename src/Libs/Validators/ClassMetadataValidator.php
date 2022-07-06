<?php

namespace ZnCore\Validation\Libs\Validators;

use ZnCore\Validation\Helpers\SymfonyValidationHelper;
use ZnCore\Validation\Interfaces\ValidationByMetadataInterface;
use ZnCore\Validation\Interfaces\ValidatorInterface;

class ClassMetadataValidator extends BaseValidator implements ValidatorInterface
{

    public function validateEntity(object $entity): void
    {
        $errorCollection = SymfonyValidationHelper::validate($entity);
        $this->handleResult($errorCollection);
    }

    public function isMatch(object $entity): bool
    {
        return $entity instanceof ValidationByMetadataInterface;
    }
}
