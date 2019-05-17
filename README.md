Enumer Bundle
=============

[![Latest Stable Version](https://poser.pugx.org/wakeapp/enumer-bundle/v/stable)](https://packagist.org/packages/wakeapp/enumer-bundle)
[![Total Downloads](https://poser.pugx.org/wakeapp/enumer-bundle/downloads)](https://packagist.org/packages/wakeapp/enumer-bundle)

Введение
--------

Бандл предоставляет возможность использовать любой класс с константами в качестве `ENUM`.

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
<?php declare(strict_types=1);
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
wakeapp_enumer:
    # список директорий, в которых будет происходить поиск классов, реализующих EnumInterface
    source_directories:
        - 'src'
    # список классов, которые следует зарегистрировать вне зависимости от реализации EnumInterface
    source_classes: ~
``` 

Использование
-------------

Чтобы зарегистрировать класс, содержащий константные значения, и использовать его в качестве `enum` - необходимо
добавить реализацию [EnumInterface](./Enum/EnumInterface.php).

```php
<?php declare(strict_types=1);

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
<?php declare(strict_types=1);

namespace Example;

use Acme\Enum\GenderEnum;
use Symfony\Component\DependencyInjection\Container;

/** @var Container $container */
$enumerRegistry = $container->get('wakeapp_enumer.enum_registry');

$list = $enumerRegistry->getOriginalList(GenderEnum::class); 
echo json_encode($list);// {"MALE":"Male","FEMALE":"Female"}

$listCombine = $enumerRegistry->getCombinedList(GenderEnum::class); 
echo json_encode($listCombine); // {"Male":"Male","Female":"Female"}

$normalizedList = $enumerRegistry->getNormalizedList(GenderEnum::class); 
echo json_encode($normalizedList); // {"male":"Male","female":"Female"}

$originalValue = $enumerRegistry->getOriginalValue(GenderEnum::class, 'FemALE'); 
echo $originalValue; // 'Female'
```

Дополнительно
-------------

### Ручная регистрация класса с константами

Допустим у нас есть класс из vendor, который содержит константы и нам необходимо его зарегистрировать.

```php
<?php declare(strict_types=1);

namespace Vendor\Acme\Enum;

class VendorGenderEnum
{
    const MALE = 'Male';
    const FEMALE = 'Female';
}
```

Чтобы зарегистрировать этот класс необходимо добавить его в массив `source_classes`:

```yaml
wakeapp_enumer:
    source_classes:
        - Vendor\Acme\Enum\VendorGenderEnum
``` 

Лицензия
--------

[![license](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)](./LICENSE)
