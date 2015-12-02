<?php

/**
 * KR/PaginatorBundle/Paginator.php
 *
 * Paginator instantiates the right classes based on the paginator type.
 *
 * @author     Kate Ryabtseva <kate.ryabtseva@gmail.com>
 */

namespace KR\PaginatorBundle;

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
	 * @var array
	 */
	private $defaultOptions = [
		'limit' => NULL,
		'totalItems' => 0,
		'queryKey' => NULL,
		'adjacentCount' => NULL
	];
	
	/**
	 * Set default options.
	 * @param array $options
	 */
	public function setDefaultOptions(array $options)
	{
		$this->defaultOptions = array_merge($this->defaultOptions, $options);
	}

	/**
	 * Get default options.
	 * @return array
	 */
	public function getDefaltOptions()
	{
		return $this->defaultOptions;
	}
	
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
	 * Check if the supplied options are present in defaultOptions.
	 * @param array $options
	 * @return array
	 */
	private function _validateDefaultOptions(array $options)
	{
		
		$defaultOptions = $this->getDefaltOptions();
		
		if (!array_key_exists('totalItems', $options)) {
			throw new \Exception("'totalItems' is a required parameter.");
		}

		foreach ($options as $key => $value) {
			$defaultOptions[$key] = $value;
		}

		return $defaultOptions;
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
		
		$options = $this->_validateDefaultOptions($options);
		
		$paginator = NULL;
		
		switch ($type) {
			
			case 'simple':
				$paginator = new \KR\PaginatorBundle\Pagers\SimplePaginator($options['totalItems'], $options['limit'], $options['queryKey']);
				break;
			case 'numbers':
				$paginator = new \KR\PaginatorBundle\Pagers\NumbersPaginator($options['totalItems'], $options['limit'], $options['queryKey'], $options['adjacentCount']);
				break;
			case 'simple_numbers':
				$paginator = new \KR\PaginatorBundle\Pagers\SimpleNumbersPaginator($options['totalItems'], $options['limit'], $options['queryKey'], $options['adjacentCount']);
				break;
			case 'full':
				$paginator = new \KR\PaginatorBundle\Pagers\FullPaginator($options['totalItems'], $options['limit'], $options['queryKey']);
				break;
			case 'full_numbers':
				$paginator = new \KR\PaginatorBundle\Pagers\FullNumbersPaginator($options['totalItems'], $options['limit'], $options['queryKey'], $options['adjacentCount']);
				break;
				
		}
		
		return $paginator;
	
	}
}

