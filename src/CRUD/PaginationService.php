<?php

declare(strict_types=1);

namespace Aiods\Core\CRUD;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Pagination Service
 *
 * Handles pagination for CRUD operations.
 * Single responsibility: pagination only.
 */
final class PaginationService
{
	/**
	 * Paginate query results
	 *
	 * @param  Builder  $query
	 * @param  int  $perPage
	 * @param  int|null  $page
	 * @return LengthAwarePaginator
	 */
	public function paginate(Builder $query, int $perPage = 15, ?int $page = null): LengthAwarePaginator
	{
		$page = $page ?? request()->get('page', 1);

		return $query->paginate($perPage, ['*'], 'page', $page);
	}

	/**
	 * Get pagination metadata
	 *
	 * @param  LengthAwarePaginator  $paginator
	 * @return array<string, mixed>
	 */
	public function getMetadata(LengthAwarePaginator $paginator): array
	{
		return [
			'current_page' => $paginator->currentPage(),
			'per_page' => $paginator->perPage(),
			'total' => $paginator->total(),
			'last_page' => $paginator->lastPage(),
			'from' => $paginator->firstItem(),
			'to' => $paginator->lastItem(),
		];
	}
}

