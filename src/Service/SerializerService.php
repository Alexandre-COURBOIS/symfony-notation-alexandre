<?php


namespace App\Service;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SerializerService
{
    private array $encoders;

//    Use this to return serialized value :: return JsonResponse::fromJsonString($this->serializerService->SimpleSerializer($user,'json'));

    public function __construct()
    {
        $this->encoders = [new XmlEncoder(), new JsonEncoder()];
    }

    public function RelationSerializer($inputData, $outputFormatData): string
    {
        $encoders = $this->encoders;

        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getNom();
            },
        ];

        $normalizer = [new ObjectNormalizer(null, null, null, null, null, null, $defaultContext)];

        $serializer = new Serializer($normalizer, $encoders);

        $jsonContent = $serializer->serialize($inputData, $outputFormatData);

        return $jsonContent;
    }

    public function SimpleSerializer($inputData, $outFormatData): string
    {
        $encoders = $this->encoders;

        $normalizers = [new ObjectNormalizer()];

        $serializer= new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($inputData, $outFormatData);

        return $jsonContent;
    }

    public function SimpleSerializerUser($inputData, $outFormatData): string
    {
        $encoders = $this->encoders;

        $normalizers = [new ObjectNormalizer()];

        $serializer= new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($inputData, $outFormatData, [AbstractNormalizer::IGNORED_ATTRIBUTES => ['password','roles','token','salt','createdAt','updatedAt']]);

        return $jsonContent;
    }
}