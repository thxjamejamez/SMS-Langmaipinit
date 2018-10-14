const prefix  = '#Salary-report ';
const HTTP    = $;
moment.locale('th');
const app = new Vue({
el: prefix.trim(),
data: function () {
    return {
        dt:{
            data: [],
            column:  [  {key: 'emp_no', label: 'รหัสพนักงาน'},
                        {key: 'name', label: 'ชื่อพนักงาน'},
                        {key: 'permission_name', label: 'ตำแหน่ง'},
                        {key: 'start_date', label: 'วันที่เริ่มงาน', customSort:{sortType:'datetime',sortKey:'start_date_hidden'}},
                        {key: 'salary', label: 'เงินเดือน', style: {'text-align': 'right'}},
                    ],
        },
    }
},
created: function ($vm = this) {
    $vm.fetchData()
},

methods: {
    fetchData : function ($vm = this){
        HTTP.get('/getsalary', function(data){
            $vm.dt.data = _.forEach(data.salary, function(value, key) {
                data.salary[key].start_date_hidden = value.start_date
                data.salary[key].start_date = moment(value.start_date).format("DD-MM-YYYY")
                data.salary[key].emp_no = 'EM'+numeral(value.emp_no).format('0000')
                data.salary[key].name = value.title_name+' '+value.first_name+'  '+value.last_name
                data.salary[key].salary = accounting.formatNumber(value.salary, 2)
            });
        })
    },
},
})
