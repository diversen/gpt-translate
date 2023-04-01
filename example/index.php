<?php

require_once "vendor/autoload.php";

use Diversen\GPT\GPTTranslate;

// Throw on all kind of errors and notices
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

// Change with your own API key
$api_key = file_get_contents('/home/dennis/.config/shell-gpt-php/api_key.txt');
$gpt_translate = new GPTTranslate(
    api_key: $api_key,
    from_file: "./example/lykke-per-1.md",
    to_file: "./example/a-fortunate-man.md",
    // How creative the output should be. 0.0 is not creative, 1.2 is maybe a bit creative, 2.0 may be pure nonsense
    temperature: 1.2,
    // How much the model should avoid repeating the same words. 0.0 is no penalty, 1.8 is a quite a bit of penalty
    presence_penalty: 1.8,
    // What to prepend to the text to translate
    pre_prompt: "Translate the following from danish to english: "
);

$gpt_translate->translate();
