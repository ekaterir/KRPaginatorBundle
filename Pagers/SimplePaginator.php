<?php

/**
 * KR/PaginatorBundle/Pagers/SimplePaginator.php
 *
 * Simple paginator: Next and Prev buttons.
 *
 * @author     Kate Ryabtseva <kate.ryabtseva@gmail.com>
 */

namespace KR\PaginatorBundle\Pagers;

use KR\PaginatorBundle\Util\AbstractPaginator;

class SimplePaginator extends AbstractPaginator 
{

	/**
	 * Constructor.
	 * @param integer $limit
	 * @param integer $totalItems
	 * @param string $parameterName
	 * @param integer $adjacentCount
	 */
	function __construct($limit, $totalItems, $parameterName)
	{
		/**
		 * Call parent constructor.
		 */
		parent::__construct($limit, $totalItems, $parameterName);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see AbstractPaginator::render()
	 */
	public function render() 
	{
		$lastPage = $this->getTotalPagesCount();
		if ($lastPage == 1) {
			return;
		}
		$firstPage = 1;
		$currentPage = $this->getCurrentPage();
		$html = '<ul class="pagination">';
		
		$class = $currentPage == 1 ? ' class="disabled" ' : '' ;
		$html .= '<li' . $class . '><a href="' . $this->addQueryValue($this->getPrevious()) . '">Prev</a></li>';
		
		$class = $currentPage == $lastPage ? ' class="disabled" ' : '' ;
		$html .= '<li' . $class . '><a href="' . $this->addQueryValue($this->getNext()) . '">Next</a></li>';
		
		$html .= '</ul>';
		return $html;
	}

}
