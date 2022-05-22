<?php
include_once __DIR__ . '/../html/HtmlHelper.php';
$html = HtmlHelper::getInstance();
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
            'title' => 'Пошаговая инструкция по приобретению билетов'
        ]); ?>
        <section class="offer-services typography">
            <div class="typography__container container">
                <p>1. Выберите желаемую дату, причал и время отправления и нажмите кнопку «Купить билеты». Обратите внимание, что причал и время отправления взаимосвязаны, и ранее выбранные условия отправления могут быть изменены при выборе несовместимых данных.</p><img src="/img/form-main.svg" alt="Форма">
                <p>2. В открывшемся окне «корзины» убедитесь, что выбранные ранее данные в поле «Отправление туда» верны.
                <ul>
                    <li>Если вы хотите приобрести билет только в одном направлении, установите галочку в чекбоксе «Обратный билет не нужен» (по умолчанию чекбокс пустой):<img src="/img/checkbox-form.svg" alt="Обратный билет не нужен"></li>
                    <li>Если вы хотите приобрести билеты туда и обратно, выберите причал и время отправления обратного рейса в поле «Отправление обратно».</li>
                </ul>
                </p>
                <p>3. В поле «Количество билетов», установите необходимое количество билетов для каждой категории.</p>
                <ul>
                    <li>Льготные билеты могут быть приобретены для пенсионеров, студентов, учащихся, инвалидов и ветеранов, а также других льготных категорий граждан.</li>
                    <li>Детские билеты приобретаются на детей с 3 до 11 лет включительно. Детям до трех лет необходимо оформить бесплатный посадочный билет в кассе на причале перед посадкой на рейс.</li>
                </ul>
                <p>Обратите внимание, что перед посадкой на рейс вас могут попросить продемонстрировать документ, подтверждающий право на льготу: пенсионное удостоверение, студенческий или ученический билет и т.п.!</p>
                <p>4. В поле «Ваши данные» укажите адрес электронной почты и номер телефона для связи. На адрес электронной почты будет отправлен электронный номер заказа. Номер телефона необходим для оперативной связи с вами в случае переноса/отмены рейса.</p>
                <p>5. Проверьте состав заказа и сумму к оплате в поле справа, ознакомьтесь с офертой и условиями согласия на обработку персональных данных, установите галочку в чекбоксе и нажмите кнопку «Купить билеты». Вы будете перенаправлены на защищенную платежную страницу АО «АЛЬФА-БАНК», где вы сможете оплатить заказ одним из предложенных способов.</p>
                <p>6. После получения оплаты, на указанный вами адрес электронной почты будет выслан номер заказа, который необходимо перед посадкой на рейс  сообщить в кассе причала или ввести на стойке самостоятельной регистрации для получения посадочных билетов. Обратите внимание, что утерянные посадочные билеты восстановлению не подлежат!</p>
                <p><b>Способы оплаты</b></p>
                <p>Оплата заказов банковскими картами осуществляется через АО «АЛЬФАБАНК»<img src="/img/alfa.svg" alt="Alfa bank"></p>
                <p>К оплате принимаются банковские карты VISA, MasterCard и МИР.<img src="/img/bank-cards.svg" alt="Bank cards"></p>
                <p><b>Оплата заказа с использованием банковской карты</b></p>
                <p>Предоставляемая вами персональная информация (имя, адрес, телефон, email, номер банковской карты) является конфиденциальной и не подлежит разглашению. Данные вашей кредитной карты передаются только в зашифрованном виде и не сохраняются на нашем Web-сервере.</p>
                <p>Услуга оплаты через интернет осуществляется в соответствии с Правилами международных платежных систем Visa, MasterCard и Платежной системы МИР на принципах соблюдения конфиденциальности и безопасности совершения платежа, для чего используются самые современные методы проверки, шифрования и передачи данных по закрытым каналам связи. Ввод данных банковской карты осуществляется на защищенной платежной странице АО «АЛЬФА-БАНК».</p>
                <p>На странице для ввода данных банковской карты потребуется ввести данные банковской карты: номер карты, имя владельца карты, срок действия карты, трёхзначный код безопасности (CVV2 для VISA, CVC2 для MasterCard, Код Дополнительной Идентификации для МИР). Все необходимые данные пропечатаны на самой карте. Трёхзначный код безопасности — это три цифры, находящиеся на обратной стороне карты.</p>
                <p>Далее вы будете перенаправлены на страницу Вашего банка для ввода кода безопасности, который придет к Вам в СМС. Если код безопасности к Вам не пришел, то следует обратиться в банк выдавший Вам карту.</p>
                <p><b>Поддержка пользователей</b></p>
                <p>Свои вопросы, связанные с процессом оплаты, вы можете прислать на наш электронный ящик <a href="mailto:support@neva.travel">support@neva.travel</a> или позвонить по телефону <a href="tel:88005501200">8 (800) 550-12-00</a>.</p>
                <p><b>Случаи отказа в совершении платежа</b></p>
                <ul>
                    <li>Банковская карта не предназначена для совершения платежей через интернет, о чем можно узнать, обратившись в ваш Банк.</li>
                    <li>На вашей банковской карте недостаточно средств для проведения оплаты. Подробнее о наличии средств на банковской карте вы можете узнать, обратившись в банк, выпустивший банковскую карту.</li>
                    <li>Данные банковской карты введены неверно.</li>
                    <li>Истек срок действия вашей банковской карты. Срок действия карты, как правило, указан на лицевой стороне карты (это месяц и год, до которого действительна карта). Подробнее о сроке действия карты вы можете узнать, обратившись в банк, выпустивший банковскую карту.</li>
                </ul>
                <p><b>Порядок возврата билетов</b></p>
                <p>При оплате картами возврат наличными денежными средствами не допускается. Порядок возврата регулируется правилами международных платежных систем.</p>
                <p>Процедура возврата денежных средств за оказанные услуги регламентируется статьей 29 федерального закона «О защите прав потребителей», а также приказом Министерства транспорта Российской Федерации (Минтранс России) от 5 мая 2012 г. N 140 г. Москва "Об утверждении Правил перевозок пассажиров и их багажа на внутреннем водном транспорте" (пункты 36-43, а также 82 приказа)</p>
                <p>Из статьи 29 ФЗ «О защите прав потребителей»</p>
                <ul>
                    <li>Потребитель при обнаружении недостатков оказанной услуги вправе по своему выбору потребовать:
                        <ul>
                            <li>безвозмездного устранения недостатков оказанной услуги;</li>
                            <li>соответствующего уменьшения цены оказанной услуги;</li>
                            <li>возмещения понесенных им расходов по устранению недостатков выполненной оказанной услуги своими силами или третьими лицами.</li>
                        </ul>
                    </li>
                    <li>Удовлетворение требований потребителя о безвозмездном устранении недостатков, об изготовлении другой вещи или о повторном оказании услуги не освобождает исполнителя от ответственности в форме неустойки за нарушение срока окончания оказания услуги.</li>
                    <li>Потребитель вправе отказаться от исполнения договора об оказании услуги и потребовать полного возмещения убытков, если в установленный указанным договором срок недостатки оказанной услуги не устранены исполнителем.</li>
                    <li>Потребитель также вправе отказаться от исполнения договора о оказании услуги, если им обнаружены существенные недостатки оказанной услуги или иные существенные отступления от условий договора.</li>
                    <li>Потребитель вправе потребовать также полного возмещения убытков, причиненных ему в связи с недостатками оказанной услуги. Убытки возмещаются в сроки, установленные для удовлетворения соответствующих требований потребителя.</li>
                    <li>Требования потребителя об уменьшении цены за оказанную услугу, о возмещении расходов по устранению недостатков оказанной услуги своими силами или третьими лицами, а также о возврате уплаченной за услугу денежной суммы и возмещении убытков, причиненных в связи с отказом от исполнения договора, подлежат удовлетворению в десятидневный срок со дня предъявления соответствующего требования.</li>
                </ul>
                <p>Из правил перевозки пассажиров внутренним водным транспортом:</p>
                <ul>
                    <li>П. 36 Пассажир имеет право отказаться от поездки и вернуть приобретенный билет.</li>
                    <li>П. 37 При возврате билета до отхода судна пассажиру возвращается плата за проезд и провоз багажа.</li>
                    <li>П. 38 Возврат платы за проезд и провоз багажа (в случае сдачи багажа) после отхода судна из пункта отправления производится в следующих размерах:
                        <ul>
                            <li>в случае болезни, подтвержденной документами лечебного учреждения, плата за проезд и провоз багажа возвращается в полном объеме в течение трех суток со дня окончания указанного в документе лечебного учреждения периода болезни пассажира;</li>
                            <li>вследствие непреодолимой силы, то есть чрезвычайных и непредотвратимых при данных условиях обстоятельств, подтвержденных соответствующими документами компетентных органов, плата за проезд и провоз багажа возвращается в полном объеме в течение трех суток с момента окончания обстоятельств непреодолимой силы;</li>
                            <li>вследствие отмены предусмотренного расписанием отправления судна, изменения маршрута движения судна, а также в случае задержки отправления судна плата за проезд и провоз багажа возвращается в полном объеме;</li>
                            <li>при опоздании пассажира на судно билет принимается не позднее чем в течение трех часов после отправления судна и одного часа после отправления скоростного судна в рейс. При этом пассажиру возвращается половина платы за проезд и провоз багажа.</li>
                        </ul>
                    </li>
                    <li>П. 39 Плата за оказанные услуги по доставке билета возврату не подлежит.</li>
                    <li>П. 40 При отказе пассажира от перевозки на одном или нескольких участках маршрута в пути следования пассажиру возвращается плата за проезд и провоз багажа за не пройденный судном участок пути, определяемая как разница между полной стоимостью билета до первоначального пункта назначения и стоимостью билета до пункта  прекращения поездки. При прекращении поездки капитаном судна в билете делается отметка с указанием пункта, даты и времени прекращения перевозки и заверяется подписью капитана судна и судовой печатью. Возврат платы за проезд и провоз багажа производится по месту оплаты перевозки не позднее трех суток с момента прекращения поездки, указанного в отметке на билете. В случае приобретения билета на борту судна, возврат платы за проезд и провоз багажа за не пройденный судном участок пути может быть произведен на судне.</li>
                    <li>П. 41 Билет и (или) багажная квитанция, приобретенные на судне, могут быть возвращены до отхода судна в рейс, при этом пассажиру возвращается полная плата за проезд и (или) провоз багажа.</li>
                    <li>П. 42 Возврат платы за проезд и провоз багажа осуществляется по предъявлению пассажиром билета, документа, удостоверяющего личность, свидетельства о рождении (в случае возврата детского билета), в случае болезни - документа лечебного учреждения, в случае наступления обстоятельств непреодолимой силы - документа компетентных органов.</li>
                    <li>П. 43 Сданный пассажиром билет погашается путем перечеркивания его лицевой стороны, а на оборотной стороне делается отметка о дате и времени возврата билета с указанием суммы возвращенной платы за проезд и провоз багажа.</li>
                    <li>П. 82 В случае возврата билетов, пассажирами экскурсионнопрогулочных маршрутов применяется действие главы III настоящих Правил (примечание: выдержка из главы III правил, а именно пункты с 36 по 43, приведена выше).</li>
                </ul>
                <p>Для возврата денежных средств на банковскую карту необходимо заполнить «Заявление о возврате денежных средств», которое высылается по требованию компании на электронный адрес и оправить его вместе с приложением копии паспорта по адресу <a href="mailto:support@neva.travel">support@neva.travel</a></p>
                <p>Возврат денежных средств будет осуществлен на банковскую карту в течение 21 (двадцати одного) рабочего дня со дня получения «Заявление о возврате денежных средств» Компанией.</p>
                <p>Для возврата денежных средств по операциям проведенными с ошибками необходимо обратиться с письменным заявлением и приложением копии паспорта и чеков/квитанций, подтверждающих ошибочное списание. Данное заявление необходимо направить по адресу <a href="mailto:support@neva.travel">support@neva.travel</a></p>
                <p>Срок рассмотрения Заявления и возврата денежных средств начинает исчисляться с момента получения Компанией Заявления и рассчитывается в рабочих днях без учета праздников/выходных дней.</p>
                <?php $html->includeBlock('back-button'); ?>
            </div>
        </section>
    </main>
    <?php //include_once __DIR__.'/../html/blocks/modal.php'; ?>
</div>
<?php //$html->includeBlock('scripts'); ?>
</body>
</html>