<?php
include_once __DIR__ . '/NTCRestAPIPartners2.php';
include_once __DIR__ . '/../mail/Mail.php';

//use NTCRestPartnerApi;

class Api
{

    private $api;
    private static $instance;
    private $programsIData = [
        'to' => [//СПб-Кронштадт
            'id' => '2042335582784323670',
            'piers' => [//@todo: delete?
                6,
                3,
            ]
        ],
        'back' => [//Кронштадт-СПб
            'id' => '2516191244309233773',
            'piers' => [
                2516289667712679966,
                2587330112244416544
            ]
        ],
    ];
    private $programsList;
    private $piersList;
    private $cacheDir = '';
    private $ordersDir = '';

    private function __construct()
    {
        $this->api = NTCRestPartnerApi::instance();

        $this->cacheDir = __DIR__.'/cache';
        if(!is_dir($this->cacheDir)){
            mkdir($this->cacheDir);
        }
        $this->ordersDir = __DIR__.'/orders';
        if(!is_dir($this->ordersDir)){
            mkdir($this->ordersDir);
        }
    }

    public static function getInstance()
    {
        if(!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getPrograms()
    {
        if(!$this->programsList){
            $fileName = $this->getCacheFilename('programs'.date('m.Y'));
            if(file_exists($fileName)){
                $this->programsList = $this->getCache($fileName);
            } else {
                $this->programsList = $this->api->getProgramsInfo();
                $this->putCache($fileName, $this->programsList);
            }
        }
        return $this->programsList;
    }

    private function getProgramById($id)
    {
        $list = $this->getPrograms();
        $list = array_filter($list, function ($item) use ($id){
            return $item['id'] == $id;
        });
        if(!empty($list)){
            return array_shift($list);
        }
    }

//    private function getProgram()
//    {
//        $list = $this->getPrograms();
//        $list = array_filter($list, function ($item){
//            return $item['id'] == $this->programsIData['to']['id'];
//        });
//        return array_shift($list);
//    }
//
//    private function getBackProgram()
//    {
//        $list = $this->getPrograms();
//        $list = array_filter($list, function ($item){
//            return $item['id'] == $this->programsIData['back']['id'];
//        });
//        return array_shift($list);
//    }

    private function getPiers()
    {
        if(!$this->piersList){
            $this->piersList = $this->api->getPiersInfo();
        }
        return $this->piersList;
    }

//    public function getPiersTo()
//    {
//        $list = $this->getPiers();
//        $list = array_filter($list, function ($item){
//            return in_array($item['id'], $this->programsIData['to']['piers']);
//        });
//        return array_values($list);
//    }
//
//    public function getPiersBack()
//    {
//        $list = $this->getPiers();
//        $list = array_filter($list, function ($item){
//            return in_array($item['id'], $this->programsIData['back']['piers']);
//        });
//        return $list;
//    }

    public function getCruises($date = '', $program = '', $pier = '')
    {

        if($date){
            $date = date('Y-m-d', strtotime($date));
            $isToday = ($date == date('Y-m-d'));
        } else {
            $date = date('Y-m-d');
            $isToday = true;
        }

        $cacheFile = $this->getCacheFilename($date, $program, $pier);

        if($isToday){
            $this->deleteCache($cacheFile);
        } elseif(file_exists($cacheFile)){
            return $this->getCache($cacheFile);
        }

//        if(!$program){
//            $program = $this->programsIData['to']['id'];
//        }
//
//        if(!$pier){
//            $pier = $this->programsIData['to']['piers'][0];
//        }

        $res = $this->api->getCruisesInfo($date, $program, $pier);

        if(!$isToday){
            $this->putCache($cacheFile, $res);
        }
        return $res;
    }

    public function getCruisesTo($date = '', $program = '', $pier = '')
    {
        $program = ($program != ''? $program : $this->programsIData['to']['id']);
        $list = $this->getCruises($date, $program, $pier);
        if(is_array($list) && !empty($list)){
            $list = array_filter($list, function ($item) use ($program){
                return $item['program']['id'] == $program;
            });
            return array_values($list);
        }
    }

    public function getCruisesBack($date = '', $program = '', $pier = '')
    {
        $program = ($program != ''? $program : $this->programsIData['back']['id']);
        $list = $this->getCruises($date, $program, $pier);
        if(is_array($list) && !empty($list)){
            $list = array_filter($list, function ($item) use ($program){
                return $item['program']['id'] == $program;
            });
            return array_values($list);
        }
    }

    private function deleteCache($fileName)
    {
        if(file_exists($fileName)){
            unlink($fileName);
        }
    }

    private function putCache($fileName, $data)
    {
        file_put_contents($fileName, json_encode($data));
    }

    private function getCache($fileName)
    {
        $content = file_get_contents($fileName);
        return json_decode($content, 1);
    }

    private function getCacheKey($date, $program = '', $pier = '')
    {
        return md5($this->api->getAuthKey().$date.$program.$pier);
    }

    private function getCacheFilename($date, $program = '', $pier = '')
    {
        return $this->cacheDir.'/'.$this->getCacheKey($date, $program, $pier).'_'.strtotime(date('d.m.Y')).'.txt';
    }

//    public function getFirstCruise($date = '', $program = '', $pier = '')
//    {
//
//        $list = $this->getCruises($date, $program, $pier);
//        if(is_array($list) && !empty($list)){
//            return array_shift($list);
//        }
//    }

    private function hasCruise($date, $cruise)
    {
        $list = $this->getCruises($date);
        if(!empty($list)){
            $_cruises = array_filter($list, function ($item) use ($cruise){
                return $item['id'] == $cruise['id'];
            });
            return !empty($_cruises);
        }
    }

    public function approve($order_id, $require_confirmation = false)
    {
        return $this->api->approveOrder($order_id, $require_confirmation);
    }

    public function comment($order_id, $comment)
    {
        return $this->api->commentOrder($order_id, $comment);
    }

    public function order($date, $cruise, $backCruise, $tickets)
    {
        $res = [
            'status' => 'error',
            'message' => '',
        ];

        if($this->hasCruise($date, $cruise)){

            if($backCruise && !$this->hasCruise($date, $backCruise)){

                $res['message'] = 'back-cruise-not-found';
                return $res;

            }

            if(
                (!isset($tickets['full']) || $tickets['full'] <= 0)
                && (!isset($tickets['half']) || $tickets['half'] <= 0)
                && (!isset($tickets['children']) || $tickets['children'] <= 0)
            ){
                $res['message'] = 'empty-tickets';
                return $res;
            }

            if($tickets['children'] > 0 && ($tickets['full'] <= 0 && $tickets['half'] <= 0)){
                $res['message'] = 'children-tickets-only';
                return $res;
            }

            $order = $this->api->requestOrder($tickets, ($backCruise ? $backCruise['id'] : ''), $cruise['id']);//@todo: save

            if($order['status'] == 'success'){
                $res['status'] = 'success';
                $res['total'] = $this->getTotal($date, $cruise, $backCruise, $tickets);
                $res['order_id'] = $order['ticket_token'];
                $res['back_order_id'] = (isset($order['back_ticket_token']) ? $order['back_ticket_token'] : '');
                $prices = $this->getTotalPrices($date, $cruise, $backCruise, $tickets);
                $this->saveOrder($res['order_id'], [
                    'total' => $res['total'],
                    'prices' => $prices,
                    'status' => 'created',
                    'cruise' => $cruise,
                    'backCruise' => $backCruise,
                    'tickets' => $tickets,
                    'order_id' => $res['order_id'],
                    'back_order_id' => $res['back_order_id'],
                ]);
            } else {
                $res['status'] = $order['status'];
                $res['message'] = $order['message'];
            }


        } else {
            $res['message'] = 'cruise-not-found';
            return $res;
        }

        return $res;

    }

    private function getPricesByProgram($program, $prices = [], $back = false)
    {

        $p_prices = $program['prices']['cat1'] ?? [];

        foreach ($p_prices as $p_k => $p_price) {
            $p_prices[$p_k] = intval($p_price);
        }

        if($back){
            $back = (bool)$p_prices['type12'];// Флаг применения скидки за комбо туда-обратно
        }

        foreach ($prices as $k => $price) {
            if($price['count'] <= 0) continue;
            switch ($k) {
                case 'full':
                    if($back){
                        $prices[$k]['value'] += (($p_prices['type1'] - $p_prices['type13']) * $price['count']);
                    } else {
                        $prices[$k]['value'] += ($p_prices['type1'] * $price['count']);//Стоимость взрослого
                    }
                    break;
                case 'half':
                    if($back){
                        $prices[$k]['value'] += (($p_prices['type2'] - $p_prices['type14']) * $price['count']);
                    } else {
                        $prices[$k]['value'] += ($p_prices['type2'] * $price['count']);//Стоимость льготного
                    }
                    break;
                case 'children':
                    if($back){
                        $prices[$k]['value'] += (($p_prices['type3'] - $p_prices['type15']) * $price['count']);
                    } else {
                        $prices[$k]['value'] += ($p_prices['type3'] * $price['count']);//Стоимость детского
                    }
                    break;
            }
        }
        return $prices;
    }

    private function getTotalPrices($date, $cruise, $backCruise, $tickets)
    {
        $res = [];
        foreach ($tickets as $k => $ticket) {
            $res[$k] = [
                'count' => $ticket,
                'value' => 0,
            ];
        }
        if($this->hasCruise($date, $cruise)){
            if($backCruise && !$this->hasCruise($date, $backCruise)){
                return $res;
            }

            $program = $this->getProgramById($cruise['program']['id']);
            $res = $this->getPricesByProgram($program, $res);

            if($backCruise){
                $program = $this->getProgramById($backCruise['program']['id']);
                $res = $this->getPricesByProgram($program, $res, true);
            }

        }
        return $res;
    }

    public function getTotal($date, $cruise, $backCruise, $tickets)
    {
        $res = 0;
        $prices = $this->getTotalPrices($date, $cruise, $backCruise, $tickets);
        foreach ($prices as $price){
            $res += $price['value'];
        }
        return $res;
    }

    public function getOrder($id)
    {
        $file = $this->ordersDir.'/'.$id.'.txt';
        if(file_exists($file)){
            $content = file_get_contents($file);
            return json_decode($content, 1);
        }
    }

    public function saveOrder($id, $data)
    {
        $file = $this->ordersDir.'/'.$id.'.txt';
        if(file_exists($file)){
            $content = file_get_contents($file);
            $_data =  json_decode($content, 1);
            $data = array_merge($_data, $data);
        }
        file_put_contents($file, json_encode($data));
        return $data;
    }

    public function clearCache()
    {
        if (is_dir($this->cacheDir)) {
            if ($dh = opendir($this->cacheDir)) {

                $now = strtotime(date('d.m.Y'));

                while (($file = readdir($dh)) !== false) {
                    if(in_array($file, ['.', '..'])) continue;
                    $last_point = strrpos($file, '.');
                    $ext = substr($file, $last_point + 1);
                    if($ext == 'txt'){
                        $name = substr($file, 0, $last_point);
                        $arName = explode('_', $name);
                        if(count($arName) == 2){
                            if($arName[1] < $now){
                                unlink($this->cacheDir.'/'.$file);
                                echo "File {$this->cacheDir}/{$file} was deleted\n";
                            }
                        }
                    }
                }
                closedir($dh);
            }
        }
    }

    public function sendMailToUserByOrder($order_id)
    {
        if($order = $this->getOrder($order_id)){
            if(!isset($order['is_send_to_user'])){

                $systemOrder = $order['systemOrder'];
                $orderNumber = $systemOrder['number'];

                $mail = Mail::getInstance();
                $subject = "Ваш заказ подтвержден и успешно оплачен";

                $message = '<h3>Спасибо за ваш выбор! Ваш заказ подтвержден и успешно оплачен.</h3>';
                $message .= "<p><i>Номер заказа</i> - <b>№{$orderNumber}</b></p>";

                $message .= $this->getCruiseHtml($order['cruise'], $order['prices']);

                if($order['backCruise']){
                    $message .= '<h4>Обратное отправление.</h4>';

                    $systemOrder = $order['systemBackOrder'];
                    $orderNumber = $systemOrder['number'];

                    $message .= "<p><i>Номер заказа</i> - <b>№{$orderNumber}</b></p>";
                    $message .= $this->getCruiseHtml($order['backCruise'], $order['prices']);
                }

                $message .= '<br>';
                $message .= '<p>Посадка на теплоход осуществляется только по посадочным билетам. Билеты можно получить по номеру вашего заказа в кассе или стойке самостоятельной регистрации на любом причале компании не ранее, чем за сутки до отправления. </p>';
                $message .= '<p>Мы рекомендуем получать билеты не позднее, чем за 30 минут до начала рейса.</p>';
                $message .= '<p><strong>Обратите внимание! Посадка на теплоход от причала "Остров фортов" заканчивается за 20 минут до времени отправления теплохода!</strong></p>';
                $message .= '<p>Свои вопросы и предложения вы можете отправить на нашу электронную почту.</p>';
                $message .= '<div>По вопросам обслуживания и поддержки: support@neva.travel</div>';
                $message .= '<div>А также по телефону: 8 (800) 550-12-00</div>';
                $message .= '<p>Ждем вас на наших причалах и желаем приятной прогулки!</p>';

                $bcc = 'sales.site@ostrovfortov.com';

                if($mail->send($order['email'], $subject, $message, $bcc)){
                    $this->saveOrder($order_id, ['is_send_to_user' => 1]);
                    return true;
                }
            }
        }
    }

    public function getCruiseHtml($cruise, $prices)
    {

        $message = "<p><i>Маршрут:</i> {$cruise['program']['name']}</p>";

        $date = date('d.m.Y', strtotime($cruise['cruise_date'])).' '.$cruise['starting_time'];

        $message .= "<p><i>Дата и время отправления:</i> {$date}</p>";
        $message .= "<p><i>Причал отправления:</i> {$cruise['pier_departure']['name']}</p>";

        $totalTickets = 0;

        foreach ($prices as $k => $price){
            $totalTickets += $price['count'];
        }

        $message .= "<p><i>Количество билетов:</i> {$totalTickets}. Из них:</p>";

        $message .= '<ul>';
        foreach ($prices as $k => $price){
            switch ($k){
                case 'half':
                    $label = 'Льготных';
                    break;
                case 'children':
                    $label = 'Детских';
                    break;
                default:
                    $label = 'Взрослых';
            }
            $message .= "<li>{$label}: {$price['count']}</li>";
        }
        $message .= '</ul>';
        return $message;
    }

}