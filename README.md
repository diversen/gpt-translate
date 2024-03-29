# README

This is minimal howto about translating a long text using GPT using php.
It may translate markdown texts, e.g. a novel, from one language to another. 
It does the job quite well, but in any case you will need to edit
the translated document if you want a translation of high quality.

The auto-translation may serve as a good starting point. 

It is only tested using markdown text. It will split a document into small
parts based on double lines. And then translate one section at a time. 

## Usage

This example will make an effort to translate the first the part of the danish novel 
'Lykke Per' (A Fortunate Man) into english. 

    git clone git@github.com:diversen/gpt-translate.git
    cd gpt-translate
    composer install

You will need to change the api key in [examples/example_1/index.php](examples/example_1/index.php) 
Then run:

    php examples/example_1/index.php

(There is also a couple of other examples).

## As library

    composer require diversen/gpt-translate

Usage is the same as in [examples/example_1/index.php](examples/example_1/index.php)

## Related

This repo will try and fetch a URL and turn a html page into markdown: 

https://github.com/diversen/url-to-markdown

## License

MIT © [Dennis Iversen](https://github.com/diversen)




