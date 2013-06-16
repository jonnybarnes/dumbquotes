<?php namespace Jonnybarnes\Dumbquotes;

class DumbquotesParser {
	/**
	 * This tranforms the text unless its in a code block
	 * taken from http://stackoverflow.com/a/1472866/12854
	 *
	 * @returns string
	 */
	public function transform($content)
	{
		$pattern = "#\\<code>.*?\\</code>#i";

		if(preg_match_all($pattern, $content, $codeBlocks)) {
			return $this->arrayJoin($codeBlocks[0], array_map('self::smartQuotes', preg_split($pattern, $content)));
		}

		return $this->smartQuotes($content);
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
