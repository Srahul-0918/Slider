<?php

namespace App\Services;

use App\Model\AccessTokenModel;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;

class CallbackService
{
    private $Accm;

    public function __construct(AccessTokenModel $Accm)
    {
        $this->Accm = $Accm;

    }

    public function oauthCallback($request)
    {
        $authorisationCode = $request->query->get('code');
        if (!$authorisationCode) {
            return new Response('OAuth Callback: Authorization code not found.', 400);
        }

        $clientId = $_ENV['Client_Id'];
        $clientSecret = $_ENV['Client_Secret'];
        $redirectUri = $_ENV['Redirect_Uri'];
        $tokenUrl = $_ENV['Token_Uri'];

        // Define the scopes as a space-separated list
        $scopes = 'store_v2_products store_v2_orders'; // Add the required scopes here

        $client = HttpClient::create();
        $response = $client->request('POST', $tokenUrl, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'body' => [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'redirect_uri' => $redirectUri,
                'code' => $authorisationCode,
                'grant_type' => 'authorization_code',
                'scope' => $scopes, // Include the scopes in the request
            ],
        ]);


        if ($response->getStatusCode() !== 200) {
            return new Response('OAuth Callback: Failed to obtain access token.', $response->getStatusCode());
        }

        $data = $response->toArray();
        $accessToken = $data['access_token'];

        $this->Accm->StoreAccessToken($accessToken);

        return new Response('OAuth Callback: Successfully authenticated');
    }

    public function getBigCommerceData(string $apiEndpoint)
    {
        // Replace 'Bearer YOUR_ACCESS_TOKEN' with the actual access token from your database
        $accessToken = 'qx26o6ocifun14a1jcy9z98bve8dktf';

        // Define the API URL
        $apiUrl = 'https://api.bigcommerce.com/stores/store-bpsoqpypwh' . $apiEndpoint;

        // Make the API request
        $client = HttpClient::create();
        $response = $client->request('GET', $apiUrl, [
            'headers' => [
                'Authorization' => $accessToken,
                'Accept' => 'application/json', // Adjust based on the response format you need
            ],
        ]);
        dd($response);
        // Check the response status code
        if ($response->getStatusCode() === 200) {
            // Parse and process the API response (e.g., JSON decoding)
            $data = $response->toArray();
            dd($data);
            return $data;

            // Perform your application-specific logic with the API data
            // ...
        } else {
            // Handle API request errors appropriately
            // ...
        }
    }
}