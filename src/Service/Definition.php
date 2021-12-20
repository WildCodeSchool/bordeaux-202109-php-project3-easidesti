<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Exception;

class Definition
{
    public const API_ENTRY_POINT = 'https://fr.wikipedia.org/w/api.php?action=query&prop=extracts&format=json&exintro=&titles=';

    public const SUCCESS_STATUS = 200;

    private HttpClientInterface $client;

    public function __construct(HttpClient $client)
    {
        $this->client = $client::create();
    }

    public function generateDefinition(string $word): string
    {
        $response = $this->client->request('GET', self::API_ENTRY_POINT . $word);
        if ($response->getStatusCode() !== self::SUCCESS_STATUS) {
            throw new Exception('Error while fetching definition');
        }
        $definition = $this->buildSimpleDefinition($response->toArray());
        return $definition !== '.' ? $definition : 'Définition à rédiger';
    }

    private function buildSimpleDefinition(array $response): string
    {
        $completeDefinition  = $this->getFirstOccurence($response['query']['pages']);
        $cleanTagDefintion   = strip_tags($completeDefinition);
        $firstLineDefinition = explode('. ', $cleanTagDefintion)[0];
        $cleanEndOfLine      = str_replace('\n', '', $firstLineDefinition);
        return trim($cleanEndOfLine . '.');
    }

    private function getFirstOccurence(array $pages): string
    {
        $firstOccurence = array_shift($pages);
        return $firstOccurence['extract'];
    }
}
