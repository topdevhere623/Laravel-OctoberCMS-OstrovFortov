<?php
include_once(__DIR__ . '/alfabank.php');

class Payment {
    protected $cfg = array();

    public function __construct() {
        $cfg = include_once(__DIR__. '/config.php');
        if (is_array($cfg) && 0 === count(array_diff(['production', 'username', 'password'], array_keys($cfg)))) {
            $this->cfg = $cfg;
        } else {
            throw new Exception("Ошибка конфигурации");
        }
    }

    public function createOrder($id, $data) {

        include_once __DIR__ . "/../tickets/Api.php";
        $api = Api::getInstance();

        $order = $api->getOrder($id);
        if(!$order || !is_array($order)){
            return [
                'error' => "Order {$id} not found"
            ];
        }

        if($order['status'] != 'created'){
            return $order;
        }

        $client = new Client($this->cfg);

        $result = $client->send(array(
            'id' => $id,
            'hash' => md5($id),
            'cost' => $data['total'],
            'orderId' => $id
        ), 'https://'.$_SERVER['HTTP_HOST'].'/order/?status=success&id='.$id,
            'https://'.$_SERVER['HTTP_HOST'].'/order/?status=error&id='.$id);
        if (is_array($result) && isset($result['orderId']) && isset($result['formUrl'])) {

            return $api->saveOrder($id, [
                'formUrl' => $result['formUrl'],
                'paymentOrderId' => $result['orderId']
            ]);
        }
        
    }

    public function getOrder($orderId)
    {
        $client = new Client($this->cfg);
        return $client->receiver($orderId);;
    }
}