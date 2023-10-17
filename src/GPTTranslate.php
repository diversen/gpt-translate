<?php

namespace Diversen\GPT;

use Diversen\GPT\OpenAiApi;
use Diversen\GPT\ApiResult;
use ArrayObject;
use Exception;

class GPTTranslate
{
    private ?ArrayObject $paragraphs = null;
    private string $pre_prompt = '';
    private ?OpenAiApi $openai_api = null;
    private $total_tokens = 0;
    private $failure_sleep = 30;
    private $from_file = '';
    private $to_file = '';
    private $failure_iterations = 1;
    private $temperature = 1.2;
    private $presence_penalty = 1.8;
    private $top_p = 0.99;
    private $model = 'gpt-4';

    public function __construct(
        string $api_key,
        string $from_file,
        string $to_file,
        string $pre_prompt,
        int $failure_sleep = 30,
        float $temperature = 0.7,
        float $presence_penalty = 0.1,
        float $top_p = 0.99,
        string $model = 'gpt-4',
    ) {
        $this->paragraphs = new ArrayObject();
        $this->pre_prompt = $pre_prompt;
        $this->openai_api = new OpenAiApi($api_key, timeout: 10, stream_sleep: 0.1);
        $this->failure_sleep = $failure_sleep;
        $this->from_file = $from_file;
        $this->to_file = $to_file;
        $this->temperature = $temperature;
        $this->presence_penalty = $presence_penalty;
        $this->top_p = $top_p;
        $this->model = $model;

        $this->readText($this->from_file);
    }

    public function getParams($message)
    {

        $message = $this->pre_prompt . $message;
        $params = array(
            'model' => $this->model,
            'temperature' => $this->temperature,
            'presence_penalty' => $this->presence_penalty,
            'top_p' => $this->top_p,
            'n' => 1,
            'stream' => false,
            'messages' =>
            array(
                0 =>
                array(
                    'role' => 'user',
                    'content' => $message,
                ),
            ),
        );

        return $params;
    }

    public function translateString(string $message): ApiResult
    {

        $params = $this->getParams($message);
        $result = $this->openai_api->getChatCompletionsStream($params);
        return $result;
    }

    public function readText(string $filename)
    {
        $content = file_get_contents($filename);

        // Normalize all line endings to \n
        $content = str_replace(["\r\n", "\r"], "\n", $content);

        // Split on double line endings
        $paragraphs = preg_split("/\n\s*\n/", $content);

        foreach ($paragraphs as $para) {
            $para = trim($para);
            if (empty($para)) continue;
            $this->paragraphs[] = $para;
        }
    }

    public function translate()
    {

        $iterator = $this->paragraphs->getIterator();
        $iterator->seek(0);

        while ($iterator->valid()) {

            $key = $iterator->key();
            $para = $iterator->current();

            try {

                $result = $this->translateString($para);                
                if ($result->tokens_used == "0") {
                    throw new Exception("Tokens was 0");
                }
                $this->total_tokens += (int)$result->tokens_used;
                file_put_contents($this->to_file, $result->content . PHP_EOL . PHP_EOL, FILE_APPEND);
                echo " (Total tokens used: {$this->total_tokens})" . PHP_EOL . PHP_EOL;
                $iterator->next();
                $this->failure_iterations = 1;
            } catch (Exception $e) {
                echo "Error: " . PHP_EOL;
                echo $e->getMessage() . PHP_EOL;
                echo "Try again with key: $key" . PHP_EOL;
                sleep($this->failure_sleep * $this->failure_iterations);

                // Exponential backoff
                $this->failure_iterations = $this->failure_iterations * 2;
            }
        }

        echo "Translation complete." . PHP_EOL;
        echo "Total tokens used: $this->total_tokens" . PHP_EOL;
    }
}
