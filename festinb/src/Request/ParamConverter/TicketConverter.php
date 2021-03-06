<?php

namespace App\Request\ParamConverter;

use App\Dto\Ticket\TicketDto;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

final class TicketConverter implements ParamConverterInterface
{
    public function __construct(
        private SerializerInterface $serializer
    )
    {}

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $ticket = $this->serializer->deserialize($request->getContent(), TicketDto::class, 'json');
        $request->attributes->set($configuration->getName(), $ticket);

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getName() === TicketDto::class;
    }
}