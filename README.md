Enumer Bundle
=============

Введение
--------

Бандл предоставляет возможность подключения компонента enumer

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

Чтобы начать использовать бандл требуется предварительная конфигурация.
Необходимо зарегистрировать все enum в конфигураци:

```yaml
# app/config.yml
wakeapp_enumer:
    enum_class:
        - WakeCent\BaseCommonBundle\Enum\CampaignStateEnum
```

Лицензия
--------

[![license](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)](./LICENSE)
