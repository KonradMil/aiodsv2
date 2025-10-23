<?php

declare(strict_types=1);

namespace Aiods\Core\CRUD;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * CRUD Service
 *
 * Main service for CRUD operations.
 * Orchestrates QueryBuilder and PaginationService.
 */
final class CrudService
{
	public function __construct(
		private readonly QueryBuilder $queryBuilder,
		private readonly PaginationService $pagination
	) {}

	/**
	 * Get paginated index results
	 *
	 * @param  Builder  $query
	 * @param  array<string, mixed>  $params
	 * @return LengthAwarePaginator
	 */
	public function index(Builder $query, array $params = []): LengthAwarePaginator
	{
		// Apply filters
		if (isset($params['filters'])) {
			$query = $this->queryBuilder->applyFilters($query, $params['filters']);
		}

		// Apply search
		if (isset($params['search']) && isset($params['search_fields'])) {
			$query = $this->queryBuilder->applySearch(
				$query,
				$params['search'],
				$params['search_fields']
			);
		}

		// Apply sorting
		if (isset($params['sort'])) {
			$direction = $params['direction'] ?? 'asc';
			$query = $this->queryBuilder->applySorting($query, $params['sort'], $direction);
		}

		// Paginate
		$perPage = $params['per_page'] ?? 15;

		return $this->pagination->paginate($query, $perPage);
	}

	/**
	 * Show a single record
	 */
	public function show(Model $model): Model
	{
		return $model;
	}

	/**
	 * Store a new record
	 *
	 * @param  array<string, mixed>  $data
	 * @return Model
	 */
	public function store(Model $model, array $data): Model
	{
		return $model->create($data);
	}

	/**
	 * Update a record
	 *
	 * @param  array<string, mixed>  $data
	 * @return Model
	 */
	public function update(Model $model, array $data): Model
	{
		$model->update($data);

		return $model->fresh();
	}

	/**
	 * Delete a record
	 */
	public function delete(Model $model): bool
	{
		return $model->delete();
	}

	/**
	 * Bulk delete records
	 *
	 * @param  Collection  $models
	 * @return int
	 */
	public function bulkDelete(Collection $models): int
	{
		$count = 0;

		foreach ($models as $model) {
			if ($model->delete()) {
				$count++;
			}
		}

		return $count;
	}
}

