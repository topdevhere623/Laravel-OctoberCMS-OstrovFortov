<?php
include_once __DIR__ . '/html/HtmlHelper.php';
$html = HtmlHelper::getInstance();
include_once __DIR__.'/html/blocks/data.php';
?>
<!DOCTYPE html>
<html lang="ru">
    <?php $html->includeBlock('head'); ?>
  <body>
    <div class="wrapper">
        <?php $html->includeBlock('header'); ?>
      <main>
        <section class="promo">
            <div class="promo__bg-video">
                <video autoplay="autoplay" loop="loop" muted="muted" playsinline="" preload="auto" width="1423" height="800">
                    <source src="/img/promo/promo-video-3.mp4" type="video/mp4">
                </video>
            </div>
            <div class="promo__bg-img"><img src="/img/promo/promo-img.jpg" alt="Катер"></div>
          <div class="promo__container container">
            <div class="promo__logo-block"><a class="promo__logo-kronstadt" href="#!"><img src="/img/promo/kronstadt.svg" alt="Kronstadt" width="106" height="118"></a><a class="promo__logo-neva-travel" href="#!"><img src="/img/promo/neva-travel.svg" alt="Neva travel" width="130" height="47"></a></div>
            <h1 class="promo__title">Метеоры в Кронштадт до «Острова фортов»</h1>
            <p class="promo__text">Метеоры в Кронштадт — самый быстрый и комфортный способ добраться из центра Петербурга в город Морской славы и посетить музейно-исторический парк «Остров фортов»</p>
          </div>
        </section>
        <section class="buy-tickets">
          <div class="buy-tickets__container container">
            <form class="buy-tickets__form" id="small-form" data-cruises-to='<?php echo json_encode($cruisesTo); ?>' data-date="{{ date("d/m/Y") }}" data-cruises-back='<?php echo json_encode($cruisesBack); ?>'>
              <ul class="buy-tickets__list">
                <li class="buy-tickets__item">
                  <label class="buy-tickets__date-label" for="date">Дата</label>
                  <input class="buy-tickets__date buy-tickets__field" type="text" name="date-form-main" value="{{ date("d/m/Y") }}" data-datepicker readonly>
                  <svg class="buy-tickets__date-svg" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 10H7V12H9V10ZM13 10H11V12H13V10ZM17 10H15V12H17V10ZM19 3H18V1H16V3H8V1H6V3H5C3.89 3 3 3.9 3 5V19C3 19.5304 3.21071 20.0391 3.58579 20.4142C3.96086 20.7893 4.46957 21 5 21H19C19.5304 21 20.0391 20.7893 20.4142 20.4142C20.7893 20.0391 21 19.5304 21 19V5C21 4.46957 20.7893 3.96086 20.4142 3.58579C20.0391 3.21071 19.5304 3 19 3ZM19 19H5V8H19V19Z" fill="#2D5FA6"></path>
                  </svg>
                </li>
                <li class="buy-tickets__item custom-select custom-select--slide-up" data-select="" data-name="palce-form-main" data-id="palce-form-main"><span class="buy-tickets__place-label">Откуда</span>
                  <button class="buy-tickets__date buy-tickets__field custom-select__button" type="button" aria-label="Выберите одну из опций"><span class="custom-select__text" v-text="(pier ? pier.name : (totalCruises > 0 ? 'Выберите одну из опций' : 'Рейсы не найдены'))"></span>
                    <svg class="buy-tickets__date-svg custom-select__icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M7.41 8.58008L12 13.1701L16.59 8.58008L18 10.0001L12 16.0001L6 10.0001L7.41 8.58008Z" fill="#2D5FA6"></path>
                    </svg>
                  </button>
                  <div v-show="totalCruises > 0" class="buy-tickets__place-list custom-select__list">
                    <div v-show="piersTo.length > 0" class="place-list__block" data-place="Спб">
                      <p>Из Санкт-Петербурга:</p>
                      <ul role="listbox">
                          <li v-for="pierItem, key in piersTo" :data-index="key" @click="setPier(pierItem)" class="custom-select__item" tabindex="0" :data-select-value="pierItem.id" :aria-selected="(pierItem.selected ? 'true' : 'false')" role="option" v-text="pierItem.name"></li>
                      </ul>
                    </div>
                    <div v-show="piersBack.length > 0" class="place-list__block" data-place="Кронштадт">
                      <p>Из Кронштадта:</p>
                      <ul role="listbox">
                          <ul role="listbox">
                              <li v-for="pierItem, key in piersBack" @click="setPier(pierItem)" class="custom-select__item" tabindex="0" :data-select-value="pierItem.id" :aria-selected="(pierItem.selected ? 'true' : 'false')" role="option" v-text="pierItem.name"></li>
                          </ul>
                      </ul>
                    </div>
                  </div>
                </li>
                <li class="buy-tickets__item custom-select custom-select--slide-up" data-select="" data-name="time-form-main" data-id="time-form-main"><span class="buy-tickets__place-label">Время отправления</span>
                  <button class="buy-tickets__time buy-tickets__field custom-select__button" type="button" aria-label="Выберите одну из опций"><span class="custom-select__text" v-text="(cruise ? cruise.starting_time : 'Выбрать')"></span>
                    <svg class="buy-tickets__date-svg custom-select__icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M7.41 8.58008L12 13.1701L16.59 8.58008L18 10.0001L12 16.0001L6 10.0001L7.41 8.58008Z" fill="#2D5FA6"></path>
                    </svg>
                  </button>
                  <ul v-show="times.length > 0" class="buy-tickets__time-list custom-select__list" role="listbox"><!--aria-selected="true"-->
                    <li v-for="time in times" @click="setCruise(time.cruise)" class="custom-select__item buy-tickets__time-item" tabindex="0" data-select-value="time.time" :aria-selected="(cruise && cruise.id == time.cruise_id) ? 'true' : 'false'" role="option" v-text="time.time"></li>
                  </ul>
                </li>
                <li class="buy-tickets__item">
                  <button class="buy-tickets__btn button" :disabled="(cruise == null)" type="submit" data-modal="ticket">Купить билеты</button>
                </li>
              </ul>
            </form>
          </div>
        </section>
        <section class="ticket-price">
          <div class="ticket-price__container container">
            <h2 class="ticket-price__title title" id="ticket-price">Стоимость билетов</h2>
            <div class="ticket-price__table-container">
              <table class="ticket-price__table">
                <thead>
                  <tr>
                    <td>
                      <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.3137 29.5703L33.5702 17.3138L32.5074 16.2509C31.0562 16.5095 29.5061 16.0781 28.3848 14.9568C27.2634 13.8354 26.832 12.2854 27.0906 10.8342L26.0278 9.77132L24.6667 11.1324L22.8033 9.22452L24.1421 7.8857C25.1835 6.8443 26.872 6.8443 27.9134 7.8857L30.2704 10.2427C29.4893 11.0238 29.4893 12.2901 30.2704 13.0711C31.0514 13.8522 32.3178 13.8522 33.0988 13.0711L35.4558 15.4282C36.4972 16.4696 36.4972 18.158 35.4558 19.1994L23.1993 31.4559C22.1579 32.4973 20.4695 32.4973 19.4281 31.4559L21.3137 29.5703Z" fill="black"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.0278 10.8353L5.77124 23.0918L6.83411 24.1547C8.28529 23.8961 9.83534 24.3275 10.9567 25.4488C12.078 26.5702 12.5094 28.1202 12.2508 29.5714L13.3137 30.6343L25.5702 18.3778L24.5074 17.3149C23.0562 17.5735 21.5061 17.1421 20.3848 16.0207C19.2634 14.8994 18.832 13.3493 19.0906 11.8982L18.0278 10.8353ZM19.9134 8.94966C18.872 7.90826 17.1835 7.90826 16.1421 8.94966L3.88562 21.2062C2.84422 22.2476 2.84422 23.936 3.88562 24.9774L6.24264 27.3344C7.02369 26.5534 8.29002 26.5534 9.07107 27.3344C9.85212 28.1155 9.85212 29.3818 9.07107 30.1629L11.4281 32.5199C12.4695 33.5613 14.1579 33.5613 15.1993 32.5199L27.4558 20.2634C28.4972 19.222 28.4972 17.5335 27.4558 16.4921L25.0988 14.1351C24.3178 14.9162 23.0514 14.9162 22.2704 14.1351C21.4893 13.3541 21.4893 12.0877 22.2704 11.3067L19.9134 8.94966Z" fill="black"></path>
                      </svg>
                    </td>
                    <td class="ticket-price__adult">Взрослый</td>
                    <td class="ticket-price__preferential">Льготный</td>
                    <td class="ticket-price__childish">Детский</td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="ticket-price__name">В одну сторону</td>
                    <td class="ticket-price__adult">1 100<span class="ruble">q</span></td>
                    <td class="ticket-price__preferential">900<span class="ruble">q</span></td>
                    <td class="ticket-price__childish">600<span class="ruble">q</span></td>
                  </tr>
                  <tr>
                    <td class="ticket-price__name">Туда и обратно</td>
                    <td class="ticket-price__adult">1 650<span class="ruble">q</span></td>
                    <td class="ticket-price__preferential">1 350<span class="ruble">q</span></td>
                    <td class="ticket-price__childish">900<span class="ruble">q</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="ticket-price__img-bg">
              <picture><img src="/img/ticket-price/ticket-price__img-bg@1x.png" srcset="/img/ticket-price/ticket-price__img-bg@2x.png 2x" width="580" height="580" alt="Kronshtadt chumnoi"></picture>
            </div>
          </div>
        </section>
        <section class="departure-berths">
          <div class="departure-berths__container container">
            <h2 class="departure-berths__title title" id="departure-berths">Причалы отправления и&nbsp;прибытия</h2>
            <div class="departure-berths__tabs js-tabs-container">
              <button class="departure-berths__tabs-btn active" type="button" data-tabs="spb">Санкт-Петербург</button>
              <button class="departure-berths__tabs-btn" type="button" data-tabs="kronstadt">Кронштадт</button>
            </div>
            <div class="departure-berths__tabs-list">
              <div class="departure-berths__tabs-item active" data-tabs-item="spb">
                <div class="departure-berths__map" id="mapSpb"></div>
                <div class="departure-berths__pier-list-container js-slider-departure-berths">
                  <ul class="departure-berths__pier-list pier-list swiper-wrapper">
                    <li class="pier-list__item swiper-slide">
                      <div class="pier-list__img-block">
                        <picture><img src="/img/departure-berths/pier-spb-1@1x.jpg" srcset="/img/departure-berths/pier-spb-1@2x.jpg" alt="Pier spb 1"></picture>
                      </div>
                      <h3 class="pier-list__title">Причал «Сенатская пристань» у Медного всадника</h3>
                      <p class="pier-list__pin">Английская наб., 2</p>
                      <div class="pier-list__time-block"><span>Время отправления</span>
                        <div class="pier-list__time-list">
                          <time datetime="10:35">10:35</time>
                          <time datetime="13:20">13:20</time>
                          <time datetime="15:50">15:50</time>
                          <time datetime="18:15">18:15</time>
                        </div>
                      </div>
                    </li>
                    <li class="pier-list__item swiper-slide">
                      <div class="pier-list__img-block">
                        <picture><img src="/img/departure-berths/pier-spb-2@1x.jpg" srcset="/img/departure-berths/pier-spb-2@2x.jpg" alt="Pier spb 2"></picture>
                      </div>
                      <h3 class="pier-list__title">Причал «Зимняя канавка» у Эрмитажа</h3>
                      <p class="pier-list__pin">Дворцовая пристань, 32</p>
                      <div class="pier-list__time-block"><span>Время отправления</span>
                        <div class="pier-list__time-list">
                          <time datetime="10:45">10:45</time>
                          <time datetime="13:30">13:30</time>
                          <time datetime="16:00">16:00</time>
                          <time datetime="18:25">18:25</time>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="departure-berths__tabs-item" data-tabs-item="kronstadt">
                <div class="departure-berths__map" id="mapKronstadt"></div>
                <div class="departure-berths__pier-list-container js-slider-departure-berths">
                  <ul class="departure-berths__pier-list pier-list swiper-wrapper">
                    <li class="pier-list__item swiper-slide">
                      <div class="pier-list__img-block">
                        <picture><img src="/img/departure-berths/pier-kronstadt-1@1x.jpg" srcset="/img/departure-berths/pier-kronstadt-1@1x.jpg" alt="Pier spb 1"></picture>
                      </div>
                      <h3 class="pier-list__title">Причал «Остров фортов»</h3>
                      <p class="pier-list__pin">Центральная аллея парка</p>
                      <div class="pier-list__time-block"><span>Время отправления</span>
                        <div class="pier-list__time-list">
                          <time datetime="11:50">11:50</time>
                          <time datetime="14:35">14:35</time>
                          <time datetime="17:00">17:00</time>
                          <time datetime="20:00">20:00</time>
                        </div>
                      </div>
                    </li>
                    <li class="pier-list__item swiper-slide">
                      <div class="pier-list__img-block">
                        <picture><img src="/img/departure-berths/pier-kronstadt-2@1x.jpg" srcset="/img/departure-berths/pier-kronstadt-2@1x.jpg" alt="Pier spb 2"></picture>
                      </div>
                      <h3 class="pier-list__title">Причал «Зимняя пристань»</h3>
                      <p class="pier-list__pin">Арсенальный переулок.</p>
                      <div class="pier-list__time-block"><span>Время отправления</span>
                        <div class="pier-list__time-list">
                          <time datetime="12:10">12:10</time>
                          <time datetime="14:55">14:55</time>
                          <time datetime="17:20">17:20</time>
                          <time datetime="19:35">19:35</time>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </section>
        <section class="advantages">
          <div class="advantages__container container">
            <h2 class="advantages__title title" id="advantages">Преимущества</h2>
            <ul class="advantages__list">
              <li class="advantages__item">
                <div class="advantages__img-block"><img src="/img/advantages/fast.svg" width="80" height="80" alt="Быстро"></div>
                <h3>Быстро</h3>
                <p>Время в пути — всего 60 минут в одну сторону.</p>
              </li>
              <li class="advantages__item">
                <div class="advantages__img-block"><img src="/img/advantages/comfortable.svg" width="80" height="80" alt="Комфортно"></div>
                <h3>Комфортно</h3>
                <p>Без автомобильных пробок и дорожной пыли.</p>
              </li>
              <li class="advantages__item">
                <div class="advantages__img-block"><img src="/img/advantages/conveniently.svg" width="80" height="80" alt="Удобно"></div>
                <h3>Удобно</h3>
                <p>Причалы в центре Петербурга и Кронштадта в шаге от основных достопримечательностей.</p>
              </li>
              <li class="advantages__item">
                <div class="advantages__img-block"><img src="/img/advantages/handsomely.svg" width="80" height="80" alt="Красиво"></div>
                <h3>Красиво</h3>
                <p>Панорамы Финского залива и необычный вид на Петербург и Кронштадт со стороны воды.</p>
              </li>
            </ul>
          </div>
        </section>
          <section class="excursion-kronshtadt" id="excursion">
              <div class="excursion-kronshtadt__container container">
                  <h2 class="title">Экскурсия на теплоходе «Форты Кронштадта»</h2>
                  <div class="excursion-kronshtadt__wrapper">
                      <div class="excursion-kronshtadt__item">
                          <p>Приглашаем вас отправиться в настоящее морское путешествие: на экскурсию вокруг фортов Кронштадта    на двухпалубном теплоходе. Теплоход пройдёт мимо шести фортов: Александр I, Константин, Милютин, Павел I, Кроншлот и вернётся к форту Пётр I.</p>
                          <ul>
                              <li><img src="img/excursion-kronshtadt/anchor.svg" alt="anchor"><span>Отправление от причала «Острова фортов»</span></li>
                              <li><img src="img/excursion-kronshtadt/time.svg" alt="time"><span>Продолжительность 45 минут</span></li>
                              <li><img src="img/excursion-kronshtadt/shout.svg" alt="shout"><span>Экскурсионное сопровождение</span></li>
                              <li><img src="img/excursion-kronshtadt/cup.svg" alt="cup"><span>Бар-буфет с напитками и закусками</span></li>
                          </ul>
                          <button class="button button--blue excursion-kronshtadt__btn" type="button" data-modal="excursion-ticket">Купить билет на экскурсию</button>
                      </div>
                      <div class="excursion-kronshtadt__item">
                          <div class="excursion-kronshtadt__img-block">
                              <picture><img src="img/excursion-kronshtadt/excursion-ship@1x.jpg" srcset="img/excursion-kronshtadt/excursion-ship@2x.jpg 2x" alt="ship"></picture>
                          </div>
                      </div>
                  </div>
                  <div class="excursion-kronshtadt__map-block"><img src="img/excursion-kronshtadt/excursion-map.svg" alt="map"></div>
              </div>
          </section>
          <section class="about-project">
              <div class="about-project__container container">
                  <div class="about-project__main">
                      <div class="about-project__img-block"><img src="/img/about-project/bg-map.png" width="1255" height="1018" alt="Map"></div>
                      <h2 class="about-project__title title" id="about-project">О парке «Остров фортов»</h2>
                      <p class="about-project__descr">Первый и самый большой в России музейно-исторический парк, посвящённый военно-морскому флоту.</p>
                      <p class="about-project__descr">В парке предусмотрены расширенные возможности для семейного отдыха, созданы тематические площадки с информацией об истории ВМФ России. В их числе главный объект парка — Аллея героев российского флота, которая рассказывает о более чем трех веках истории Военно-морского флота, и Маяк памяти с 200 именами героев-моряков, начиная с эпохи Петра I и до наших дней.</p>
                      <p class="about-project__descr">В парке обустроены детская площадка площадью 1000 кв. м, прогулочные зоны и зоны тихого отдыха, в том числе яблоневый сад с прудом, установлены панорамные качели с завораживающим видом на Финский залив, работает фудкорт.</p>
                      <p class="about-project__descr">В летний период в парке «Остров фортов» почти каждые выходные проходят мероприятия для всей семьи, работают детские аниматоры.</p>
                  </div>
                  <div class="about-project__info">
                      <h3>Достопримечательности и&nbsp;точки притяжения:</h3>
                      <ul>
                          <li>Аллея героев российского флота</li>
                          <li>Маяк памяти</li>
                          <li>Панорамные качели</li>
                          <li>Сад памяти</li>
                          <li>Учебно-спортивный палаточный комплекс «Лагерь настоящих героев»</li>
                          <li>Веревочный парк</li>
                          <li>Детские площадки, зоны тихого отдыха и фудкорт</li>
                      </ul>
                  </div>
                  <div class="slider-sights slider-sights--about slider-sights--blue">
                      <ul class="slider-sights__list swiper-wrapper">
                          <li class="slider-sights__item swiper-slide">
                              <picture><img src="/img/about-project/slider/slide-1@1x.jpg" srcset="/img/about-project/slider/slide-1@2x.jpg 2x" alt="slide-0"></picture>
                          </li>
                          <li class="slider-sights__item swiper-slide">
                              <picture><img src="/img/about-project/slider/slide-2@1x.jpg" srcset="/img/about-project/slider/slide-2@2x.jpg 2x" alt="slide-1"></picture>
                          </li>
                          <li class="slider-sights__item swiper-slide">
                              <picture><img src="/img/about-project/slider/slide-3@1x.jpg" srcset="/img/about-project/slider/slide-3@2x.jpg 2x" alt="slide-2"></picture>
                          </li>
                          <li class="slider-sights__item swiper-slide">
                              <picture><img src="/img/about-project/slider/slide-4@1x.jpg" srcset="/img/about-project/slider/slide-4@2x.jpg 2x" alt="slide-3"></picture>
                          </li>
                          <li class="slider-sights__item swiper-slide">
                              <picture><img src="/img/about-project/slider/slide-5@1x.jpg" srcset="/img/about-project/slider/slide-5@2x.jpg 2x" alt="slide-4"></picture>
                          </li>
                          <li class="slider-sights__item swiper-slide">
                              <picture><img src="/img/about-project/slider/slide-6@1x.jpg" srcset="/img/about-project/slider/slide-6@2x.jpg 2x" alt="slide-5"></picture>
                          </li>
                          <li class="slider-sights__item swiper-slide">
                              <picture><img src="/img/about-project/slider/slide-7@1x.jpg" srcset="/img/about-project/slider/slide-7@2x.jpg 2x" alt="slide-6"></picture>
                          </li>
                          <li class="slider-sights__item swiper-slide">
                              <picture><img src="/img/about-project/slider/slide-8@1x.jpg" srcset="/img/about-project/slider/slide-8@2x.jpg 2x" alt="slide-7"></picture>
                          </li>
                      </ul>
                      <div class="slider-sights__nav">
                          <button class="slider-sights__btn slider-sights__btn--prev" type="button">
                              <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M16.0195 3.9585L3.99872 15.9793M16.0195 28.0001L3.99872 15.9793M3.99872 15.9793L28.0403 15.9793" stroke="currentColor" stroke-width="2"></path>
                              </svg>
                          </button>
                          <button class="slider-sights__btn slider-sights__btn--next" type="button">
                              <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M16.0195 28L28.0403 15.9792M16.0195 3.95837L28.0403 15.9792M28.0403 15.9792L3.99872 15.9792" stroke="currentColor" stroke-width="2"></path>
                              </svg>
                          </button>
                      </div>
                  </div>
              </div>
          </section>
          <section class="about-carrmit">
              <div class="about-carrmit__container container">
                  <div class="about-carrmit__descr">
                      <h2 class="about-carrmit__title title" id="about-carrmit">О перевозчике</h2>
                      <p class="about-carrmit__text">Судоходная компания «Нева Тревел Компани» успешно работает на рынке водных пассажирских перевозок более 25 лет. Компания владеет крупнейшим в Петербурге собственным флотом из 30 теплоходов и сетью причалов в шаговой доступности от главных городских достопримечательностей и транспортных узлов.</p>
                      <p class="about-carrmit__text">За годы своей работы компания разработала широкий спектр классических и современных маршрутов по всем водным артериям Северной столицы, которые высоко оценивают как петербуржцы, так и гости города.</p>
                      <p class="about-carrmit__text">«Нева Тревел Компани» постоянно работает над расширением спектра предлагаемых услуг, качеством сервиса и модернизацией флота, что подтверждается многочисленными положительными отзывами, благодарностями и правительственными наградами.</p>
                      <div class="about-carrmit__bg-img"><img src="/img/about-carrmit/ship-bg@1x.png" srcset="/img/about-carrmit/ship-bg@2x.png 2x" width="367" height="367" alt="Kronshtadt ship"></div>
                  </div>
                  <div class="slider-sights slider-sights--carrmit slider-sights--white">
                      <ul class="slider-sights__list swiper-wrapper">
                          <li class="slider-sights__item swiper-slide">
                              <picture><img src="/img/about-carrmit/slider/slide-1@1x.jpg" srcset="/img/about-carrmit/slider/slide-1@2x.jpg 2x" alt="slide-0"></picture>
                          </li>
                          <li class="slider-sights__item swiper-slide">
                              <picture><img src="/img/about-carrmit/slider/slide-2@1x.jpg" srcset="/img/about-carrmit/slider/slide-2@2x.jpg 2x" alt="slide-1"></picture>
                          </li>
                          <li class="slider-sights__item swiper-slide">
                              <picture><img src="/img/about-carrmit/slider/slide-3@1x.jpg" srcset="/img/about-carrmit/slider/slide-3@2x.jpg 2x" alt="slide-2"></picture>
                          </li>
                          <li class="slider-sights__item swiper-slide">
                              <picture><img src="/img/about-carrmit/slider/slide-4@1x.jpg" srcset="/img/about-carrmit/slider/slide-4@2x.jpg 2x" alt="slide-3"></picture>
                          </li>
                          <li class="slider-sights__item swiper-slide">
                              <picture><img src="/img/about-carrmit/slider/slide-5@1x.jpg" srcset="/img/about-carrmit/slider/slide-5@2x.jpg 2x" alt="slide-4"></picture>
                          </li>
                          <li class="slider-sights__item swiper-slide">
                              <picture><img src="/img/about-carrmit/slider/slide-6@1x.jpg" srcset="/img/about-carrmit/slider/slide-6@2x.jpg 2x" alt="slide-5"></picture>
                          </li>
                          <li class="slider-sights__item swiper-slide">
                              <picture><img src="/img/about-carrmit/slider/slide-7@1x.jpg" srcset="/img/about-carrmit/slider/slide-7@2x.jpg 2x" alt="slide-6"></picture>
                          </li>
                          <li class="slider-sights__item swiper-slide">
                              <picture><img src="/img/about-carrmit/slider/slide-8@1x.jpg" srcset="/img/about-carrmit/slider/slide-8@2x.jpg 2x" alt="slide-7"></picture>
                          </li>
                      </ul>
                      <div class="slider-sights__nav">
                          <button class="slider-sights__btn slider-sights__btn--prev" type="button">
                              <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M16.0195 3.9585L3.99872 15.9793M16.0195 28.0001L3.99872 15.9793M3.99872 15.9793L28.0403 15.9793" stroke="currentColor" stroke-width="2"></path>
                              </svg>
                          </button>
                          <button class="slider-sights__btn slider-sights__btn--next" type="button">
                              <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M16.0195 28L28.0403 15.9792M16.0195 3.95837L28.0403 15.9792M28.0403 15.9792L3.99872 15.9792" stroke="currentColor" stroke-width="2"></path>
                              </svg>
                          </button>
                      </div>
                  </div>
              </div>
          </section>
      </main>
      <footer class="footer">
        <div class="footer__container container">
          <div class="footer__neva">
            <p class="footer__neva-name">Судоходная компания:</p>
              <a href="https://neva.travel/" target="_blank" rel="nofollow">ООО «Нева Тревел»
                  <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M6 7H16M16 7V17M16 7L6 17" stroke="currentColor"></path>
                  </svg>
              </a>
            <p>ООО «Нева Тревел»</p>
            <p>199106, г. Санкт-Петербург, пл. Морской Славы, д. 1, лит. А, офис 307-4</p><a href="tel:+78127029009">+7-812-702-90-09</a><a href="mailto:info@nevatravel.ru">info@nevatravel.ru</a>
            <ul class="social">
              <li><a href="https://vk.com/neva.travel" target="_blank" rel="nofollow">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.4295 18.0659H19.5085C18.555 18.0659 18.4423 17.3725 16.6914 15.7082C15.2178 14.252 14.5937 14.1393 14.2297 14.1393C13.9176 14.1393 13.7009 14.3734 13.7009 14.9281V17.1558C13.7009 17.8059 13.3195 18.0659 11.7766 18.0659C9.23694 18.0659 6.41986 16.497 4.27021 13.6019C1.08041 9.29395 0.265625 6.07815 0.265625 5.38471C0.265625 5.01199 0.542999 4.75195 0.924388 4.75195H3.5161C4.1922 4.75195 4.45224 4.95132 4.68627 5.66209C5.88245 9.15527 8.0061 12.2324 8.89889 12.2324C9.23694 12.2324 9.27161 11.955 9.27161 11.2356V7.69038C9.27161 5.96546 8.30081 5.82678 8.30081 5.18535C8.30081 4.93398 8.50017 4.75195 8.82088 4.75195H12.9815C13.5362 4.75195 13.6143 4.95132 13.6143 5.62742V10.4468C13.6143 10.9929 13.7269 11.2009 13.9783 11.2009C14.2817 11.2009 14.5591 11.0189 15.1051 10.4034C16.8127 8.52251 18.2256 5.5234 18.2256 5.5234C18.399 5.15068 18.6157 4.89064 19.2137 4.89064H21.8141C22.3255 4.89064 22.5509 5.16801 22.4469 5.66209C22.1522 7.05762 19.1531 11.2789 19.1531 11.2789C18.8757 11.7123 18.7543 11.955 19.1531 12.3711C19.4304 12.7265 20.3059 13.4979 20.8433 14.2173C22.1522 15.6042 23.0016 16.7744 23.0016 17.4331C23.0016 17.9272 22.7243 18.0659 22.4295 18.0659Z" fill="currentColor"></path>
                  </svg></a></li>
              <li><a href="https://www.instagram.com/neva.travel/" target="_blank" rel="nofollow">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 4C9.82737 4 9.55487 4.00925 8.70162 4.04812C7.85012 4.087 7.2685 4.22225 6.75975 4.42C6.23362 4.62437 5.7875 4.898 5.34275 5.34275C4.898 5.7875 4.62437 6.23362 4.42 6.75975C4.22225 7.26863 4.087 7.85012 4.04812 8.70162C4.00925 9.55487 4 9.82737 4 12C4 14.1726 4.00925 14.4451 4.04812 15.2984C4.087 16.1499 4.22225 16.7314 4.42 17.2402C4.62437 17.7664 4.898 18.2125 5.34275 18.6572C5.7875 19.102 6.23362 19.3755 6.75975 19.58C7.26863 19.7778 7.85012 19.913 8.70162 19.9519C9.55487 19.9907 9.82737 20 12 20C14.1726 20 14.4451 19.9907 15.2984 19.9519C16.1499 19.913 16.7314 19.7778 17.2402 19.58C17.7664 19.3755 18.2125 19.102 18.6572 18.6572C19.102 18.2125 19.3755 17.7664 19.58 17.2402C19.7778 16.7314 19.913 16.1499 19.9519 15.2984C19.9907 14.4451 20 14.1726 20 12C20 9.82737 19.9907 9.55487 19.9519 8.70162C19.913 7.85012 19.7778 7.26863 19.58 6.75975C19.3755 6.23362 19.102 5.7875 18.6572 5.34275C18.2125 4.898 17.7664 4.6245 17.2402 4.42C16.7314 4.22225 16.1499 4.087 15.2984 4.04812C14.4451 4.00925 14.1726 4 12 4ZM12.0003 14.4C13.3258 14.4 14.4003 13.3255 14.4003 12C14.4003 10.6745 13.3258 9.59999 12.0003 9.59999C10.6748 9.59999 9.6003 10.6745 9.6003 12C9.6003 13.3255 10.6748 14.4 12.0003 14.4ZM12.0003 15.7333C14.0622 15.7333 15.7336 14.0619 15.7336 12C15.7336 9.93813 14.0622 8.26665 12.0003 8.26665C9.93844 8.26665 8.26697 9.93813 8.26697 12C8.26697 14.0619 9.93844 15.7333 12.0003 15.7333ZM17.9164 7.65869C17.9164 8.20661 17.4722 8.65069 16.9244 8.65069C16.3766 8.65069 15.9324 8.20661 15.9324 7.65869C15.9324 7.11076 16.3766 6.66669 16.9244 6.66669C17.4723 6.66669 17.9164 7.11076 17.9164 7.65869Z" fill="currentColor"></path>
                  </svg></a></li>
            </ul>
          </div>
          <div class="footer__fortov-island">
            <p class="footer__fortov-island-name">«Остров фортов»:</p><a class="footer__fortov-island-website" href="https://xn--80aiqmelqc4c.xn--p1ai/" target="_blank" rel="nofollow">Кронштадт.рф
              <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 7H16M16 7V17M16 7L6 17" stroke="currentColor"></path>
              </svg></a><a href="mailto:info@kronshtadt.net">info@kronshtadt.net</a>
            <ul class="social">
              <li><a href="https://vk.com/kronshtadt_rf" target="_blank" rel="nofollow">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.4295 18.0659H19.5085C18.555 18.0659 18.4423 17.3725 16.6914 15.7082C15.2178 14.252 14.5937 14.1393 14.2297 14.1393C13.9176 14.1393 13.7009 14.3734 13.7009 14.9281V17.1558C13.7009 17.8059 13.3195 18.0659 11.7766 18.0659C9.23694 18.0659 6.41986 16.497 4.27021 13.6019C1.08041 9.29395 0.265625 6.07815 0.265625 5.38471C0.265625 5.01199 0.542999 4.75195 0.924388 4.75195H3.5161C4.1922 4.75195 4.45224 4.95132 4.68627 5.66209C5.88245 9.15527 8.0061 12.2324 8.89889 12.2324C9.23694 12.2324 9.27161 11.955 9.27161 11.2356V7.69038C9.27161 5.96546 8.30081 5.82678 8.30081 5.18535C8.30081 4.93398 8.50017 4.75195 8.82088 4.75195H12.9815C13.5362 4.75195 13.6143 4.95132 13.6143 5.62742V10.4468C13.6143 10.9929 13.7269 11.2009 13.9783 11.2009C14.2817 11.2009 14.5591 11.0189 15.1051 10.4034C16.8127 8.52251 18.2256 5.5234 18.2256 5.5234C18.399 5.15068 18.6157 4.89064 19.2137 4.89064H21.8141C22.3255 4.89064 22.5509 5.16801 22.4469 5.66209C22.1522 7.05762 19.1531 11.2789 19.1531 11.2789C18.8757 11.7123 18.7543 11.955 19.1531 12.3711C19.4304 12.7265 20.3059 13.4979 20.8433 14.2173C22.1522 15.6042 23.0016 16.7744 23.0016 17.4331C23.0016 17.9272 22.7243 18.0659 22.4295 18.0659Z" fill="currentColor"></path>
                  </svg></a></li>
              <li><a href="https://www.instagram.com/kronshtadt.rf/" target="_blank" rel="nofollow">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 4C9.82737 4 9.55487 4.00925 8.70162 4.04812C7.85012 4.087 7.2685 4.22225 6.75975 4.42C6.23362 4.62437 5.7875 4.898 5.34275 5.34275C4.898 5.7875 4.62437 6.23362 4.42 6.75975C4.22225 7.26863 4.087 7.85012 4.04812 8.70162C4.00925 9.55487 4 9.82737 4 12C4 14.1726 4.00925 14.4451 4.04812 15.2984C4.087 16.1499 4.22225 16.7314 4.42 17.2402C4.62437 17.7664 4.898 18.2125 5.34275 18.6572C5.7875 19.102 6.23362 19.3755 6.75975 19.58C7.26863 19.7778 7.85012 19.913 8.70162 19.9519C9.55487 19.9907 9.82737 20 12 20C14.1726 20 14.4451 19.9907 15.2984 19.9519C16.1499 19.913 16.7314 19.7778 17.2402 19.58C17.7664 19.3755 18.2125 19.102 18.6572 18.6572C19.102 18.2125 19.3755 17.7664 19.58 17.2402C19.7778 16.7314 19.913 16.1499 19.9519 15.2984C19.9907 14.4451 20 14.1726 20 12C20 9.82737 19.9907 9.55487 19.9519 8.70162C19.913 7.85012 19.7778 7.26863 19.58 6.75975C19.3755 6.23362 19.102 5.7875 18.6572 5.34275C18.2125 4.898 17.7664 4.6245 17.2402 4.42C16.7314 4.22225 16.1499 4.087 15.2984 4.04812C14.4451 4.00925 14.1726 4 12 4ZM12.0003 14.4C13.3258 14.4 14.4003 13.3255 14.4003 12C14.4003 10.6745 13.3258 9.59999 12.0003 9.59999C10.6748 9.59999 9.6003 10.6745 9.6003 12C9.6003 13.3255 10.6748 14.4 12.0003 14.4ZM12.0003 15.7333C14.0622 15.7333 15.7336 14.0619 15.7336 12C15.7336 9.93813 14.0622 8.26665 12.0003 8.26665C9.93844 8.26665 8.26697 9.93813 8.26697 12C8.26697 14.0619 9.93844 15.7333 12.0003 15.7333ZM17.9164 7.65869C17.9164 8.20661 17.4722 8.65069 16.9244 8.65069C16.3766 8.65069 15.9324 8.20661 15.9324 7.65869C15.9324 7.11076 16.3766 6.66669 16.9244 6.66669C17.4723 6.66669 17.9164 7.11076 17.9164 7.65869Z" fill="currentColor"></path>
                  </svg></a></li>
            </ul>
          </div>
          <ul class="footer__list-link">
            <li><a href="/offer-services/">Договор оферты</a></li>
            <li><a href="/instructions-buy-tickets/">Как купить билеты</a></li>
            <li><a href="/processing-personal-data-policy/">Политика конфиденциальности</a></li>
            <li><a href="/personal-data/">Соглашение об обработке персональных данных</a></li>
          </ul>
          <ul class="footer__payment-list">
            <li><img src="/img/payment/alfa.svg" alt="Alfa"></li>
            <li><img src="/img/payment/visa.svg" alt="Visa"></li>
            <li><img src="/img/payment/master-card.svg" alt="Master card"></li>
            <li><img src="/img/payment/mir.svg" alt="Mir"></li>
          </ul>
        </div>
      </footer>
        <?php include_once __DIR__.'/html/blocks/modal.php'; ?>
    </div>
    <?php $html->includeBlock('scripts'); ?>
  </body>
</html>