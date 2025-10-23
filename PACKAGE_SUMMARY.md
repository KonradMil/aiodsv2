# Aiods Core Composer Package

## Overview

Created a Composer package `aiods/core` that packages the core backend PHP components for reuse across projects.

## Package Structure

```
packages/aiods/core/
├── composer.json              # Package configuration
├── README.md                  # Package documentation
└── src/
    ├── CRUD/
    │   ├── CrudService.php
    │   ├── QueryBuilder.php
    │   └── PaginationService.php
    ├── Authorization/
    │   ├── PermissionService.php
    │   ├── PermissionRepository.php
    │   ├── PermissionRepositoryImpl.php
    │   ├── PermissionCache.php
    │   └── PermissionCacheImpl.php
    ├── Settings/
    │   ├── SettingsService.php
    │   ├── SettingsRepository.php
    │   ├── SettingsRepositoryImpl.php
    │   ├── SettingsCache.php
    │   ├── SettingsCacheImpl.php
    │   ├── Setting.php
    │   └── SettingType.php
    ├── Menu/
    │   ├── MenuService.php
    │   ├── MenuRepository.php
    │   ├── MenuRepositoryImpl.php
    │   ├── MenuCache.php
    │   ├── MenuCacheImpl.php
    │   └── MenuItem.php
    ├── File/
    │   └── FileService.php
    ├── Search/
    │   ├── GlobalSearchService.php
    │   └── Searchable.php
    ├── Security/
    │   └── FileUploadValidator.php
    ├── Audit/
    │   ├── AuditLogger.php
    │   ├── Auditable.php
    │   ├── AuditEvent.php
    │   └── AuditLogQuery.php
    ├── Auth/
    │   ├── AuthenticationService.php
    │   ├── SessionManager.php
    │   └── TwoFactorService.php
    └── Translation/
```

## Installation

### Development Setup

1. Add to main `composer.json`:
```json
{
    "repositories": [
        {
            "type": "path",
            "url": "./packages/aiods/core"
        }
    ],
    "require": {
        "aiods/core": "*"
    }
}
```

2. Install:
```bash
composer install
```

### Publishing to Packagist

To publish as a public package:

```bash
cd packages/aiods/core
composer publish
```

Or manually:

1. Create a repository on GitHub
2. Tag releases
3. Submit to Packagist

## Usage

### In Your Laravel Application

After installation, update your Service Providers to use the package classes:

```php
// app/Providers/AppServiceProvider.php
use Aiods\Core\CRUD\CrudService;
use Aiods\Core\CRUD\QueryBuilder;
use Aiods\Core\CRUD\PaginationService;

public function register(): void
{
    $this->app->singleton(QueryBuilder::class);
    $this->app->singleton(PaginationService::class);
    $this->app->singleton(CrudService::class);
}
```

### Using CRUD Service

```php
use Aiods\Core\CRUD\CrudService;
use App\Models\User;

class UserController extends Controller
{
    public function __construct(
        private readonly CrudService $crudService
    ) {}

    public function index(Request $request)
    {
        $query = User::query();
        
        $params = [
            'filters' => $request->only(['status', 'role']),
            'search' => $request->get('search'),
            'search_fields' => ['name', 'email'],
            'sort' => $request->get('sort', 'id'),
            'direction' => $request->get('direction', 'asc'),
            'per_page' => 15
        ];

        $users = $this->crudService->index($query, $params);

        return response()->json($users);
    }
}
```

## Key Components

### CRUD Operations
- **CrudService** - Orchestrates CRUD operations
- **QueryBuilder** - Filter, search, and sort queries
- **PaginationService** - Handle pagination

### Authorization
- **PermissionService** - Check user permissions
- Uses Spatie Laravel Permission package

### Settings
- **SettingsService** - Manage application settings
- Cached settings with repository pattern

### Menu
- **MenuService** - Manage menu items
- Hierarchical menu support

### File Management
- **FileService** - Handle file uploads
- **FileUploadValidator** - Validate uploads

### Search
- **GlobalSearchService** - Global search
- **Searchable** - Trait for searchable models

### Audit
- **AuditLogger** - Log actions
- **Auditable** - Trait for auditable models

## Benefits

1. **Reusability** - Share core components across projects
2. **Consistency** - Same patterns everywhere
3. **Maintainability** - Single source of truth
4. **Testing** - Test independently
5. **Versioning** - Semantic versioning
6. **Documentation** - Package-level docs

## Next Steps

1. Copy remaining PHP files from `app/Core/` to `packages/aiods/core/src/`
2. Update namespaces from `App\Core\` to `Aiods\Core\`
3. Create Service Provider for the package
4. Add tests
5. Update main app to use package
6. Publish to Packagist (optional)

## Files Created

- `packages/aiods/core/composer.json`
- `packages/aiods/core/README.md`
- `packages/aiods/core/src/CRUD/CrudService.php`
- `packages/aiods/core/src/CRUD/QueryBuilder.php`
- `packages/aiods/core/src/CRUD/PaginationService.php`

## Summary

Successfully created a Composer package structure for the PHP backend components. The package can be installed locally or published to Packagist for use across multiple Laravel projects.

