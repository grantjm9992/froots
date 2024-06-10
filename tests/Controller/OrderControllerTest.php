<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderControllerTest extends WebTestCase
{
    public function testGetProductsForOrder()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/ld+json'],
            json_encode([
                'email' => 'user@example.com',
                'password' => 'testPassword',
            ])
        );

        $response = $client->getResponse()->getContent();
        $decodedResponse = json_decode($response, true);
        $token = $decodedResponse['token'];

        $client->request('GET', '/api/orders');
        $orderResponse = $client->getResponse()->getContent();

        $decodedOrderResponse = json_decode($orderResponse, true);
        $orderId = null;
        if (count($decodedOrderResponse['hydra:member']) > 0) {
            $order = $decodedOrderResponse['hydra:member'][0];
            $orderId = $order['id'];
        }

        if ($orderId) {
            $client->request(
                'GET',
                "/api/orders/$orderId/products",
                [],
                [],
                ['Authorization' => "Bearer $token"],
            );

            $this->assertEquals(200, $client->getResponse()->getStatusCode());

            $this->assertJson($client->getResponse()->getContent());

            $responseData = json_decode($client->getResponse()->getContent(), true);
            $this->assertArrayHasKey('products', $responseData);
            $this->assertNotEmpty($responseData['products']);
        }
    }
}
