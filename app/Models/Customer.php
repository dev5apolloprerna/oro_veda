<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;

class Customer extends Model
{
    use HasFactory;
    public $table = 'customer';
    protected $primaryKey = 'customerid';
    public $incrementing = true; // if it's auto-incrementing
    protected $keyType = 'int';  // or 'string' if it's UUID
    protected $fillable = [
        'firstname',
        'lastname',
        'customername',
        'password',
        'customermobile',
        'customeremail',
        'iStatus',
        'isDelete',
        'created_at',
        'updated_at',
        'strIP',
        'token',
        'guid',
        'otp',
        'otp_expires_at',
        'address',
        'address1',
        'state',
        'city',
        'pincode',
        'country',
        'remember_token',
    ];

    //WhatsappMessage
    public function WhatsappMessage($mobile, $msg)
    {
        // API endpoint
        $url = "https://newweb.technomantraa.com/api/send";

        $data = Setting::where(['iStatus' => 1, 'isDelete' => 0, 'id' => 1])->first();
        $instance_id = $data->instance_id;
        // Data to be sent in JSON format
        $data = [
            "number" => "91" . $mobile,
            "type" => "text",
            "message" => $msg,
            "instance_id" => $instance_id, // Use your actual instance_id
            "access_token" => "66bc41d2ab5ba" // Use your actual access_token
        ];

        // Initialize cURL session
        $ch = curl_init($url);

        // Set cURL options
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        // Execute cURL request
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            throw new Exception('Curl error: ' . $error_msg);
        }

        // Close cURL session
        curl_close($ch);

        // Decode the JSON response
        $result = json_decode($response, true);

        // Return the result
        return $result;
    }

    public function sendWhatsappMessage($mobile, $msgText)
    {
        $client = new Client();
        $apiKey = 'hUqDEJgs8INPj8WQaJT8WKwNYk';
        $senderID = 'TWFASH';
        $smsType = '2';
        $entityID = '1701172008749013160';
        $templateID = '1707172104144059732';

        $url = "https://web.shreesms.net/API/SendSMS.aspx";
        $params = [
            'APIkey' => $apiKey,
            'SenderID' => $senderID,
            'SMSType' => $smsType,
            'Mobile' => $mobile,
            'MsgText' => $msgText,
            'EntityID' => $entityID,
            'TemplateID' => $templateID,
        ];

        try {
            $response = $client->request('GET', $url, ['query' => $params]);
            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            // Handle error
            return $e->getMessage();
        }
    }

    public function tirupatiMsg($MobileNumber, $docketNo)
    {
        $message = "https://web.shreesms.net/API/SendSMS.aspx?APIkey=hUqDEJgs8INPj8WQaJT8WKwNYk&SenderID=TWFASH&SMSType=2&Mobile=" . $MobileNumber . "&MsgText=Dear Customer, Click on the link below to track your order: http://www.shreetirupaticourier.net/Frm_DocTrack.aspx?docno=" . $docketNo . " Regards , Team The Wardrobe&EntityID=1701172008749013160&TemplateID=1707172128734984535";
        return $this->sendMessage1($message);
    }

    public function delhiveryMsg($MobileNumber, $docketNo)
    {
        $message = "https://web.shreesms.net/API/SendSMS.aspx?APIkey=hUqDEJgs8INPj8WQaJT8WKwNYk&SenderID=TWFASH&SMSType=2&Mobile=" . $MobileNumber . "&MsgText=Dear Customer, Click on the link below to track your order: http://www.delhivery.com/track/package/" . $docketNo . " Regards , Team The Wardrobe Fashion&EntityID=1701172008749013160&TemplateID=1707172128729766008";
        return $this->sendMessage1($message);
    }



    private function sendMessage($mobile, $msgText, $templateID)
    {
        $client = new Client();
        $apiKey = 'hUqDEJgs8INPj8WQaJT8WKwNYk';
        $senderID = 'TWFASH';
        $smsType = '2';
        $entityID = '1701172008749013160';

        $url = "https://web.shreesms.net/API/SendSMS.aspx";
        $params = [
            'APIkey' => $apiKey,
            'SenderID' => $senderID,
            'SMSType' => $smsType,
            'Mobile' => $mobile,
            'MsgText' => $msgText,
            'EntityID' => $entityID,
            'TemplateID' => $templateID,
        ];

        try {
            $response = $client->request('GET', $url, ['query' => $params]);
            $responseBody = $response->getBody()->getContents();

            return $responseBody;
        } catch (RequestException $e) {
            // Handle error
            Log::error("Failed to send SMS to {$mobile}: " . $e->getMessage());
            return $e->getMessage();
        }
    }

    private function sendMessage1($msgText)
    {
        $client = new Client();


        try {
            $response = $client->request('GET', $msgText);
            $responseBody = $response->getBody()->getContents();

            return $responseBody;
        } catch (RequestException $e) {
            // Handle error
            // Log::error("Failed to send SMS to {$mobile}: " . $e->getMessage());
            return $e->getMessage();
        }
    }
}
