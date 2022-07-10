<?php

namespace App\Request\ParamConverter;

use App\Dto\Cart\CartDto;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

final class CartConverter implements ParamConverterInterface
{
    public function __construct(
        private SerializerInterface $serializer
    )
    {}

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        if(!$request->isMethod(Request::METHOD_POST)) {
            return false;
        }

        $cart = $this->serializer->deserialize($request->getContent(), CartDto::class, 'json');
        $request->attributes->set($configuration->getName(), $cart);

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getClass() === CartDto::class;
    }
}