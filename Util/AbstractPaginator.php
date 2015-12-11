<?php

/**
 * KR/PaginatorBundle/Util/AbstractPaginator.php
 *
 * Abstract paginator to facilitate implementation of different types of paginators.
 *
 * @author     Kate Ryabtseva <kate.ryabtseva@gmail.com>
 */

namespace KR\PaginatorBundle\Util;

abstract class AbstractPaginator
{

	/**
	 * @var integer
	 */
	private $currentPage = 0;

	/**
	 * @var integer
	 */
	private $totalPagesCount = 0;

	/**
	 * @var integer
	 */
	private $totalItemsCount = 0;

	/**
	 * @var integer
	 */
	private $offset = 0;

	/**
	 * @var integer
	 */
	private $limit = 10;

	/**
	 * @var string
	 */
	private $queryKey = 'page';

	/**
	 * @var array
	 */
	private $urlParts = [];

	/**
	 * Constructor.
	 * @param integer $limit
	 * @param integer $totalItemsCount
	 * @param string $queryKey
	*/
	function __construct($totalItemsCount, $limit = NULL, $queryKey = NULL, $currentPage = NULL)
	{
		$this->setLimit($limit);
		$this->setTotalItemsCount($totalItemsCount);
		$this->setQueryKey($queryKey);
		$this->setTotalPagesCount();
		$this->setCurrentPage($currentPage);
		$this->setOffset();
		$this->setURLParts();
	}

	/**
	 * Set URL parts.
	 */
	public function setURLParts()
	{

		try {
			if (isset($_SERVER['REQUEST_URI'])) {
				$urlParts = parse_url($_SERVER['REQUEST_URI']);
				$this->urlParts = $urlParts;
				return $this;

			}
				
		} catch (\Exception $e) {
				
			throw new \Exception ('Could not get url information');

		}
	}

	/**
	 * Get URL parts.
	 * @return array
	 */
	public function getURLParts()
	{
		return $this->urlParts;
	}

	/**
	 * Get query parameter name.
	 * @return string
	 */
	public function getQueryKey()
	{
		return $this->queryKey;
	}

	/**
	 * Set parameter name.
	 */
	public function setQueryKey($queryKey)
	{
		if ($queryKey != null) {
			$this->queryKey = $queryKey;
		}
	}

	/**
	 * Get current page.
	 * @return integer
	 */
	public function getCurrentPage()
	{
		return $this->currentPage;
	}

	/**
	 * Set parameter value to 1 if not valid.
	 * @return integer
	 */
	private function _validateValue($value)
	{
		if (($value == null) || !is_numeric($value) || ($value <= 0)) {
			$value = 1;
		} elseif ($value > $this->getTotalPagesCount()) {
			$value = $this->getTotalPagesCount();
		}
		return $value;
	}

	/**
	 * Set current page.
	 */
	public function setCurrentPage($currentPage)
	{
		
		if ($currentPage != null) {
			
			$this->currentPage = $this->_validateValue($currentPage);
			
		} else {
			
			$parameter = $this->getQueryKey();
	
			if (isset($_GET[$parameter])) {
				$this->currentPage = $this->_validateValue($_GET[$parameter]);
			} else {
				$this->currentPage = 1;
			}
			
		}

		return $this;
	}

	/**
	 * Get total pages.
	 * @return integer
	 */
	public function getTotalPagesCount()
	{
		return $this->totalPagesCount;
	}

	/**
	 * Set total pages.
	 */
	public function setTotalPagesCount()
	{
		$this->totalPagesCount = ceil($this->getTotalItemsCount() / $this->getLimit());
		return $this;
	}

	/**
	 * Get total items count.
	 * @return integer
	 */
	public function getTotalItemsCount()
	{
		return $this->totalItemsCount;
	}

	/**
	 * Set total items count.
	 */
	public function setTotalItemsCount($totalItemsCount)
	{
		if ($totalItemsCount != null && is_numeric($totalItemsCount)) {
			$this->totalItemsCount = $totalItemsCount;
			return $this;
		}
		throw new \Exception('Total items must be a number.');
	}

	/**
	 * Get offset.
	 * @return integer
	 */
	public function getOffset()
	{
		return $this->offset;
	}

	/**
	 * Set offset.
	 */
	public function setOffset()
	{
		$this->offset = ($this->getCurrentPage() - 1) * $this->getLimit();
		return $this;
	}

	/**
	 * Get limit.
	 * @return integer
	 */
	public function getLimit()
	{
		return $this->limit;
	}

	/**
	 * Set limit.
	 */
	public function setLimit($limit)
	{
		if ($limit != null && is_numeric($limit)) {
			$this->limit = $limit;
		}
		return $this;
	}

	/**
	 * Get the previous page.
	 * @return integer
	 */
	public function getPrevious()
	{
		if ($this->getCurrentPage() - 1 > 0) {
			return $this->getCurrentPage() - 1;
		} else {
			return $this->getCurrentPage();
		}
	}

	/**
	 * Get the next page.
	 * @return integer
	 */
	public function getNext()
	{
		if ($this->getCurrentPage() + 1 <= $this->getTotalPagesCount()) {
			return $this->getCurrentPage() + 1;
		} else {
			return $this->getCurrentPage();
		}
	}

	/**
	 * Set URL query parameter.
	 * @param integer $value	Page number
	 */
	public function addQueryValue($value)
	{
		try {

			$params = [];
			$urlParts = $this->getURLParts();
				
			if (isset($urlParts['query'])) {
				parse_str($urlParts['query'], $params);
			}
				
			$params[$this->getQueryKey()] = $this->_validateValue($value);
				
			return (isset($urlParts['path']) ? $urlParts['path'] : '/') . '?' . http_build_query($params);
			 
		} catch (\Exception $e) {
			throw new \Exception('Could not paginate.');
		}
	}

	/**
	 * Get a range of items that appear on the current page.
	 * @return string
	 */
	public function getCurrentItemsRange()
	{

		$currentPage = $this->getCurrentPage();
		$limit = $this->getLimit();
	
		$from = ($currentPage - 1) * $limit + 1;
		
		if ($currentPage == $this->getTotalPagesCount()) {
			$to = $this->getTotalItemsCount();
		} else {
			$to = $currentPage * $limit;
		}
	
		return "$from - $to";
	
	}
	
	/**
	 * Render the paginator.
	 */
	abstract public function render();
}
