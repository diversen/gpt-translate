<?php

require_once "vendor/autoload.php";

use Diversen\GPT\GPTTranslate;

// Throw on all kind of errors and notices
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

// Change with your own API key
$api_key = file_get_contents('/home/dennis/.config/shell-gpt-php/api_key.txt');

// Translate to a more modern English
$gpt_translate = new GPTTranslate(
    api_key: $api_key,
    from_file: "./examples/example_3/the-call-of-cthulhu.md",
    to_file: "./examples/example_3/the-call-of-cthulhu-simplified.md",

    // What to prepend to the text to translate
    pre_prompt: "You WILL modernize an English text to a more modern and more readable English text. Words that maybe appear outdated should be replaced with more modern versions of the words. You MUST not use any meta-comments. You MUST Keep any markdown formatting intact when possible. If it is just symbols or chapter names like 1 or IV then you just output these symbols or chapter titles. You MUST translate accurate and not make up anything. The text may be a headline or a full paragraph. You MUST translate from English to a more Modern English. Translate the following to a modern English version (The text to modernize begins after the next colon): ",
    // Model
    model: "gpt-4",

);

$gpt_translate->translate();

// Translate to Danish from a more modern English
$gpt_translate = new GPTTranslate(
    api_key: $api_key,
    from_file: "./examples/example_3/the-call-of-cthulhu-simplified.md",
    to_file: "./examples/example_3/the-call-of-cthulhu-danish.md",

    // What to prepend to the text to translate
    pre_prompt: "Translate English text to Danish. Be aware of the Danish grammar. The Danish grammer MUST be correct. You may simplify sentence structures if it makes a better translation. You MUST not use any meta-comments. If you make a meta-comment, the prepend it with 'XXX:'. The text you will translate to Danish begins after this colon: ",

    // Model
    model: "gpt-4",
    max_words_paragraph: 1024,

);

$gpt_translate->translate();


