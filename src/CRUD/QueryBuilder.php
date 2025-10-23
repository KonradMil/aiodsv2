<?php

declare(strict_types=1);

namespace Aiods\Core\CRUD;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * Query Builder
 *
 * Handles filtering, searching, and sorting for CRUD operations.
 * Single responsibility: query manipulation only.
 */
final class QueryBuilder
{
	/**
	 * Apply filters to query
	 *
	 * @param  Builder  $query
	 * @param  array<string, mixed>  $filters
	 * @return Builder
	 */
	public function applyFilters(Builder $query, array $filters): Builder
	{
		foreach ($filters as $field => $value) {
			if ($value === null || $value === '') {
				continue;
			}

			$query = $this->applyFilter($query, $field, $value);
		}

		return $query;
	}

	/**
	 * Apply a single filter
	 */
	private function applyFilter(Builder $query, string $field, mixed $value): Builder
	{
		return match (true) {
			is_array($value) => $query->whereIn($field, $value),
			str_contains($field, '.') => $this->applyNestedFilter($query, $field, $value),
			default => $query->where($field, $value),
		};
	}

	/**
	 * Apply nested filter (for relations)
	 */
	private function applyNestedFilter(Builder $query, string $field, mixed $value): Builder
	{
		[$relation, $column] = explode('.', $field, 2);

		return $query->whereHas($relation, function ($q) use ($column, $value) {
			$q->where($column, $value);
		});
	}

	/**
	 * Apply search to query
	 *
	 * @param  Builder  $query
	 * @param  string  $term
	 * @param  array<string>  $fields
	 * @return Builder
	 */
	public function applySearch(Builder $query, string $term, array $fields): Builder
	{
		if (empty($term) || empty($fields)) {
			return $query;
		}

		return $query->where(function ($q) use ($term, $fields) {
			foreach ($fields as $field) {
				$q->orWhere($field, 'like', "%{$term}%");
			}
		});
	}

	/**
	 * Apply sorting to query
	 *
	 * @param  Builder  $query
	 * @param  string  $field
	 * @param  string  $direction
	 * @return Builder
	 */
	public function applySorting(Builder $query, string $field, string $direction = 'asc'): Builder
	{
		$direction = strtolower($direction);

		if (! in_array($direction, ['asc', 'desc'])) {
			$direction = 'asc';
		}

		return $query->orderBy($field, $direction);
	}

	/**
	 * Apply multiple sorts
	 *
	 * @param  Builder  $query
	 * @param  array<string, string>  $sorts
	 * @return Builder
	 */
	public function applyMultipleSorts(Builder $query, array $sorts): Builder
	{
		foreach ($sorts as $field => $direction) {
			$query = $this->applySorting($query, $field, $direction);
		}

		return $query;
	}
}

