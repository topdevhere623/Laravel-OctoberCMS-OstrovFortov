<?php

$result = [
    'errors' => []
];

$date = ($_POST['date'] ? trim($_POST['date']) : null);
$action = ($_POST['action'] ? trim($_POST['action']) : null);

if(!$action){
    $result['errors'][] = 'action';
}

if(!$date){
    $result['errors'][]= 'date';
}

function _clear_str($srt){
    return trim(strip_tags($srt));
}

if(empty($result['errors'])){
    include __DIR__ . '/Api.php';
    $api = Api::getInstance();

    switch ($action){
        case 'update-cruises':

            $program_to = (isset($_POST['program_to']) ? strval($_POST['program_to']) : '');

            $result['data'] = [
                'to' => $api->getCruisesTo($date, $program_to),
                'back' => $api->getCruisesBack($date),
            ];
            break;
        case 'order':

            $phone = _clear_str($_POST['phone']) ?? '';
            $email = _clear_str($_POST['email']) ?? '';

            if(!$phone){
                $result['errors'][] = 'empty-phone';
                break;
            }

            if(!$email){
                $result['errors'][] = 'empty-email';
                break;
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $result['errors'][] = 'invalid-email';
                break;
            }

            if(!isset($_POST['cruise']) || !is_array($_POST['cruise']) || empty($_POST['cruise'])){
                $result['errors'][] = 'empty-cruise';
                break;
            }
            if(!isset($_POST['tickets']) || !is_array($_POST['tickets']) || empty($_POST['tickets'])){
                $result['errors'][] = 'empty-tickets';
                break;
            }

            $cruise = $_POST['cruise'];
            $backCruise = $_POST['backCruise'];
            $tickets = $_POST['tickets'];

            if($api->getTotal($date, $cruise, $backCruise, $tickets) !== intval($_POST['total'])){
                $result['errors'][] = 'invalid-total';
                $result['totals'] = [
                    $api->getTotal($date, $cruise, $backCruise, $tickets),
                    intval($_POST['total'])
                ];
                break;
            }

            $result['data'] = $api->order($date, $cruise, $backCruise, $tickets);
            if($result['data']['status'] == 'success'){

                $api->saveOrder($result['data']['order_id'], [
                    'phone' => $phone,
                    'email' => $email,
                    'name' => (isset($_POST['name']) ? _clear_str($_POST['name']) : ''),
                ]);

                include_once __DIR__. '/../payment/payment.php';
                $payment = new Payment();
                $res = $payment->createOrder($result['data']['order_id'], [
                    'total' => $result['data']['total']
                ]);
                $result['data']['payment'] = $res;
            }

            break;
        default:
            $result['errors'][] = 'bad-action';
    }

}



echo json_encode($result);