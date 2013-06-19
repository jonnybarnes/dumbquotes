#Dumbquotes

[![Build Status](https://travis-ci.org/jonnybarnes/dumbquotes.png)](https://travis-ci.org/jonnybarnes/dumbquotes)

This looks for dumbquotes and other typeographical features replaces them with their smart equivalent.

It will replace

* straight quotes
* ellipses
* dashes

This has been made to deal with plain text. It fits into my workflow by first applying the `tranform()` method and then applying a Markdown parser to the result. To do so the other way round would result in having to deal with HTML which would make the code vastly more complex.

To use this first we must install it. Then we need to declare the namepsace then instantiate the parser.

Edit your `composer.json` requires section to inlcude `jonnybarnes/dumbquotes`:

    {
        "require": {
            "jonnybarnes/dumbquotes": "dev-master"
        }
    }

then in your PHP:

    <?php
    use \Jonnybarnes\Dumbquotes\DumbquotesParser;

    $parser = new DumbquotesPraser();

Then we can replace our dumb typography with the `transform()` method like so:

    $original = 'Let\'s try this!';
    $transformed = $parser->tranform($original);

As simple as that.