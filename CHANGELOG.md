## [1.1.0] - 2019-05-17
### Added
- Added possibility for register classes without `EnumerInterface` implementation.
- Added configuration `wakeapp_enumer.source_classes`.
- Added `EnumRegistryService::hasEnum` method.
### Fixed
- Fixed deprecation `symfony/config` since 4.2

## [1.0.0] - 2018-11-16
## Added
- Added `EnumRegistryService` and appropriated service `wakeapp_enumer.enum_registry`.
- Added `LICENSE` file and information about license in every file.
### Changed
- Enum building executed at the container compiling instead runtime.
- Removed redundant class comments.
- Changed bundle configuration: removed `wakeapp_enumer.enum_class` and added `wakeapp_enumer.source_directories`.
### Removed
- Removed `EnumerFactory` and appropriated service `wakeapp_enumer.enumer`.
- Removed `EnumerAwareTrait` and added `EnumRegistryAwareTrait` instead.
### Fixed
- Fixed `PSR-2` code style.

## [0.1.3] - 2018-10-18
### Fixed
- Method `EnumerFactory::create()` to static.
- Add return type Enumer.

## [0.1.2] - 2018-10-05
### Fixed
- Fix trait namespace.

## [0.1.1] - 2018-10-05
### Fixed
- Fix bug namespace.

## [0.1.0] - 2018-10-04
### Added
- First release of this bundle.
