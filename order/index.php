<?php
$status = $_GET['status'] ?? '';
$id = $_GET['id'] ?? '';
$paymentID = $_GET['orderId'] ?? '';
if(!$status || !$id || !$paymentID){
    header('Location: /');
}
$res = [
    'error' => '',
    'success' => false
];

$order = null;

include_once $_SERVER['DOCUMENT_ROOT'].'/api/payment/payment.php';
$payment = new Payment();
if($status == 'success'){
    include_once $_SERVER['DOCUMENT_ROOT'].'/api/tickets/Api.php';
    $api = Api::getInstance();
    $order = $api->getOrder($id);
    if(!$order){
        $res['error'] = "Заказ {$id} не найден";
    } else {
        if($order['status'] != 'paid'){
            $paymentOrder = $payment->getOrder($paymentID);
            if(!$paymentOrder){
                $res['error'] = "Order {$id} not found in payment system";
            } else {
                //1 - Предавторизованная сумма захолдирована (для двухстадийных платежей)
                //2 - Проведена полная авторизация суммы заказа
                if(intval($paymentOrder['errorCode']) == 0 && (in_array(intval($paymentOrder['orderStatus']), [1, 2]))){

                    $comment = '';
                    if(isset($order['name'])){
                        $comment .= 'Имя клиента: '.$order['name'];
                    }

                    if(isset($order['email'])){
                        if($comment){
                            $comment .= ', ';
                        }
                        $comment .= 'e-mail клиента: '.$order['email'];
                    }

                    if(isset($order['phone'])){
                        if($comment){
                            $comment .= ', ';
                        }
                        $comment .= 'контактный номер клиента: '.$order['phone'];
                    }

                    if($comment){
                        $comment = urlencode($comment);
                    }

                    $ticketsSystemOrder = $api->approve($id);
                    if($comment){
                        $api->comment($id, $comment);
                    }
                    $orderData = $api->saveOrder($id, [
                        'formUrl' => '',
                        'systemOrder' => $ticketsSystemOrder,
                        'status' => 'paid'
                    ]);
                    if(isset($order['back_order_id']) && $order['back_order_id'] != ''){
                        $backOrderId = intval($order['back_order_id']);
                        if($backOrderId > 0){
                            $ticketsSystemBackOrder = $api->approve($backOrderId);
                            if($comment){
                                $api->comment($backOrderId, $comment);
                            }
                            $orderData = $api->saveOrder($id, [
                                'formUrl' => '',
                                'systemBackOrder' => $ticketsSystemBackOrder,
                                'status' => 'paid'
                            ]);
                        }
                    }
                    //Send mail to user
                    $api->sendMailToUserByOrder($id);

                    $res['success'] = true;
                } else {
                    $res['error'] = $paymentOrder['actionCodeDescription'];
                }
            }
        } else {
            $res['success'] = true;
        }
    }
} else {
    $paymentOrder = $payment->getOrder($paymentID);
    $res['error'] = $paymentOrder['actionCodeDescription'];
}

include_once __DIR__ . '/../html/HtmlHelper.php';
$html = HtmlHelper::getInstance();

$title = ($res['success'] ? 'Спасибо за ваш выбор! Ваш заказ подтвержден и успешно оплачен.' : $res['error']);
$order = (isset($orderData) ? $orderData : $order);
//include_once __DIR__.'/../html/blocks/data.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <?php $html->includeBlock('head'); ?>
</head>
<body>
<div class="wrapper">
    <main>
        <?php $html->includeBlock('header_in', [
            'title' => $title
        ]); ?>
        <section class="offer-services typography">
            <div class="typography__container container">
                <?php if($res['error'] != ''): ?>
                    <p><?php echo $res['error']; ?></p>
                <?php elseif($order):
                    $orderDate = date('d.m.Y', strtotime($order['cruise']['cruise_date']));
                    //$program = $order['cruise']['program']['name'];
                    $pier = $order['cruise']['pier_departure']['name'];
                    $time = $order['cruise']['starting_time'];
                    ?>
                    <p>
                        <i>Номер заказа: <b>№<?php echo $order['systemOrder']['number']; ?></b></i>
                    </p>
                    <?php
                    echo $api->getCruiseHtml($order['cruise'], $order['prices']);
                    ?>
                    <?php if($order['backCruise']): ?>
                        <h4>Отправление обратно:</h4>
                        <p>
                            <i>Номер заказа: <b>№<?php echo $order['systemBackOrder']['number']; ?></b></i>
                        </p>
                        <?php
                        echo $api->getCruiseHtml($order['backCruise'], $order['prices']);
                    endif; ?>
                    <br>
                    <br>
                    <p>Посадка на теплоход осуществляется только по посадочным билетам. Билеты можно получить по номеру вашего заказа в кассе или стойке самостоятельной регистрации на любом причале компании.</p>
                    <p>Номер вашего заказа и информация о получении посадочных билетов отправлены на электронную почту, указанную при покупке.</p>
                <?php else: ?>
                    <p>Неверные параметры запроса!</p>
                <?php endif; ?>
                <?php $html->includeBlock('back-button'); ?>
            </div>
        </section>
    </main>
    <?php //include_once __DIR__.'/../html/blocks/modal.php'; ?>
</div>
<?php //$html->includeBlock('scripts'); ?>
</body>
</html>

