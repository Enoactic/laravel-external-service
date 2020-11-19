<?php

namespace LaravelExternalService;

class FirebaseCloudMessaging
{
    public static function sendToRegistrationId($key, $notification, $data, $registrationIds = array())
    {
        $requestObject = new \stdClass();
        $requestObject->priority = 'high';
        $requestObject->data = $data;
        $requestObject->notification = $notification;
        $requestObject->content_available = true;
        $requestObject->registration_ids = $registrationIds;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($requestObject),
            CURLOPT_HTTPHEADER => array(
                "Authorization: key=".$key,
                "Cache-Control: no-cache",
                "Connection: keep-alive",
                "Content-Type: application/json",
                "Host: fcm.googleapis.com",
                "accept-encoding: gzip, deflate",
                "cache-control: no-cache"
            ),
        ));
        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        if ($error)
        {
            return $error;
        }
        else
        {
            return $response;
        }
    }
}
