<?php

/**
 * KR/PaginatorBundle/Util/AbstractPaginatorMethod.php
 *
 * Abstract method to build the correct paginator.
 *
 * @author     Kate Ryabtseva <kate.ryabtseva@gmail.com>
 */

namespace KR\PaginatorBundle\Util;

abstract class AbstractPaginatorMethod 
{
	
	/**
	 * Factory method that instantiates the right Paginator.
	 * @param integer $type
	 * @param array $options
	 */
	abstract function buildPaginator($type, array $options);
	
}
