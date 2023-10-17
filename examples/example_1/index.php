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
    from_file: "./examples/example_1/lykke-per-1.md",
    to_file: "./examples/example_1/a-fortunate-man.md",
    // How creative the output should be. 0.0 is not creative, 1.2 is maybe a bit creative, 2.0 may be pure nonsense
    temperature: 0.7,
    // How much the model should avoid repeating the same words. 0.0 is no penalty, 1.8 is a quite a bit of penalty
    presence_penalty: 0.1,
    // top_p. What part of the pro
    top_p: 0.99,
    // What to prepend to the text to translate
    pre_prompt: "Translate the following Danish text to modern and readable English. You MUST not use any meta-comments. If you don't understand a word, then try to guess the meaning from the context. Keep any markdown formatting intact when possible. You may get a single line or a complete paragraph or just a few words. Translate it as good as you can. Here is the text to translate: ",
    // Model
    model: "gpt-4",

);

$gpt_translate->translate();
