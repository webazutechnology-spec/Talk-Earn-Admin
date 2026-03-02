<?php

namespace App;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'Talknearn API',
    version: '1.0.0',
    description: 'Talknearn API Documentation'
)]
#[OA\Server(
    url: '/api/v1',
    description: 'Talknearn API V1 Base URL'
)]
#[OA\SecurityScheme(
    securityScheme: 'bearer',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'JWT'
)]
class OpenApi
{
}
