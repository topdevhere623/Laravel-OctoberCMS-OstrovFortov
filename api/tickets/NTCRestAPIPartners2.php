<?php
/**
 * REST API сервиса Нева Тревел Компани
 *
 * Created by Droids Digital
 * Version: 0.0.5
 * Date: 28.03.17
 */

class NoTicketsException extends Exception
{

}

class OldModuleException extends Exception {

}
/**
 * Class NTCRestApi для работы с системой продаж билетов на теплоходы компании Нева Тревел Компани
 */
class NTCRestPartnerApi
{
    /**
     * Убеждаемся что это единственный экземпляр класса
     *
     * @var null
     */
    private static $instance = null;
    private static $api_mode;
    private static $module_version = "0.0.7";

    private function __construct()
    {
    }

    /**
     * Создаем единственный экземпляр класса для работы по API
     *
     * @return NTCRestPartnerApi|null
     */
    public static function instance()
    {
        if (!self::$instance) {
            $config = include __DIR__.'/config.php';
            $mode = isset($config['mode']) ? $config['mode'] : 'dev';
            $settings = (isset($config['settings'][$mode]) ? $config['settings'][$mode] : $config['settings']['dev']);
            self::$api_mode = $settings['domain'];
            define("AUTH_KEY", $settings['key']);
            self::$instance = new NTCRestPartnerApi();
        }
        return self::$instance;
    }

    public static function getModuleVersion(){
        return self::$module_version;
    }

    /**
     * Включение тестового режима Sandbox
     */
    public function setSandboxMode()
    {
        //self::$api_mode = REST_DOMAIN_PROD;
    }

    /**
     * Получение ключа API
     *
     * @param $password
     */
    public function getAuthKey()
    {
        return AUTH_KEY;
    }

    /**
     * Получение списка рейсов
     *
     * @param string $start_date ГГГГ-ММ-ДД
     * @param string $program
     * @param string $pier
     * @return bool|mixed
     */
    public function getCruisesInfo($start_date = '', $program = '', $pier = '')
    {
        if ($start_date == '') {
            $start_date = date('Y-m-d');
        }

        try {
            $json = json_decode($this->request(self::$api_mode . "get_cruises_info?auth_key=" . AUTH_KEY . '&start_date=' . $start_date . '&program=' . $program . '&pier=' . $pier), true);
            return $json;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function getCruisesInfoURL($start_date = '', $program = '', $pier = '')
    {
        try {
            $json = self::$api_mode . "get_cruises_info?auth_key=" . AUTH_KEY . '&start_date=' . $start_date . '&program=' . $program . '&pier=' . $pier;
            return $json;
        } catch (Exception $ex) {
            echo 'ошибка';
            return false;
        }
    }

    /**
     * Получить информацию о доступных программах
     * @return bool|mixed
     */
    public function getProgramsInfo()
    {
        try {
            $json = json_decode($this->request(self::$api_mode . "get_programs_info?auth_key=" . AUTH_KEY), true);
            return $json;
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * Запрос списка теплоходов
     * @return bool|mixed
     */
    public function getShipsList()
    {
        try {
            $json = json_decode($this->request(self::$api_mode . "get_ships?auth_key=" . AUTH_KEY), true);
            return $json;
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * Отправить запрос на заказ
     *
     * @param array  $tickets - состав заказа вида {'full'=>количетво, 'half'=>, 'children'=>, 'attendant'=>}
     * @param string $back_cruise_id - если указано, то добавляются обратные билеты на указанный рейс
     * @param string $cruise_id - УИН рейса
     * @param string $cruise_date - дата круизов открытого времени (nil если обычный заказ)
     * @param string $program_id - айди рейса для заказа с открытом временем (nil для обычного заказа)
     * @param string $pier_id - айдюк причала для открытого времени (nil для обычного заказа)
     * @return bool|mixed
     */
    public function requestOrder($tickets = null, $back_cruise_id = '', $cruise_id = '', $cruise_date = '', $program_id = '', $pier_id = '')

    {
        try {
            $json = json_decode($this->request(self::$api_mode . "request_order?auth_key=" . AUTH_KEY . '&tickets=' . urlencode(json_encode($tickets)) . '&back_cruise_id=' . $back_cruise_id . '&cruise_id=' . $cruise_id . '&cruise_date=' . $cruise_date . '&program_id=' . $program_id . '&pier_id=' . $pier_id), true);
            return $json;
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * Подтверить заказ
     *
     * @param string $order_id (required) - УИН заказа
     * @param bool   $require_confirmation - требовать подтверждения заказа
     * @return bool|mixed
     */
    public function approveOrder($order_id, $require_confirmation = false)
    {
        try {
            $json = json_decode($this->request(self::$api_mode . "approve_order?auth_key=" . AUTH_KEY . '&order_id=' . $order_id . '&require_confirmation=' . $require_confirmation), true);
            return $json;
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * Отменить заказ
     *
     * @param string $order_id - УИН заказа
     * @param string $comment - Комментарий к отмене заказа
     * @return bool|mixed
     */
    public function rejectOrder($order_id, $comment)
    {
        try {
            $json = json_decode($this->request(self::$api_mode . "reject_order?auth_key=" . AUTH_KEY . '&order_id=' . $order_id . '&comment=' . $comment), true);
            return $json;
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * Добавить комментарий к заказу
     *
     * @param string $order_id - УИН заказа
     * @param string $comment - Комментарий к заказу
     * @return bool|mixed
     */
    public function commentOrder($order_id, $comment)
    {
        try {
            $json = json_decode($this->request(self::$api_mode . "comment_order?auth_key=" . AUTH_KEY . '&order_id=' . $order_id . '&comment=' . $comment), true);
            return $json;
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * Получить статус заказа
     *
     * @param string $order_id - УИН заказа
     * @return bool|mixed
     */
    public function getOrderStatus($order_id)
    {
        try {
            $json = json_decode($this->request(self::$api_mode . "get_order_status?auth_key=" . AUTH_KEY . '&order_id=' . $order_id), true);
            return $json;
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * Получить информацию о причалах
     */
    public function getPiersInfo()
    {
        try {
            $json = json_decode($this->request(self::$api_mode . "get_piers_info?auth_key=" . AUTH_KEY), true);
            return $json;
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * Получить статус сервиса API
     */
    public function get_api_status()
    {
        try {
            $json = json_decode($this->request(self::$api_mode . "get_api_status?auth_key=" . AUTH_KEY), true);
            if($json->version != self::$moduleVersion)
                throw new OldModuleException();

            return $json;
        } catch (Exception $ex) {
            return false;
        }
    }

    protected function request($url) {
        $curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        $query = curl_exec($curl_handle);
        curl_close($curl_handle);

        return $query;
    }
}