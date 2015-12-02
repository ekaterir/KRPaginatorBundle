<?php

/**
 * KR/PaginatorBundle/Pagers/FullPaginator.php
*
* Simple paginator: First, Next, Prev, Last buttons only.
*
* @author     Kate Ryabtseva <kate.ryabtseva@gmail.com>
*/

namespace KR\PaginatorBundle\Pagers;

use KR\PaginatorBundle\Util\AbstractPaginator;

class FullPaginator extends AbstractPaginator
{

	/**
	 * Constructor.
	 * @param integer $limit
	 * @param integer $totalItems
	 * @param string $parameterName
	 */
	function __construct($totalItems, $limit = NULL, $parameterName = NULL)
	{
		/**
		 * Call parent constructor.
		 */
		parent::__construct($totalItems, $limit, $parameterName);
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

		$class = $currentPage == $firstPage ? ' class="disabled" ' : '' ;
		$html .= '<li' . $class . '><a href="' . $this->addQueryValue($firstPage) . '">First</li>';
		$html .= '<li' . $class . '><a href="' . $this->addQueryValue($this->getPrevious()) . '">Prev</a></li>';

		$class = $currentPage == $lastPage ? ' class="disabled" ' : '' ;
		$html .= '<li' . $class . '><a href="' . $this->addQueryValue($this->getNext()) . '">Next</a></li>';
		$html .= '<li' . $class . '><a href="' . $this->addQueryValue($lastPage) . '">Last</li>';

		$html .= '</ul>';
		return $html;
		
	}

}