#Dumbquotes

This looks for dumbquotes and replaces them with their smart quotes equivalent.

To use first we install it, then we need to declare the namepsace then instantiate the parser.
Edit your `composer.json` requires section to inlcude `jonnybarnes/dumbquotes`:

    {
        "require": {
            "jonnybarnes/dumbquotes": "1.0.*"
        }
    }

then in your PHP:

    <?php
    use \Jonnybarnes\Dumbquotes\DumbquotesParser;

    $parser = new DumbquotesPraser();

Then we can replace our dumbquotes with the `smartQuotes()` method like so:

    $original = 'Let\'s try this!';
    $transformed = $parser->smartQuotes($original);

As simple as that.
