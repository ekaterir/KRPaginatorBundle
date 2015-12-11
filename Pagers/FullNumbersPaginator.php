<?php

/**
 * KR/PaginatorBundle/Pagers/FullNumbersPaginator.php
 *
 * Full Numbers paginator: First, Next, Prev, Last, and page numbers buttons.
 *
 * @author     Kate Ryabtseva <kate.ryabtseva@gmail.com>
 */

namespace KR\PaginatorBundle\Pagers;

use KR\PaginatorBundle\Util\AbstractNumbersPaginator;

class FullNumbersPaginator extends AbstractNumbersPaginator
{

	/**
	 * Constructor.
	 * @param integer $limit
	 * @param integer $totalItems
	 * @param string $parameterName
	 * @param integer $adjacentCount
	 */
	function __construct($totalItems, $limit = NULL, $parameterName = NULL, $adjacentCount = NULL, $currentPage = NULL)
	{
		/**
		 * Call parent constructor.
		 */
		parent::__construct($totalItems, $limit, $parameterName, $currentPage);
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
		$html = '<ul class="pagination">';

		$class = $currentPage == $firstPage ? ' class="disabled" ' : '' ;
		$html .= '<li' . $class . '><a href="' . $this->addQueryValue($firstPage) . '">First</li>';
		$html .= '<li' . $class . '><a href="' . $this->addQueryValue($this->getPrevious()) . '">Prev</a></li>';

		if ($firstAdjacentPage > $firstPage) {
			$class = $currentPage == $firstPage ? ' class="active" ' : ' ';
			$href = $this->addQueryValue($firstPage);
			$html .= '<li' . $class . '><a href="'. $href .'">' . $firstPage . '</a></li>';
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

		$class = $currentPage == $lastPage ? ' class="disabled" ' : '' ;
		$html .= '<li' . $class . '><a href="' . $this->addQueryValue($this->getNext()) . '">Next</a></li>';
		$html .= '<li' . $class . '><a href="' . $this->addQueryValue($lastPage) . '">Last</li>';

		$html .= '</ul>';
		return $html;
	}
}
