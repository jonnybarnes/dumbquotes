<?php namespace Jonnybarnes\Dumbquotes;

class DumbquotesParser {
	/*
	 * we'll do a striahgt swap for now
	 * 
	 * @returns string
	 */
	public function smartQuotes($text)
	{
		$smartquotes = str_replace('\'', '‘', $text);

		return $smartquotes;
	}
}