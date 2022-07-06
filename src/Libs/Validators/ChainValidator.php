<?php

namespace ZnCore\Validation\Libs\Validators;

use Psr\Container\ContainerInterface;
use ZnCore\Container\Traits\ContainerAwareAttributeTrait;
use ZnCore\Base\Instance\Libs\Resolvers\InstanceResolver;
use ZnCore\Validation\Interfaces\ValidatorInterface;
use ZnCore\Collection\Interfaces\Enumerable;
use ZnCore\Collection\Libs\Collection;

class ChainValidator implements ValidatorInterface
{

    use ContainerAwareAttributeTrait;

    /** @var Enumerable | ValidatorInterface[] */
    private $validators = [];

    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    public function setValidators(array $validators): void
    {
        $instances = new Collection();
        $instanceResolver = new InstanceResolver($this->getContainer());
        foreach ($validators as $validatorDefinition) {
            $validatorInstance = $instanceResolver->ensure($validatorDefinition);
            $instances->add($validatorInstance);
        }
        $this->validators = $instances;
    }

    public function validateEntity(object $entity): void
    {
        foreach ($this->validators as $validatorInstance) {
            if ($validatorInstance->isMatch($entity)) {
                $validatorInstance->validateEntity($entity);
            }
        }
    }

    public function isMatch(object $entity): bool
    {
        return true;
    }
}
