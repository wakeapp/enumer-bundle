<?php

declare(strict_types=1);

namespace Wakeapp\Bundle\EnumerBundle\Doctrine\Connection;

use Doctrine\Bundle\DoctrineBundle\ConnectionFactory;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Types\Type;
use Wakeapp\Bundle\EnumerBundle\Registry\EnumRegistryService;
use Wakeapp\Component\DbalEnumType\Type\AbstractEnumType;
use Wakeapp\Component\Enumer\EnumRegistry;

class ConnectionFactoryDecorator
{
    /**
     * @var EnumRegistry
     */
    private $enumRegistry;

    /**
     * @var ConnectionFactory
     */
    private $original;

    /**
     * @param ConnectionFactory $original
     * @param EnumRegistryService $enumRegistry
     */
    public function __construct(ConnectionFactory $original, EnumRegistryService $enumRegistry)
    {
        $this->enumRegistry = $enumRegistry;
        $this->original = $original;
    }

    /**
     * @param array $params
     * @param Configuration|null $config
     * @param EventManager|null $eventManager
     * @param array $mappingTypes
     *
     * @return Connection
     *
     * @throws DBALException
     */
    public function createConnection(
        array $params,
        ?Configuration $config = null,
        ?EventManager $eventManager = null,
        array $mappingTypes = []
    ): Connection {
        $connection = $this->original->createConnection($params, $config, $eventManager, $mappingTypes);

        foreach (Type::getTypesMap() as $typeName => $className) {
            $type = Type::getType($typeName);

            if (!$type instanceof AbstractEnumType) {
                continue;
            }

            $enumClass = $type::getEnumClass();

            if ($this->enumRegistry->hasEnum($enumClass)) {
                $type::setValues($this->enumRegistry->getOriginalList($enumClass));
            }
        }

        return $connection;
    }
}
