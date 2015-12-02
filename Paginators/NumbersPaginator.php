<?php 

/**
 * KR/PaginatorBundle/Paginators/NumbersPaginator.php
 *
 * Numbers paginator: Page numbers buttons only.
 *
 * @author     Kate Ryabtseva <kate.ryabtseva@gmail.com>
 */

namespace KR\PaginatorBundle\Paginators;

use KR\PaginatorBundle\Util\AbstractNumbersPaginator;

class NumbersPaginator extends AbstractNumbersPaginator
{
	
	/**
	 * Constructor.
	 * @param integer $limit
	 * @param integer $totalItems
	 * @param string $parameterName
	 * @param integer $adjacentCount
	 */
	function __construct($limit, $totalItems, $parameterName, $adjacentCount)
	{
		/**
		 * Call parent constructor.
		 */
		parent::__construct($limit, $totalItems, $parameterName);
		$this->setAdjacentCount($adjacentCount);
	}
	
	/**
	 * @see AbstractPaginator::render()
	 * @return string
	 */
	public function render()
	{
		$lastPage = $this->getTotalPagesCount();
		if ($lastPage == 1) {
			return;
		}
		$firstPage = 1;
		$currentPage = $this->getCurrentPage();
		$this->setAdjacentPages($firstPage, $currentPage, $lastPage);
		$firstAdjacentPage = $this->getFirstAdjacentPage();
		$lastAdjacentPage = $this->getLastAdjacentPage();
		$html = '<ul class="pagination no-margin">';
		
		if ($firstAdjacentPage > $firstPage) {
			$class = $currentPage == 1 ? ' class="active" ' : ' ';
			$href = $this->addQueryValue(1);
			$html .= '<li' . $class . '><a href="'. $href .'">1</a></li>';
			if ($firstAdjacentPage > $firstPage + 1) {
				$html .= '<li><span>...</span></li>';
			}
		}
		
		for ($i = $firstAdjacentPage; $i <= $lastAdjacentPage; $i++) {
			$href = $this->addQueryValue($i);
			if ($currentPage == $i) {
				$class = ' class="active" ';
				$html .= '<li' . $class . '><a href="' . $href . '">' . $i . '</a></li>';
			} else {
				$html .= '<li><a href="' . $href . '">' . $i . '</a></li>';
			}
		}
		if ($lastAdjacentPage < $lastPage) {
        	if ($lastAdjacentPage < $lastPage - 1) {
            	$html .= '<li><span>...</span></li>';
        	}
			$class = $currentPage == $lastPage ? ' class="active" ' : ' ';
			$href = $this->addQueryValue($lastPage);
			$html .= '<li' . $class . '><a href="' . $href . '">' . $lastPage . '</a></li>';
    	}
		
		
		$html .= '</ul>';
		return $html;
	}
}

