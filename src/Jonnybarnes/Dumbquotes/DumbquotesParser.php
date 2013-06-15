<?php namespace Jonnybarnes\Dumbquotes;

class DumbquotesParser {
	/*
	 * We swap all the dumb quotes for smart quotes
	 * 
	 * @returns string
	 */
	public function smartQuotes($text)
	{
		$apostrophe = $this->apostrophe($text);

		$singlequotes = $this->singleQuotes($apostrophe);

		$doublequotes = $this->doubleQuotes($singlequotes);

		return $doublequotes;
	}

	/*
	 * This looks for single apostrophes
	 *
	 * @returns string
	 */
	public function apostrophe($text)
	{
		$apostrophes = str_replace('\'s', '’s', $text);
		$sapostrophe = str_replace('s\' ', 's’ ', $apostrophes);

		$apostrophePattern = "/(\w+)'(\w+)/";
		$apotropheReplacement = '$1’$2';
		$apostrophe = preg_replace($apostrophePattern, $apotropheReplacement, $sapostrophe);
		
		return $apostrophe;
	}

	/*
	 * The looks for single quotes, i.e. 'Some text'
	 *
	 * @returns string
	 */
	public function singleQuotes($text)
	{
		$singlequotesPattern = "/'(.*)'/";
		$singlequotesReplacement = "‘$1’";

		$singlequotes = preg_replace($singlequotesPattern, $singlequotesReplacement, $text);

		return $singlequotes;
	}

	/*
	 * This looks for double quotes, i.e. "Some text"
	 *
	 * @returns string
	 */
	public function doubleQuotes($text)
	{
		$doublequotesPattern = '/"(.*)"/';
		$doublequotesReplacment = '“$1”';

		$doublequotes = preg_replace($doublequotesPattern, $doublequotesReplacment, $text);

		return $doublequotes;
	}
}
