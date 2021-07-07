<?php

declare(strict_types=1);

namespace My\Listener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class ViewListener
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function onKernelView(ViewEvent $event): void
    {
        if ($event->getResponse() !== null) {
            return;
        }

        $result = $event->getControllerResult();

        $json = $this->serializer->serialize($result, JsonEncoder::FORMAT, array_merge([
            'json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS,
        ]));

        $event->setResponse(new JsonResponse($json, JsonResponse::HTTP_OK, [], true));
    }
}
