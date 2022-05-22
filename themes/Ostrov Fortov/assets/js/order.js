const COUNTRY_CODE = '+7';
const BASE_MATRIX = ' (___) ___ __ __';
const length = COUNTRY_CODE.length;
const phoneLength = COUNTRY_CODE.length + BASE_MATRIX.length;
const preloader = document.getElementById('preloader');

OrderForm = function (selector) {
    return new Vue({
        el: selector,
        data: {
            name: '',
            email: '',
            phone: '',
            accept: false,
            date: null,
            datePicker: null,
            programs: [],
            cruisesTo: [],
            cruisesBack: [],
            pier: null,
            cruise: null,
            backPier: null,
            backCruise: null,
            withoutBack: 0,
            errors: {
                email: false,
                phone: false,
            },
            months: {
                1: "Января",
                2: "Февраля",
                3: "Марта",
                4: "Апреля",
                5: "Мая",
                6: "Июня",
                7: "Июля",
                8: "Августа",
                9: "Сентября",
                10: "Октября",
                11: "Ноября",
                12: "Декабря",
            },
            tickets: {
                full: {
                    name: 'Взрослый',
                    long_name: 'Взрослый билет',
                    tooltip: '',
                    value: 1
                },
                half: {
                    name: 'Льготный',
                    long_name: 'Льготный билет',
                    tooltip: 'При получении билетов в кассе необходимо предоставить документ, подтверждающий право на льготу: студенческий билет, пенсионное удостоверение и т.п.',
                    value: 0
                },
                children: {
                    name: 'Детский',
                    long_name: 'Детский билет',
                    tooltip: 'С 3 до 11 лет',
                    value: 0
                },
                // attendant: {
                //     name: 'Сопровождающие',
                //     tooltip: '',
                //     value: 0
                // }
            },
            preloader: preloader,
            program_to: null
        },
        mounted: function () {
            var _this = this;
            this.datePicker = this.$el.querySelector('[data-datepicker]').flatpickr({
                locale: 'ru',
                dateFormat: 'd.m.Y',
                minDate: 'today',
                disableMobile: true,
                onChange: function (selectedDates, dateStr, instance) {
                    _this.setDate(dateStr);
                }
            });

            if(this.$el.hasAttribute('data-programs')){
                this.programs = JSON.parse(this.$el.getAttribute('data-programs'));
            }

            if(this.$el.hasAttribute('data-program-to')){
                this.program_to = this.$el.getAttribute('data-program-to');
            }

            if(this.$el.hasAttribute('data-cruises-to')){
                this.cruisesTo = JSON.parse(this.$el.getAttribute('data-cruises-to'));
            }

            if(this.$el.hasAttribute('data-cruises-back')){
                this.cruisesBack = JSON.parse(this.$el.getAttribute('data-cruises-back'));
            }

            if(this.$el.hasAttribute('data-date')){
                this.date = this.$el.getAttribute('data-date');
            }

            this.setFirstPier();


        },
        methods: {
            showPreloader: function(){
                if(this.preloader){
                    this.preloader.classList.add('active');
                }
            },
            hidePreloader: function(){
                if(this.preloader){
                    this.preloader.classList.remove('active');
                }
            },
            order: function (event) {
                event.preventDefault();
                if(this.validate()){

                    this.showPreloader();

                    var _this = this,
                        data = {
                            action: 'order',
                            date: this.date,
                            name: this.name,
                            phone: this.phone,
                            email: this.email,
                            total: this.totalPrice,
                            tickets: {
                                // full: parseInt(this.tickets.full.value),
                                // half: parseInt(this.tickets.half.value),
                                // children: parseInt(this.tickets.children.value),
                                //attendant: 0,
                            }
                        };

                    for(var key in this.tickets){
                        var _val = parseInt(this.tickets[key].value)
                        if(_val > 0){
                            data.tickets[key] = _val;
                        }
                    }

                    data.cruise = this.cruise;
                    data.backCruise = (this.backCruise ? this.backCruise : null);

                    $.ajax({
                        url: '/api/tickets/',
                        type: 'post',
                        data: data,
                        success: function (data) {
                            data = JSON.parse(data);
                            if(data.errors.length == 0){
                                data = data.data;
                                if(data.status == 'success' && typeof data.payment.formUrl != 'undefined'){
                                    window.location.href = data.payment.formUrl;
                                } else {
                                    alert(data.message);
                                }
                            } else {
                                data.errors.forEach(function (error) {
                                    console.log(error);
                                });
                            }
                            _this.hidePreloader();
                            //console.log(data);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            _this.hidePreloader();
                        }
                    });
                }
            },
            validate: function () {
                var valid = true;

                //email
                this.errors.email = false;
                var emailString = /[a-zA-Zа-яёА-ЯЁ0-9]{1}([a-zA-Zа-яёА-ЯЁ0-9\-_\.]{1,})?@[a-zA-Zа-яёА-ЯЁ0-9]{1}([a-zA-Zа-яёА-ЯЁ0-9.]{1,})?[a-zA-Zа-яёА-ЯЁ0-9]{1}\.[a-zA-Zа-яёА-ЯЁ]{2,6}/;
                var regEmail = new RegExp(emailString, '');
                var emaiParent = this.$el.querySelector('[type="email"]').closest('.modal__field-item');
                if(this.email == '' || !regEmail.test(this.email)){
                    emaiParent.classList.add('is-invalid');
                    valid = false;
                    this.errors.email = true;
                } else {
                    emaiParent.classList.remove('is-invalid');
                }
                //--email

                //phone
                this.errors.phone = false;
                var phoneParent = this.$el.querySelector('[type="tel"]').closest('.modal__field-item');
                if(this.phone == '' || this.phone.length != phoneLength){
                    phoneParent.classList.add('is-invalid');
                    valid = false;
                    this.errors.phone = true;
                } else {
                    phoneParent.classList.remove('is-invalid');
                }
                //--phone

                //conditions
                var conditionsInput = this.$el.querySelector('.conditions-input');
                if(!this.accept){
                    conditionsInput.closest('div').classList.add('is-invalid');
                    valid = false;
                } else {
                    conditionsInput.closest('div').classList.remove('is-invalid');
                }
                //--conditions

                //tickets
                if(!this.ticketsValidate()){
                    valid = false;
                }
                //--tickets

                return valid;
            },
            ticketsValidate: function () {
                return !(this.tickets.full.value == 0 && this.tickets.half.value == 0);
            },
            setFirstPier: function () {
                if(this.piersTo.length > 0){
                    this.setPier(this.piersTo[0]);
                } else if(this.piersBack.length > 0){
                    this.setPier(this.piersBack[0]);
                } else {
                    this.setPier(null);
                }
            },
            setPier: function (obj) {
                if(obj != null){
                    this.pier = {
                        id: obj.id,
                        name: obj.name,
                        direction: obj.direction,
                    };
                } else {
                    this.pier = null;
                }
                this._trigger('set_pier');
            },
            setBackPier: function (obj) {
                if(obj != null){
                    this.backPier = {
                        id: obj.id,
                        name: obj.name,
                        direction: obj.direction,
                    };
                } else {
                    this.backPier = null;
                }
            },
            setCruise: function (val) {
                this.cruise = val;
            },
            setBackCruise: function (val) {
                this.backCruise = val;
            },
            updateCruises: function () {
                var _this = this;
                _this.showPreloader();
                $.ajax({
                    url: '/api/tickets/',
                    type: 'post',
                    data: {
                        date: this.date,
                        action: 'update-cruises',
                        program_to: this.program_to
                    },
                    success: function (data) {
                        data = JSON.parse(data);
                        if(data.errors.length == 0){
                            _this.cruisesTo = (data.data.to ? data.data.to : []);
                            _this.cruisesBack = (data.data.back ? data.data.back : []);
                            _this.setFirstPier();
                        } else {
                            data.errors.forEach(function (error) {
                                console.log(error);
                            });
                        }
                        _this.hidePreloader();
                        //console.log(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        _this.hidePreloader();
                    }
                });
            },
            setDate: function (date, to_picker) {
                to_picker = to_picker || false;
                if(to_picker){
                    this.datePicker.setDate(date);
                }
                this.date = date
            },
            incTickets: function(key){
                this.tickets[key].value++;
            },
            decTickets: function(key){
                if(this.tickets[key].value > 0){
                    this.tickets[key].value--;
                }
            },
            _trigger: function (eventName) {
                var event = new CustomEvent(eventName);
                this.$el.dispatchEvent(event);
            },
            clearPhone: function () {
                if(this.phone === COUNTRY_CODE){
                    this.phone = '';
                }
            },
            validatePhone: function(){
                var val = this.phone;
                var matrix = `${COUNTRY_CODE} (___) ___ __ __`;
                var def = matrix.replace(/\D/g, '');
                var i = 0;
                val = val.replace(/\D/g, '');
                if (def.length >= val.length) {
                    val = def;
                }
                val = matrix.replace(/./g, (a) => {
                    // eslint-disable-next-line no-nested-ternary
                    return /[_\d]/.test(a) && i < val.length ? val.charAt(i++) : i >= val.length ? '' : a;
                });
                this.phone = val;
            },
            timeFormat: function (val) {
                var _val = val.split(':');
                if(_val.length == 1){
                    return val + ' мин';
                } else if(_val.length == 2){
                    var h = parseInt(_val[0]),
                        m = _val[1],
                        r = '';
                    if(h > 0){
                        r = h + ' ч'
                    }
                    if(parseInt(m) > 0){
                        if(r){
                            r += ' ' + m + ' мин';
                        } else {
                            r = m + ' мин';
                        }
                    }
                    return r;
                } else {
                    return val;
                }
            },
            getProgramById: function (id) {
                if(this.programs.length > 0){
                    var programs = this.programs.filter(function (item) {
                        return item.id == id;
                    });
                    if(programs.length > 0){
                        return programs[0];
                    }
                }
            },
            getPricesByProgram: function (program, prices, back) {

                back = back || false;
                var _program_prices = program.prices.cat1;

                for (var _key in _program_prices){
                    _program_prices[_key] = parseInt(_program_prices[_key]);
                }

                if(back){
                    back = _program_prices.type12;// Флаг применения скидки за комбо туда-обратно
                }

                for(var key in prices){

                    var _count = this.tickets[key].value;
                    if(_count <= 0) continue;

                    switch (key) {
                        case 'full':
                            if(back){
                                prices[key] += ((_program_prices.type1 - _program_prices.type13) * _count);
                            } else {
                                prices[key] += (_program_prices.type1 * _count);//Стоимость взрослого
                            }
                            break;
                        case 'half':
                            if(back){
                                prices[key] += ((_program_prices.type2 - _program_prices.type14) * _count);
                            } else {
                                prices[key] += (_program_prices.type2 * _count);//Стоимость льготного
                            }
                            break;
                        case 'children':
                            if(back){
                                prices[key] += ((_program_prices.type3 - _program_prices.type15) * _count);
                            } else {
                                prices[key] += (_program_prices.type3 * _count);//Стоимость детского
                            }
                            break;
                    }
                }
                return prices;
            },
            setArrivalPiers: function (cruise) {
                //Arrival piers @todo: make dynamic
                cruise.arrival_piers = [];
                var add = [],
                    time,
                    program_id = parseInt(cruise.program.id);

                if(program_id == 2042335582784323670){//СПб-Кронштадт

                    cruise.arrival_piers.push({
                        id: '2556280404566868000',
                        name: 'Остров Фортов',
                        time: null
                    });

                    cruise.arrival_piers.push({
                        id: "2516289667712679966",
                        name: "Зимняя пристань",
                        time: null
                    });

                    var pier_departure_id = parseInt(cruise.pier_departure.id);

                    if(pier_departure_id == 3){//Причал отправления  "Сенатская пристань"
                        time = cruise.starting_time;
                        if(time){
                            switch (time) {
                                //new
                                case '10:35':
                                case '13:20':
                                    add[0] = 65;
                                    add[1] = 85;
                                    break;
                                case '15:50':
                                    add[0] = 60;
                                    add[1] = 80;
                                    break;
                                //old
                                case '10:15':
                                    add[0] = 70;
                                    add[1] = 90;
                                    break;
                                case '13:10':
                                case '15:40':
                                    add[0] = 65;
                                    add[1] = 90;
                                    break;
                                //--old
                                case '18:15':
                                    add[0] = 90;
                                    add[1] = 70;
                                    break;
                                default:
                                    add[0] = 70;
                                    add[1] = 90;
                                    break;
                            }
                        }
                    } else if(pier_departure_id == 6){//Причал отправления  "Зимняя канавка"
                        time = cruise.starting_time;
                        if(time){
                            switch (time) {
                                //new
                                case '10:45':
                                case '13:30':
                                    add[0] = 55;
                                    add[1] = 75;
                                    break;
                                case '16:00':
                                    add[0] = 50;
                                    add[1] = 70;
                                    break;
                                //old
                                case '10:30':
                                    add[0] = 55;
                                    add[1] = 75;
                                    break;
                                case '13:20':
                                case '15:50':
                                    add[0] = 55;
                                    add[1] = 80;
                                    break;
                                //--old
                                case '18:25':
                                    add[0] = 95;
                                    add[1] = 70;
                                    break;
                                default:
                                    add[0] = 55;
                                    add[1] = 75;
                                    break;
                            }
                        }
                    }

                } else if(program_id == 2516191244309233773){//Кронштадт-СПб
                    cruise.arrival_piers.push({
                        id: 3,
                        name: 'Сенатская пристань',
                        time: null
                    });

                    cruise.arrival_piers.push({
                        id: 6,
                        name: "Зимняя канавка",
                        time: null
                    });

                    var pier_departure_id = parseInt(cruise.pier_departure.id);

                    if(pier_departure_id == 2556280404566868000){//Причал отправления  "Остров Фортов"
                        time = cruise.starting_time;
                        if(time){
                            switch (time) {
                                //new
                                case '11:50':
                                    add[0] = 85;
                                    add[1] = 95;
                                    break;
                                case '14:35':
                                case '17:00':
                                    add[0] = 70;
                                    add[1] = 80;
                                    break;
                                //old
                                case '11:35':
                                    add[0] = 90;
                                    add[1] = 100;
                                    break;
                                case '14:25':
                                    add[0] = 70;
                                    add[1] = 80;
                                    break;
                                case '16:55':
                                    add[0] = 75;
                                    add[1] = 85;
                                    break;
                                //--old
                                case '20:00':
                                    add[0] = 50;
                                    break;
                                default:
                                    add[0] = 70;
                                    add[1] = 80;
                                    break;
                            }
                        }
                    } else if(cruise.pier_departure.id == 2516289667712679966){//Причал отправления  "Зимняя пристань"

                        time = cruise.starting_time;
                        if(time){
                            switch (time) {
                                //new
                                case '12:10':
                                    add[0] = 65;
                                    add[1] = 75;
                                    break;
                                //old
                                case '11:55':
                                    add[0] = 70;
                                    add[1] = 80;
                                    break;
                                case '14:45':
                                case '14:55'://new
                                case '17:20':
                                    add[0] = 50;
                                    add[1] = 60;
                                    break;
                                case '19:35':
                                    add[0] = 75;
                                    break;
                                default:
                                    add[0] = 70;
                                    add[1] = 80;
                                    break;
                            }
                        }
                    }
                }
                if(time && cruise.arrival_piers.length > 0){
                    var _this = this;
                    cruise.arrival_piers.forEach(function (item, key) {
                        if(typeof add[key] != 'undefined'){
                            cruise.arrival_piers[key].time =_this.getArrivalTime(time, add[key]);
                        }
                    });

                    cruise.arrival_piers = cruise.arrival_piers.filter(function (item) {
                        return item.time !== null;
                    });

                    cruise.arrival_piers.sort(function (a, b) {
                        return (a.time > b.time ? 1 : -1);
                    });

                }
            },
            getArrivalTime: function (start, addMinutes) {
                var ar = start.split(':'),
                    _h = parseInt(ar[0]),
                    _m = parseInt(ar[1]),
                    _mt = (_h * 60) + _m;

                addMinutes = parseInt(addMinutes);

                if(addMinutes > 0){
                    _mt += addMinutes;
                    _h = 0;
                    _m = 0;
                    while (_mt > 59){
                        _h += 1;
                        _mt -= 60;
                    }
                    _m = _mt;
                }
               return (_h < 10 ? '0' : '') + _h + ':' + (_m < 10 ? '0' : '') + _m;

            }
        },
        computed: {
            dateFormat: function () {
                if(this.datePicker && this.datePicker.selectedDates.length > 0){
                    var d = this.datePicker.formatDate(this.datePicker.selectedDates[0], 'j'),
                        m = this.datePicker.formatDate(this.datePicker.selectedDates[0], 'n'),
                        y = this.datePicker.formatDate(this.datePicker.selectedDates[0], 'Y');
                    return (d + ' ' + this.months[m] + ' ' + y);
                }
            },
            piersTo: function () {
                var pTo = [],
                    pToFake = {};
                for(var key in this.cruisesTo){
                    var cruise = this.cruisesTo[key];
                    if(typeof pToFake[cruise.pier_departure.id] == 'undefined'){
                        pToFake[cruise.pier_departure.id] = true;
                        pTo.push({
                            id: cruise.pier_departure.id,
                            name: cruise.pier_departure.name,
                            direction: 'to',
                            selected: (this.pier && this.pier.id == cruise.pier_departure.id)
                        })
                    }
                }
                return pTo;
            },
            piersBack: function () {
                var pBack = [],
                    pBackFake = {};
                for(var key in this.cruisesBack){
                    var cruise = this.cruisesBack[key];
                    if(typeof pBackFake[cruise.pier_departure.id] == 'undefined'){
                        pBackFake[cruise.pier_departure.id] = true;
                        pBack.push({
                            id: cruise.pier_departure.id,
                            name: cruise.pier_departure.name,
                            direction: 'back',
                            selected: (this.pier && this.pier.id == cruise.pier_departure.id)
                        });
                    }
                }
                return pBack;
            },
            times: function () {
                var times = [],
                    _this = this;
                if(this.pier){
                    var cruises;
                    if(this.pier.direction == 'to'){
                        cruises = this.cruisesTo;
                    } else {
                        cruises = this.cruisesBack;
                    }

                    if(cruises){
                        cruises = cruises.filter(function (cruise) {
                            return (_this.pier.id == cruise.pier_departure.id);
                        });

                        cruises.forEach(function (cruise) {
                            times.push({
                                cruise_id: cruise.id,
                                time: cruise.starting_time,
                                cruise: cruise
                            });
                        });
                    }

                }

                return times;

            },
            totalCruises: function () {
                return parseInt(this.piersTo.length + this.piersBack.length);
            },
            backTripCruises: function () {
                var res = [];
                if(this.cruise && this.cruise.back_cruises.length > 0){
                    var ids = [];
                    this.cruise.back_cruises.forEach(function (back_cruise) {
                        ids.push(back_cruise.id);
                    });
                    var cruises = (this.pier.direction == 'to' ? this.cruisesBack : this.cruisesTo);
                    cruises = cruises.filter(function (cruise) {
                        return (ids.indexOf(cruise.id) !== -1);
                    });
                    res = cruises;
                }
                return res;
            },
            backTripPiers: function () {
                var pBack = [],
                    pBackFake = {};
                for(var key in this.backTripCruises){
                    var cruise = this.backTripCruises[key];
                    if(typeof pBackFake[cruise.pier_departure.id] == 'undefined'){
                        pBackFake[cruise.pier_departure.id] = true;
                        pBack.push({
                            id: cruise.pier_departure.id,
                            name: cruise.pier_departure.name,
                            direction: 'back',
                            selected: (this.backPier && this.backPier.id == cruise.pier_departure.id)
                        });
                    }
                }
                return pBack;
            },
            backTripTimes: function () {
                var times = [],
                    _this = this;
                if(this.backPier){
                    var cruises = this.backTripCruises;

                    cruises = cruises.filter(function (cruise) {
                        return (_this.backPier.id == cruise.pier_departure.id);
                    });

                    cruises.forEach(function (cruise) {
                        times.push({
                            cruise_id: cruise.id,
                            time: cruise.starting_time,
                            cruise: cruise
                        });
                    });

                }

                return times;

            },
            prices: function(){
                var res = {};

                for (var key in this.tickets){
                    res[key] = 0;
                }

                if(this.cruise) {
                    var program = this.getProgramById(this.cruise.program.id);
                    res = this.getPricesByProgram(program, res);
                }

                if(this.backCruise) {
                    var b_program = this.getProgramById(this.backCruise.program.id);
                    res = this.getPricesByProgram(b_program, res, true);
                }

                return res;
            },
            totalPrice: function(){
                var res = 0;
                for (var key in this.prices){
                    res += parseInt(this.prices[key]);
                }
                return res;
            },
            buttonDisabled: function(){
                var res = false;
                if(this.totalPrice <= 0){
                    res = true;
                }
                if(this.tickets.children.value > 0 && (this.tickets.full.value <= 0 && this.tickets.half.value <= 0)){
                    res = true;
                }
                return res;
            },
        },
        watch: {
            date: function (val) {
                this.updateCruises();
                this._trigger('update_date');
            },
            times: function (val) {
                if(val.length > 0){
                    this.setCruise(val[0].cruise);
                } else {
                    this.setCruise(null);
                }
                if(this.backTripPiers.length > 0){
                    this.setBackPier(this.backTripPiers[0]);
                } else {
                    this.setBackPier(null);
                }
            },
            backTripTimes: function (val) {
                if(val.length > 0){
                    this.setBackCruise(val[0].cruise);
                } else {
                    this.setBackCruise(null);
                }
            },
            withoutBack: function (val) {
                if(!val){
                    if(this.backTripPiers.length > 0){
                        this.setBackPier(this.backTripPiers[0]);
                    }
                } else {
                    this.setBackPier(null);
                }
            },
            cruise: function (val) {
                this.setArrivalPiers(val);
                this._trigger('update_cruise');
            },
            backCruise: function (val) {
                if(val){
                    this.setArrivalPiers(val);
                }
            }
        }
    });
}

var SmallOrder = new OrderForm('#small-form');
var ModalOrder = new OrderForm('#modal-order');

SmallOrder.$el.addEventListener('update_date', function (e) {
    ModalOrder.setDate(SmallOrder.date, true);
});

SmallOrder.$el.addEventListener('update_cruise', function (e) {
    if(SmallOrder.cruise){
        ModalOrder.setCruise(SmallOrder.cruise);
    }
});

SmallOrder.$el.addEventListener('set_pier', function (e) {
    ModalOrder.setPier(SmallOrder.pier);
});

var ExcursionOrder = new OrderForm('#modal-excursion-order');