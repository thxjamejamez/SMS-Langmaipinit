const prefix  = '#Salesummary-report ';
const HTTP    = $;
moment.locale('th');
const app = new Vue({
el: prefix.trim(),
data: function () {
    return {
        dt:{
            data: [],
            column:  [  {key: 'order_no', label: 'รหัสการสั่งซื้อ'},
                        {key: 'order_date', label: 'วันที่สั่งซื้อ', customSort:{sortType:'datetime',sortKey:'order_date_hidden'}},
                        {key: 'sum_show', label: 'มูลค่าสินค้า'},
                    ],
        },
        form:{
            start: '',
            end: ''
        },
        range :{
            title :[
                'ทั้งหมด',
                'วันนี้',
                'เมื่อวานนี้',
                'เดือนนี้' ,
                'เดือนที่แล้ว',
                'สามเดือนที่ผ่านมา',
                'ปีที่แล้ว',
                '3 ปีที่ผ่านมา'
            ],
            value : [
                [moment('2003-01-01').startOf('year'), moment()],
                [moment(),moment()],
                [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                [moment().startOf('month'), moment().endOf('month')],
                [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                [moment().subtract(3, 'month'), moment()],
                [moment().subtract(1, 'year'), moment()],
                [moment().subtract(3, 'year'), moment()],
            ]
        }
    }
},
created: function ($vm = this) {
    $vm.fetchData()
},
mounted: function (){
    let $vm = this
    $vm.form.start = moment().subtract(1, 'month').format("YYYY-MM-DD")
    $vm.form.end = moment().format("YYYY-MM-DD")
    $vm.daterangepicker()
},
computed: {

    filterData: function () {
        return this.getFilData()
    },

    sumData: function ($vm = this){
        return accounting.formatNumber(_.sumBy($vm.getFilData(), 'sum'), 2);
    }
},
methods: {
    getFilData: function(){
        let $vm = this
        let data = _.filter($vm.dt.data, function(data, key) {
            let start = (data.order_date_hidden >= $vm.form.start) ?
                true:false,
                end = (data.order_date_hidden <= $vm.form.end) ?
                true:false;
            return start && end
        })
        return data
    },

    fetchData : function ($vm = this){
        HTTP.get('/salesummaryget', function(data){
            $vm.dt.data = _.forEach(data.order, function(value, key) {
                data.order[key].order_date_hidden = moment(value.order_date).format("YYYY-MM-DD")
                data.order[key].order_date = moment(value.order_date).format("DD-MM-YYYY")
                data.order[key].order_no = 'PO'+numeral(value.order_no).format('000000')
                data.order[key].sum_show = accounting.formatNumber(value.sum, 2)
            });
        })
    },

    daterangepicker : function (start,end) {
        let $vm = this
        let $el = $('#fil_DateRange')
        let range = _.zipObject($vm.range.title, $vm.range.value)
        start = start || new Date($vm.form.start)
        end = end || new Date($vm.form.end)
        $el.daterangepicker(
            {
                startDate: start,
                endDate: end,
                ranges: range,
                opens: 'right',
                autoApply: false,
                linkedCalendars: false,
                maxDate: moment(),
                locale: {
                    format: 'LL',
                }
            },
            function (start, end) {
                $vm.form.start = start.format('YYYY-MM-DD')
                $vm.form.end = end.format('YYYY-MM-DD')
            }
        );
    },
},
filters: {
    formatDate: function (value) {
    return moment(value).format('DD-MM-YYYY');
    },
}

})
