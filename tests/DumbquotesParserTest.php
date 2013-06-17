<?php

require __DIR__.'/../src/Jonnybarnes/Dumbquotes/DumbquotesParser.php';

class DumbquotesParserTest extends PHPUnit_Framework_TestCase {
	protected $parser;

	protected function setUp()
	{
		$this->parser = new \Jonnybarnes\Dumbquotes\DumbquotesParser();
	}

	protected function tearDown()
	{
		$this->parser = null;
	}

	public function testTransform()
	{
		$actual = $this->parser->transform('This "cool" feature doesn\'t happen in <code>"quoted" code</code>, cool...');
		$expected = 'This “cool” feature doesn’t happen in <code>"quoted" code</code>, cool…';

		$this->assertEquals($actual, $expected);
	}

	public function testSmartQuotes()
	{
		$actual = $this->parser->smartQuotes('\'Hal said, "Good morning, Dave,"\' recalled Frank');
		$expected = '‘Hal said, “Good morning, Dave,”’ recalled Frank';

		$this->assertEquals($actual, $expected);
	}

	public function testApostrophe()
	{
		$actual = $this->parser->apostrophe('We\'re testing Jonny\'s apostrophes\' form');
		$expected = 'We’re testing Jonny’s apostrophes’ form';

		$this->assertEquals($actual, $expected);
	}

	public function testSingleQuotes()
	{
		$actual = $this->parser->singleQuotes('Jonny said \'Hello there\' to his friend');
		$expected = 'Jonny said ‘Hello there’ to his friend';

		$this->assertEquals($actual, $expected);
	}

	public function testDoubleQuotes()
	{
		$actual = $this->parser->doubleQuotes('Jonny said "Hello there" to his friend');
		$expected = 'Jonny said “Hello there” to his friend';

		$this->assertEquals($actual, $expected);
	}

	public function testEllipsis()
	{
		$actual = $this->parser->ellipsis('An interr...upted word in some text ... Interesting');
		$expected = 'An interr...upted word in some text … Interesting';

		$this->assertEquals($actual, $expected);
	}

	public function testDashes()
	{
		$actual = $this->parser->dashes('June--July, I like sentences---with seperate thoughts---that are not overly long');
		$expected = 'June–July, I like sentences—with seperate thoughts—that are not overly long';

		$this->assertEquals($actual, $expected);
	}
}