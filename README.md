# Aiods Core Package

Core backend components for the AIODS framework.

## Installation

```bash
composer require aiods/core
```

## Features

### CRUD Operations
- **CrudService** - Main CRUD orchestration service
- **QueryBuilder** - Filter, search, and sort queries
- **PaginationService** - Handle pagination

### Authorization
- **PermissionService** - Check user permissions
- **PermissionRepository** - Repository pattern for permissions
- **PermissionCache** - Cache permissions

### Settings
- **SettingsService** - Manage application settings
- **SettingsRepository** - Repository pattern
- **SettingsCache** - Cache settings

### Menu
- **MenuService** - Manage menu items
- **MenuRepository** - Repository pattern
- **MenuCache** - Cache menus

### File Management
- **FileService** - Handle file uploads
- **FileUploadValidator** - Validate file uploads

### Search
- **GlobalSearchService** - Global search functionality
- **Searchable** - Trait for searchable models

### Audit
- **AuditLogger** - Log actions
- **Auditable** - Trait for auditable models

## Usage

### CRUD Service

```php
use Aiods\Core\CRUD\CrudService;

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

    public function store(Request $request)
    {
        $user = $this->crudService->store(new User(), $request->validated());
        
        return response()->json($user, 201);
    }
}
```

### Query Builder

```php
use Aiods\Core\CRUD\QueryBuilder;

$queryBuilder = new QueryBuilder();

// Apply filters
$query = $queryBuilder->applyFilters($query, [
    'status' => 'active',
    'role_id' => [1, 2, 3]
]);

// Apply search
$query = $queryBuilder->applySearch($query, 'john', ['name', 'email']);

// Apply sorting
$query = $queryBuilder->applySorting($query, 'created_at', 'desc');
```

### Permission Service

```php
use Aiods\Core\Authorization\PermissionService;

class PostController extends Controller
{
    public function __construct(
        private readonly PermissionService $permissionService
    ) {}

    public function edit(User $user, Post $post)
    {
        if (!$this->permissionService->userCan($user, 'posts.edit')) {
            abort(403);
        }

        // ...
    }
}
```

## Package Structure

```
src/
├── CRUD/
│   ├── CrudService.php
│   ├── QueryBuilder.php
│   └── PaginationService.php
├── Authorization/
│   ├── PermissionService.php
│   ├── PermissionRepository.php
│   └── PermissionCache.php
├── Settings/
│   ├── SettingsService.php
│   ├── SettingsRepository.php
│   └── SettingsCache.php
├── Menu/
│   ├── MenuService.php
│   ├── MenuRepository.php
│   └── MenuCache.php
├── File/
│   └── FileService.php
├── Search/
│   ├── GlobalSearchService.php
│   └── Searchable.php
└── Audit/
    ├── AuditLogger.php
    └── Auditable.php
```

## Requirements

- PHP ^8.2
- Laravel ^12.0
- spatie/laravel-permission ^6.0

## License

MIT

