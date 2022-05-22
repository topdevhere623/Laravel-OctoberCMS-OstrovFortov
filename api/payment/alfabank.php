<?php
define('API_PROD_URL', 'https://pay.alfabank.ru/payment/rest/');
define('API_TEST_URL', 'https://web.rbsuat.com/ab/rest/');
class Client {
    protected $cfg = array();

    public function __construct($cfg = array()) {
        if (is_array($cfg)) {
            $this->cfg = $cfg;
            $this->cfg['gatewayUrl'] = $this->cfg['production'] ? API_PROD_URL : API_TEST_URL;
        }
    }

    /**
     * ФОРМИРОВАНИЕ ЗАКАЗА
     *
     * Метод register.do
     *
     * @param mixed[] Заказ
     * @return mixed[]
     */
    public function send($order = array(), $returnUrl = '', $failUrl = '')
    {
        $out = false;
        $id = $order['id'];

        if (RBS_TWO_STAGE === true) {
            $method = 'registerPreAuth.do';
        } else {
            $method = 'register.do';
        }

        $data = array(
            'orderNumber' => $id . '#' . time(),
            'amount' => round($order['cost'] * 100),
            'description' => ("Оплата заказа - " . $id),
            'userName' => $this->cfg['username'],
            'password' => $this->cfg['password'],
            'returnUrl' => $returnUrl,
            'failUrl' => $failUrl,
            'currency' => CURRENCY
        );
        $response = $this->gateway($method, $data);
        if (is_array($response) && isset($response['formUrl'])) {
            $out = $response;
        }

        return $out;
    }

    /**
     * ПЕРЕДАЧА ДАННЫХ В ШЛЮЗ
     *
     *
     * @param string - Название метода
     * @param array [] - Данные
     * @return mixed[]
     */
    public function gateway($method, $data)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->cfg['gatewayUrl'] . $method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_SSLVERSION => 6
        ));
        $response = curl_exec($curl);
        $response = json_decode($response, true);

        curl_close($curl);

        return $response;
    }

    /**
     * ПОЛУЧЕНИЕ ДАННЫХ О СТАТУСЕ ЗАКАЗА
     *
     * @param string id заказа в шлюзе
     */
    public function receiver($orderId)
    {

        $data = [
            'orderId' => $orderId,
            'userName' => $this->cfg['username'],
            'password' => $this->cfg['password'],
        ];

        $response = $this->gateway('getOrderStatusExtended.do', $data);

        return $response;
    }
}