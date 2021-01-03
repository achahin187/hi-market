<?php

namespace App\Notifications;
use App\Models\NotificationMobile;
use App\Models\Branch;

class SendNotification {

    public $device_token;
    public $order;
    public $data;

    public function __construct($device_token, $order, $data=[])
    {
        $this->device_token = $device_token;
        $this->order = $order;
        $this->data = $data;
        $device_token == 'topics' ? $this->sendNotificationOffer() : $this->sendNotificationOrder();
    }

    public function sendNotificationOrder()
    {



        $data = [

            "to" => $this->device_token,
            "data"=> $this->data,

            "notification" =>
                [
                    "title" => $this->getMessage($this->order, app()->getLocale()),
                    "body" => "Order Updates",
                    "icon" => $this->getIconeOrder($this->order),
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
        $result = curl_exec($ch);
        if($result == FALSE){
            die(curl_exec($ch));
        }

        curl_close($ch);
        #store notification To database
        $this->storeNotificationOrder();
    }

    public function sendNotificationOffer()
    {

        $data = [

            "to" => '/topics/Deals',
            "data"=> $this->data,

            "notification" =>
                [
                    "title" => 'New Offers In Delivertto, Check It Now',
                    "body" => 'New Offers In Delivertto, Check It Now',
                    "icon" => $this->getIconeOffer(1),
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
        $result = curl_exec($ch);
        if($result == FALSE){
            die(curl_exec($ch));
        }

        curl_close($ch);
        #store notification Offer To database
        $this->storeNotificationOffer();
    }

    public function getMessage($order,$lang)
    {
        $messages = [
             "en"=>[
                 0 => "New Order Created, waiting for Acceptance",
                 1 => "Your Order $order->num Was Accepted",
                 2 => "Your Order $order->num Was Process",
                 3 => "Your Order $order->num Was Pickup",
                 4 => "Your Order $order->num Was Delivered Rate Your Order",
                 5 => "Your Order $order->num was Cancelled",
                 null => ""
             ],
            "ar"=>[ 
                0 => "تم إنشاء طلب جديد",
                1 => "طلبك بإنتظار الموافقة رقم {$order->num} ",
                2 => "تم الموافقة على طلبك رقم {$order->num} ",
                3 => "طلبك رقم {$order->num} جاري",
                4 => "طلبك رقم {$order->num} جاري توصيله",
                5 => "تم توصيل طلبك رقم {$order->num}",
                6 => "تم إلغاء طلبك رقم $order->num",
                null => ""]

        ];

         return $messages[$lang][$order->status];
    }

    public function getIconeOrder($order)
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

         return $messages[$order->status];
    }

    public function getIconeOffer($order)
    {
        $messages = [

            1 => asset('notification_icons/box.png'),
            null => ""
        ];

         return $messages[$order];
    }

    public function storeNotificationOrder()
    {
         NotificationMobile::create([

                'title_ar'    => $this->getMessage($this->order,"ar"),
                'title_en'    => $this->getMessage($this->order,"en"),
                'body_ar'     => $this->getMessage($this->order,"ar"),
                'body_en'     => $this->getMessage($this->order,"en"),
                'type'        => $this->data['type'],
                'icon'        => $this->getIconeOrder($this->order),
                'order_id'    => $this->data['orderId']?? null,
                'client_id'   => $this->order->client_id?? null,
                'product_id'  => $this->data['product_id']?? null,
                'superMarket_id'    => $this->data['superMarket_id']?? null,

            ]);
    }

    public function storeNotificationOffer()
    {
         NotificationMobile::create([

                'title_ar'    => 'New Offers In '.'Delivered'. ', Check It Now',
                'title_en'    => 'New Offers In '.'Delivered'. ', Check It Now',
                'body_ar'     => 'New Offers In '.'Delivered'. ', Check It Now',
                'body_en'     => 'New Offers In '.'Delivered'. ', Check It Now',
                'type'        => $this->data['type'],
                'icon'        => $this->getIconeOffer(1),
                'order_id'    => $this->data['orderId']?? null,
                'client_id'   => $this->order->client_id?? null,
                'product_id'  => $this->data['product_id']?? null,
                'superMarket_id'    => $this->data['superMarket_id']?? null,

            ]);
    }

    public function getBranch()
    {
        Branch::where('id', $this->data['superMarket_id'])->first();
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
