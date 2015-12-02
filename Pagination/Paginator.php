<?php

/**
 * KR/PaginatorBundle/Pagination/Paginator.php
 *
 * Paginator instantiates the right classes based on the paginator type.
 *
 * @author     Kate Ryabtseva <kate.ryabtseva@gmail.com>
 */

namespace KR\PaginatorBundle\Pagination;

use KR\PaginatorBundle\Util\AbstractPaginatorMethod;

class Paginator extends AbstractPaginatorMethod 
{

	/**
	 * @var array
	 */
	private $paginatorTypes = [
		'simple',
		'numbers',
		'simple_numbers',
		'full',
		'full_numbers'
	];

	/**
	 * Get paginator types.
	 * @return array
	 */
	public function getPaginatorTypes()
	{
		return $this->paginatorTypes;
	}

	/**
	 * Set paginator types.
	 * @param array $types
	 */
	public function setPaginatorTypes(array $types)
	{
		$this->paginatorTypes = array_merge($this->paginatorTypes, $types);
	}
	
	/**
	 * @param string $type
	 * @param array $options
	 * @see AbstractFactoryMethod::buildPaginator()
	 * @return AbstractPaginator $paginator
	 */
	function buildPaginator($type, array $options)
	{

		if (!in_array($type, $this->paginatorTypes)) {
			throw new \Exception("Paginator type '$type' does not exist.");
		}
		
		$paginator = NULL;
		
		switch ($type) {
			
			case 'simple':
				$paginator = new \KR\PaginatorBundle\Paginators\SimplePaginator($options['limit'], $options['totalItems'], $options['queryKey']);
				break;
			case 'numbers':
				$paginator = new \KR\PaginatorBundle\Paginators\NumbersPaginator($options['limit'], $options['totalItems'], $options['queryKey'], $options['adjacentCount']);
				break;
			case 'simple_numbers':
				$paginator = new \KR\PaginatorBundle\Paginators\SimpleNumbersPaginator($options['limit'], $options['totalItems'], $options['queryKey'], $options['adjacentCount']);
				break;
			/*case 'full':
				break;
			case 'full_numbers':
				break;
			*/	
		}
		
		return $paginator;
	
	}
}

