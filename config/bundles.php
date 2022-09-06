<?php

return [
    Broadway\Bundle\BroadwayBundle\BroadwayBundle::class => ['all' => true],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => true],
    League\Tactician\Bundle\TacticianBundle::class => ['all' => true],
    HarmBandstra\SwaggerUiBundle\HBSwaggerUiBundle::class => ['all' => true],
    Sentry\SentryBundle\SentryBundle::class => ['all' => true],
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Symfony\Bundle\MonologBundle\MonologBundle::class => ['all' => true],
    Yoanm\SymfonyJsonRpcHttpServer\JsonRpcHttpServerBundle::class => ['all' => true],
    Yoanm\SymfonyJsonRpcParamsValidator\JsonRpcParamsValidatorBundle::class => ['all' => true],
    Yoanm\SymfonyJsonRpcHttpServerDoc\JsonRpcHttpServerDocBundle::class => ['all' => true],
    Yoanm\SymfonyJsonRpcParamsSfConstraintsDoc\JsonRpcParamsSfConstraintsDocBundle::class => ['all' => true],
    Yoanm\SymfonyJsonRpcHttpServerOpenAPIDoc\JsonRpcHttpServerOpenAPIDocBundle::class => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
    Nelmio\CorsBundle\NelmioCorsBundle::class => ['all' => true],
    InterNations\Bundle\DecoratorBundle\InterNationsDecoratorBundle::class => ['dev' => true, 'test' => true],
];
