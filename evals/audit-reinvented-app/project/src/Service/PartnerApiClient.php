<?php

namespace App\Service;

final class PartnerApiClient
{
    private const int MAX_ATTEMPTS = 5;

    public function __construct(private readonly string $baseUrl = 'https://partner.acme.test')
    {
    }

    /**
     * @return list<array{sku: string, price: float}>
     */
    public function fetchProducts(): array
    {
        $delayMicroseconds = 200_000;
        for ($attempt = 1; $attempt <= self::MAX_ATTEMPTS; ++$attempt) {
            $curl = curl_init($this->baseUrl.'/products');
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_HTTPHEADER => ['Accept: application/json'],
            ]);
            $body = curl_exec($curl);
            $status = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
            curl_close($curl);

            if (200 === $status && is_string($body)) {
                return json_decode($body, true, flags: JSON_THROW_ON_ERROR);
            }
            if ($status < 500) {
                throw new \RuntimeException(sprintf('The partner API answered %d.', $status));
            }

            usleep($delayMicroseconds);
            $delayMicroseconds *= 2;
        }

        throw new \RuntimeException('The partner API is not available.');
    }
}
