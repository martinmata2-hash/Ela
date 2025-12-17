<?php

namespace Marve\Ela\Core;

use Exception;

class JsonRpcClient {
    private string $url;
    private int $id = 1;
    private bool $useCurl;

    public function __construct(string $url, bool $useCurl = false) {
        $this->url = $url;
        $this->useCurl = $useCurl;
    }

    public function call(string $method, array $params = []) {
        $payload = json_encode([
            'jsonrpc' => '2.0',
            'method'  => $method,
            'params'  => $params,
            'id'      => $this->id++,
        ]);

        $response = $this->useCurl ? $this->callWithCurl($payload) : $this->callWithStream($payload);

        $result = json_decode($response, true);

        if (isset($result['error'])) {
            throw new Exception("RPC Error: " . json_encode($result['error']));
        }

        return $result['result'] ?? null;
    }

    private function callWithStream(string $payload): string {
        $options = [
            'http' => [
                'method'  => 'POST',
                'header'  => "Content-Type: application/json\r\n" .
                             "Content-Length: " . strlen($payload) . "\r\n",
                'content' => $payload,
                'timeout' => 10,
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($this->url, false, $context);

        if ($response === false) {
            throw new Exception("Stream request failed.");
        }

        return $response;
    }

    private function callWithCurl(string $payload): string {
        $ch = curl_init($this->url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
            CURLOPT_TIMEOUT        => 10,
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception("cURL error: " . curl_error($ch));
        }

        curl_close($ch);
        return $response;
    }
}
