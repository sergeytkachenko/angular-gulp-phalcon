<?php


namespace Lib\Import;
use Iterator;

interface LineIterator extends Iterator
{
	/**
	 * @return Line
	 */
	public function next();
}