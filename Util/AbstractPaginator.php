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
	private $current_page = 0;
	
	/**
	 * @var integer
	 */
	private $total_pages_count = 0;
	
	/**
	 * @var integer
	 */
	private $total_items_count = 0;
	
	/**
	 * @var integer
	 */
	private $offset = 0;
	
	/**
	 * @var integer
	 */
	private $limit = 0;
	
	/**
	 * @var string
	 */
	private $query_key = 'page';
	
	/**
	 * @var array
	 */
	private $url_parts = [];
	
	/**
	 * Constructor.
	 * @param integer $limit
	 * @param integer $total_items_count
	 * @param string $query_key
	 */
	function __construct($limit, $total_items_count, $query_key)
	{
		$this->setLimit($limit);
		$this->setTotalItemsCount($total_items_count);
		$this->setQueryKey($query_key);
		$this->setTotalPagesCount();
		$this->setCurrentPage();
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

				$url_parts = parse_url($_SERVER['REQUEST_URI']);
				$this->url_parts = $url_parts;
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
		return $this->url_parts;
	}
	
	/**
	 * Get query parameter name.
	 * @return string
	 */
	public function getQueryKey()
	{
		return $this->query_key;
	}
	
	/**
	 * Set parameter name.
	 */
	public function setQueryKey($query_key)
	{
		if ($query_key != null) {
			$this->query_key = $query_key;
		}
	}
	
	/**
	 * Get current page.
	 * @return integer
	 */
	public function getCurrentPage()
	{
		return $this->current_page;
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
	public function setCurrentPage()
	{

		$parameter = $this->getQueryKey();
		
		if (isset($_GET[$parameter])) {
			$this->current_page = $this->_validateValue($_GET[$parameter]);
		} else {
			$this->current_page = 1;
		}
		
		return $this;
	}
	
	/**
	 * Get total pages.
	 * @return integer
	 */
	public function getTotalPagesCount()
	{
		return $this->total_pages_count;
	}
	
	/**
	 * Set total pages.
	 */
	public function setTotalPagesCount()
	{
		$this->total_pages_count = ceil($this->getTotalItemsCount() / $this->getLimit());
		return $this;
	}
	
	/**
	 * Get total items count.
	 * @return integer
	 */
	public function getTotalItemsCount()
	{
		return $this->total_items_count;
	}
	
	/**
	 * Set total items count.
	 */
	public function setTotalItemsCount($total_items_count)
	{
		$this->total_items_count = $total_items_count;
		return $this;
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
		$this->limit = $limit;
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
	 */
	public function addQueryValue($value)
	{

		try {
		
			$params = [];
			$url_parts = $this->getURLParts();
			
			if (isset($url_parts['query'])) {
				parse_str($url_parts['query'], $params);
			}
			
			$params[$this->getQueryKey()] = $this->_validateValue($value);
			
			return (isset($url_parts['path']) ? $url_parts['path'] : '/') . '?' . http_build_query($params);
	    
		} catch (\Exception $e) {

			throw new \Exception('Could not paginate.');
	    
		}
	}
	
	/**
	 * Render the paginator.
	 */
	abstract public function render();

}

