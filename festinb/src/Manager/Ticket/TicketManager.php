<?php

namespace App\Manager\Ticket;

use App\Assembler\Ticket\TicketAssembler;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TicketManager
{
    private const ENDPOINT = 'http://localhost/api/tickets';

    public function __construct(
        private HttpClientInterface $client,
        private SerializerInterface $serializer,
        private TicketAssembler $ticketAssembler
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
                'body' => $this->serializer->serialize($ticket, 'json', ['options' => 'ticket_all']),
                'headers' => [
                    'Accept' => 'application/json',
                ]
            ]
        );

        return $response->getStatusCode();
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