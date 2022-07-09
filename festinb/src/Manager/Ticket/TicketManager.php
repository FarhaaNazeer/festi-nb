<?php

namespace App\Manager\Ticket;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TicketManager
{
    private const ENDPOINT = 'http://localhost/api/tickets';

    public function __construct(
        private HttpClientInterface $client,
        private SerializerInterface $serializer
    ) {}

    public function get()
    {
        $response = $this->client->request(
            'GET',
            'http://localhost/api/tickets'
        );

        $jsonResponse = $response->toArray();
        return json_decode($jsonResponse[0]);
    }

    public function post($ticket)
    {

        $response = $this->client->request(
            'POST',
            self::ENDPOINT,
            [
                'body' => [
                    'data' => $this->serializer->serialize($ticket, 'json')
                ]
            ]
        );


        dd($response->getContent());
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }
}