<?php

/**
 * KR/PaginatorBundle/Util/AbstractNumbersPaginator.php
 *
 * Abstract paginator to facilitate implementation of paginators with numbers.
 *
 * @author     Kate Ryabtseva <kate.ryabtseva@gmail.com>
 */

namespace KR\PaginatorBundle\Util;

use KR\PaginatorBundle\Util\AbstractPaginator;

abstract class AbstractNumbersPaginator extends AbstractPaginator
{

	/**
	 * @var integer
	 */
	private $adjacentCount = 2;
	
	/**
	 * @var integer
	 */
	private $firstAdjacentPage;
	
	/**
	 * @var integer
	 */
	private $lastAdjacentPage;
	
	/**
	 * Set adjacent pages.
	 * @param integer $firstPage
	 * @param integer $currentPage
	 * @param integer $lastPage
	 */
	public function setAdjacentPages($firstPage, $currentPage, $lastPage)
	{
		$adjacentCount = $this->getAdjacentCount();
		if ($currentPage <= $adjacentCount + $adjacentCount) {
			$this->firstAdjacentPage = $firstPage;
			$this->lastAdjacentPage  = min($firstPage + $adjacentCount + $adjacentCount, $lastPage);
		} elseif ($currentPage > $lastPage - $adjacentCount - $adjacentCount) {
			$this->lastAdjacentPage  = $lastPage;
			$this->firstAdjacentPage = $lastPage - $adjacentCount - $adjacentCount;
		} else {
			$this->firstAdjacentPage = $currentPage - $adjacentCount;
			$this->lastAdjacentPage  = $currentPage + $adjacentCount;
		}
	}
	
	/**
	 * Get first adjacent page.
	 * @return integer
	 */
	public function getFirstAdjacentPage()
	{
		return $this->firstAdjacentPage;
	}
	
	/**
	 * Get last adjacent page.
	 * @return integer
	 */
	public function getLastAdjacentPage()
	{
		return $this->lastAdjacentPage;
	}
	
	/**
	 * Set adjacent count.
	 * @param integer $adjacentCount
	 * @return BootstrapSimpleNumbersPaginator
	 */
	public function setAdjacentCount($adjacentCount)
	{
		if ($adjacentCount != null) {
			$this->adjacentCount = $adjacentCount;
		}
		return $this;
	}
	
	/**
	 * Get adjacent count.
	 * @return integer
	 */
	public function getAdjacentCount()
	{
		return $this->adjacentCount;
	}
}
