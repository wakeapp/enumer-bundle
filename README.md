Enumer Bundle
=============

Введение
--------

Бандл предоставляет возможность подключения компонента [Enumer](https://github.com/wakeapp/enumer).
Предоставляет возможность использовать любой класс с константами в качесте `ENUM`.

Главной особенностью является уход от работы с рефлексией во время исполнения. Данная оптимизация достигается
благодаря сбору всех данных о константах классов на этапе компиляции контейнера.

Установка
---------

### Шаг 1: Загрузка бандла

Откройте консоль и, перейдя в директорию проекта, выполните следующую команду для загрузки наиболее подходящей
стабильной версии этого бандла:

```bash
    composer require wakeapp/enumer-bundle
```
*Эта команда подразумевает что [Composer](https://getcomposer.org) установлен и доступен глобально.*

### Шаг 2: Подключение бандла

После включите бандл добавив его в список зарегистрированных бандлов в `app/AppKernel.php` файл вашего проекта:

```php
<?php
// app/AppKernel.php

class AppKernel extends Kernel
{
    // ...

    public function registerBundles()
    {
        $bundles = [
            // ...

            new Wakeapp\Bundle\EnumerBundle\WakeappEnumerBundle(),
        ];

        return $bundles;
    }

    // ...
}
```

Конфигурация
------------

Чтобы начать использовать бандл предварительная конфигурация **не** требуется и имеет следующее значение по умолчанию:

```yaml
# app/config.yml
wakeapp_enumer:
    source_directories: # список директорий, в которых будет происходить поиск классов, реализующий EnumInterface
        - 'src'
``` 

Использование
-------------

Чтобы зарегистрировать класс, содержащий константные значения, и использовать его в качесте `enum` - необходимо
добавить реализацию [EnumInterface](./Enum/EnumInterface.php).

```php
<?php

namespace Acme\Enum;

use Wakeapp\Bundle\EnumerBundle\Enum\EnumInterface;

class GenderEnum implements EnumInterface
{
    const MALE = 'Male';
    const FEMALE = 'Female';
}
```

Все классы, реализующие [EnumInterface](./Enum/EnumInterface.php), будут доступны для работы с ними в сервисе
`wakeapp_enumer.enum_registry` (также сервис доступен при вызове посредством `autowire`). 

```php
<?php

namespace Example;

use Acme\Enum\GenderEnum;
use Symfony\Component\DependencyInjection\Container;

/** @var Container $container */
$enumerRegistry = $container->get('wakeapp_enumer.enum_registry');

$list = $enumerRegistry->getOriginalList(GenderEnum::class); // {"MALE":"Male","FEMALE":"Female"}
$listCombine = $enumerRegistry->getCombinedList(GenderEnum::class); // {"Male":"Male","Female":"Female"}
$listCombine = $enumerRegistry->getNormalizedList(GenderEnum::class); // {"male":"Male","female":"Female"}
$originalValue = $enumerRegistry->getOriginalValue(GenderEnum::class, 'FemALE'); // 'Female'
```

Лицензия
--------

[![license](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)](./LICENSE)
