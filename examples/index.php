<?php

require_once "vendor/autoload.php";

use Diversen\GPT\GPTTranslate;

$api_key = file_get_contents('./examples/api_key.txt');
$gpt_translate = new GPTTranslate(
    api_key: $api_key,
    from_file: "./examples/kongens-fald.md",
    to_file: "./examples/the-fall-of-the-king.md", 
    // How creative the output should be. 0.0 is not creative, 1.2 is maybe a bit creative, 2.0 may be pure nonsense
    temperature: 1.2, 
    // How much the model should avoid repeating the same words. 0.0 is no penalty, 1.8 is a quite a bit of penalty
    presence_penalty: 1.8, 
    // What to prepend to the text to translate
    pre_message: "Translate the following from danish to english while keeping the markdown syntax (if any markdown syntax): "
);

$gpt_translate->translate();
