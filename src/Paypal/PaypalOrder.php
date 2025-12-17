<?php 

namespace   Marve\Ela\Paypal;

use Marve\Ela\Core\Response;

class PaypalOrder
{
    private string $sandboxurlToken = "https://api-m.sandbox.paypal.com/v1/oauth2/token";
    private string $urlToken = "https://api-m.paypal.com/v1/oauth2/token";
    private string $sanboxurlOrder = "https://api-m.sandbox.paypal.com/v2/checkout/orders/";
    private string $urlOrder = "https://api-m.paypal.com/v2/checkout/orders/";
    
    private string $workingTokenUrl, $workinhOrderUrl;
    public function __construct(private string $clientID, private string $secret, private bool $prodution = false)
    {
        if($prodution)
        {
            $this->workingTokenUrl = $this->urlToken;
            $this->workinhOrderUrl = $this->urlOrder;
        }
        else
        {
            $this->workingTokenUrl = $this->sandboxurlToken;
            $this->workinhOrderUrl = $this->sanboxurlOrder;
        }
    }

    public function capture($orderID)
    {
        $access = $this->token();
        $jsonacces = json_decode($access);
        if($jsonacces->status != 200)
            return $access;
        $ch2 = curl_init($this->workinhOrderUrl."/$orderID/capture");

        curl_setopt_array($ch2, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => [
                "Authorization: Bearer $jsonacces->result",
                "Content-Type: application/json"
            ]
        ]);
        $response = curl_exec($ch2);
        curl_close($ch2);

        return $response;

    }
    public function create($total,$currency)
    {
        $access = $this->token();
        $jsonacces = json_decode($access);
        if($jsonacces->status != 200)
            return $access;
        $ch2 = curl_init($this->workinhOrderUrl);
        curl_setopt_array($ch2, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode([
                'intent' => 'CAPTURE',
                'purchase_units' => [[
                    'amount' => ['currency_code' => '$currency', 'value' => '$total']
                ]]
            ]),
            CURLOPT_HTTPHEADER     => [
                "Authorization: Bearer $jsonacces->result",
                "Content-Type: application/json"
            ]
        ]);
        $orderResponse = json_decode(curl_exec($ch2), true);
        curl_close($ch2);
        return $orderResponse;
    }

    private function token()
    {
           $auth = base64_encode("$this->clientID:$this->secret");            
            $ch = curl_init($this->workingTokenUrl);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS     => 'grant_type=client_credentials',
                CURLOPT_HTTPHEADER     => [
                    "Authorization: Basic $auth",
                    "Content-Type: application/x-www-form-urlencoded"
                ]
            ]);
            $tokenResponse = json_decode(curl_exec($ch), true);
            curl_close($ch);

            $accessToken = $tokenResponse['access_token'] ?? null;
            if (!$accessToken) {
                return Response::result(500,0,'Failed to retrieve access token');                
            }
            else return Response::result(200,$accessToken,'Success');                
    }
}




/**
 *
 * 
 * 
 * ejemplo de uso
index.php 

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PayPal Payment</title>
  <script src="https://www.paypal.com/sdk/js?client-id=1234"></script>
</head>
<body>
  <h2>Buy Now</h2>
  <div id="paypal-button-container"></div>

  <script>
   paypal.Buttons({
  createOrder: function(data, actions) {
    return fetch('/paypal/create-order.php', {
      method: 'POST'
    }).then(res => res.json()).then(data => data.id);
  },
  onApprove: function(data, actions) {
     console.log('onApprove data:', data);
    return fetch('/paypal/capture-order.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ orderID: data.orderID })
    }).then(res => res.json()).then(details => {
      alert('Transaction completed by ' + details.payer.name.given_name);
    });
  }
}).render('#paypal-button-container');
  </script>
</body>
</html> 

create-order.php

$production = false;
$PAYPAL = new PaypalOrder("clietID","secret",$production);
$response = $PAYPAL->create(1000,"USD");
if (!isset($response['id'])) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to create order']);
    exit;
}

echo json_encode(['id' => $orderResponse['id']]);


capture-order.php

$production = false;
$orderID  = json_decode(file_get_contents('php://input'), true)['orderID'];
$PAYPAL = new PaypalOrder("clietID","secret",$production);
echo $PAYPAL->capture($orderID);

 * 
 */

