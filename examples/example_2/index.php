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
    from_file: "./examples/example_2/celephaïs.md",
    to_file: "./examples/example_2/celephaïs-simplified.md",
    // How creative the output should be. 0.0 is not creative, 1.2 is maybe a bit creative, 2.0 may be pure nonsense
    temperature: 0.0,
    // How much the model should avoid repeating the same words. 0.0 is no penalty, 1.8 is a quite a bit of penalty
    presence_penalty: 0.0,
    // What to prepend to the text to translate
    pre_prompt: "You WILL modernize an English text to a more modern and more readable English text. Words that maybe appear outdated should be replaced with more modern versions of the words. You MUST not use any meta-comments. You MUST Keep any markdown formatting intact when possible. You MUST translate accurate and not make up anything. The text may be a headline or a full paragraph. You MUST translate from English to a more Modern English. Translate the following to a modern English version (The text to modernize begins after the next colon): ",
    // Model
    model: "gpt-4",

);

$gpt_translate->translate();

// Translate to Danish from a more modern English
$gpt_translate = new GPTTranslate(
    api_key: $api_key,
    from_file: "./examples/example_2/celephaïs-simplified.md",
    to_file: "./examples/example_2/celephaïs-danish.md",
    // How creative the output should be. 0.0 is not creative, 1.2 is maybe a bit creative, 2.0 may be pure nonsense
    temperature: 0.0,
    // How much the model should avoid repeating the same words. 0.0 is no penalty, 1.8 is a quite a bit of penalty
    presence_penalty: 0.0,
    // What to prepend to the text to translate
    pre_prompt: "Translate English text to Danish. Be aware of the Danish grammar. The grammer MUST be correct. You may simplify sentence structures if it makes a better translation. You MUST not use any meta-comments. The text you will translate to Danish begins after this colon: ",
    // Model
    model: "gpt-4",

);

$gpt_translate->translate();


