<?php

namespace App\Notifications;


class SendNotification {

    public $device_token;
    public $order_status;
    public $data=[];

    public function __construct($device_token, $order_status, $data=[])
    {
        $this->device_token = $device_token;
        $this->order_status = $order_status;
        $this->data[] = $data;
        $this->testNotification();
    }

    public function testNotification()
    {

        $data = [

            "to" => $this->device_token,
            "data"=> $this->data,

            "notification" =>
                [
                    "title" => $this->getMessage(),
                    "body" => "Sample Notification",
                    "icon" => $this->getIcone(),
                    "requireInteraction" => true,
                    "click_action"=> "HomeActivity",
                    "android_channel_id"=> "fcm_default_channel",
                    "high_priority"=> "high",
                    "show_in_foreground"=> true
                ],

            "android"=>
                [
                 "priority"=>"high",
                ],

                "priority" => 10,
                    "webpush"=> [
                          "headers"=> [
                            "Urgency"=> "high",
                          ],
                    ],
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=AAAAT5xxAlY:APA91bHptl1T_41zusVxw_wJoMyOOCozlgz2J4s6FlwsMZgFDdRq4nbNrllEFp6CYVPxrhUl6WGmJl5qK1Dgf1NHOSkcPLRXZaSSW_0TwlWx7R3lY-ZqeiwpgeG00aID2m2G22ZtFNiu',
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        curl_exec($ch);

        return response()->json('send');
    }


    public function getMessage()
    {
        $messages = [
            0 => "New Order Created",
            1 => "Your Order $order->num was Pending",
            2 => "Your Order $order->num Was Accepted",
            3 => "Your Order $order->num Was Process",
            4 => "Your Order $order->num Was Pickup",
            5 => "Your Order $order->num Was Delivered Rate Your Order",
            6 => "Your Order $order->num was Cancelled",
            null => ""
        ];

         return $messages[$this->order_status];
    }

     public function getIcone()
    {
        $messages = [
            0 => asset('notification_icons/box.png'),
            1 => asset('notification_icons/box.png'),
            2 => asset('notification_icons/box.png'),
            3 => asset('notification_icons/box.png'),
            4 => asset('notification_icons/delivery-bike.png'),
            5 => asset('notification_icons/delivery-man.png'),
            6 => asset('notification_icons/box.png'),
            null => ""
        ];

         return $messages[$this->order_status];
    }

   
 
 
}

// Tests


// $pointLocation = new pointLocation();
// $points = array("50 70","70 40","-20 30","100 10","-10 -10","40 -20","110 -20");
// $polygon = array("-50 30","50 70","100 50","80 10","110 -10","110 -30","-20 -50","-30 -40","10 -10","-10 10","-30 -20","-50 30");
// // The last point's coordinates must be the same as the first one's, to "close the loop"
// foreach($points as $key => $point) {
//     echo "point " . ($key+1) . " ($point): " . $pointLocation->pointInPolygon($point, $polygon) . "<br>";
// }

// Results 
/*
This will output:
point 1 (50 70): vertex
point 2 (70 40): inside
point 3 (-20 30): inside
point 4 (100 10): outside
point 5 (-10 -10): outside
point 6 (40 -20): inside
point 7 (110 -20): boundary
*/