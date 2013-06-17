<?php namespace Jonnybarnes\Dumbquotes;

class DumbquotesParser {
	/**
	 * This acts as a proxy for allMethods(), ensures doesn't
	 * happen in code blocks;
	 * taken from http://stackoverflow.com/a/1472866/12854
	 *
	 * @returns string
	 */
	public function transform($content)
	{
		$pattern = "#\\<code(.*)>.*?\\</code>#i";

		if(preg_match_all($pattern, $content, $codeBlocks)) {
			return $this->arrayJoin($codeBlocks[0], array_map('self::allMethods', preg_split($pattern, $content)));
		}

		return $this->allMethods($content);
	}

	/*
	 * This applies all the methods, used by transform()
	 *
	 * @returns string
	 */
	public function allMethods($text)
	{
		$quotes = $this->smartQuotes($text);
		$ellipsis = $this->ellipsis($quotes);
		$dashes = $this->dashes($ellipsis);

		return $dashes;
	}

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

		//Now we straight swap left over single quotes
		$strayquotes = $this->strayQuotes($doublequotes);

		return $strayquotes;
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
		$singlequotesPattern = "/'(.*?)'/";
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
		$doublequotesPattern = '/"(.*?)"/';
		$doublequotesReplacment = '“$1”';

		$doublequotes = preg_replace($doublequotesPattern, $doublequotesReplacment, $text);

		return $doublequotes;
	}

	/*
	 * This looks for any stray quotes
	 *
	 * @returns string
	 */
	public function strayQuotes($text)
	{
		$stray = str_replace("'", "’", $text);

		return $stray;
	}

	/**
	 * This replaces three periods with ellipses
	 *
	 * @returns string
	 */
	public function ellipsis($text)
	{
		// first we deal with ellipses in sentences
		$ellipsisPattern = '/(\s+)(\.{3})(\s*)/';
		$ellipsisReplacement = ' … ';

		$ellipsis = preg_replace($ellipsisPattern, $ellipsisReplacement, $text);

		//now we deal with ellipses at the end
		$ellipsisPatternEnd = '/(\.{3})$/';
		$ellipsisReplacementEnd = '…';

		$ellipsisEnd = preg_replace($ellipsisPatternEnd, $ellipsisReplacementEnd, $ellipsis);

		return $ellipsisEnd;
	}

	/*
	 * This swaps dashes for em and en dashes
	 *
	 * @returns string
	 */
	public function dashes($text)
	{
		$emdash = str_replace('---', '—', $text);
		$endash = str_replace('--', '–', $emdash);

		return $endash;
	}



	/*
	 * This function pieces together transformed text with untransformed code text
	 * taken from http://stackoverflow.com/a/1472866/12854
	 *
	 * @returns string
	 */
	public function arrayJoin(array $glue, array $pieces)
	{
		$glue = array_values($glue);
		$pieces = array_values($pieces);
		$piecesSize = count($pieces);

		if(count($glue) + 1 != $piecesSize) {
			return false;
		}

		$joined = array();
		for($i = 0; $i < $piecesSize; $i++) {
			$joined[] = $pieces[$i];
			if(isset($glue[$i])) {
				$joined[] = $glue[$i];
			}
		}

		return implode('', $joined);
	}
}
