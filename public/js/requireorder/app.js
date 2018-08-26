const prefix = '#app ';
const HTTP = $;
const _token = HTTP('meta[name=csrf-token]').attr('content');

const app = new Vue({
    el: prefix.trim(),
    data: function() {
        return {
            dt: [],
            form:[],
            sum:0
        }
    },
    created: function() {
        this.fetchdata();
        this.callfunction();
    },

    methods: {
        callfunction: function(){
            $('#senddate').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true
            });
        },
        sumpd: function(){
            if(this.form.length){
                this.sum = _.sumBy(this.form, function(o){
                    return o.price * o.qty
                })
            }else{
                this.sum = 0
            }
        },
        fetchdata: function(){
            $vm = this
            HTTP.ajax({
                method: "GET",
                url: '/getmyproductlist',
            }).done(function(res, textStatus, jqXHR) {
                if (textStatus == 'success') {
                    $vm.dt = res.data
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                $vm.dt = []
                console.log(textStatus, errorThrown)
            });
        },
        addtoCart: function(pd){
            _.remove(this.dt, function(n){ return n.product_no == pd.product_no })
            pd.qty = 1
            this.form.push(pd)
            this.sumpd()
        },
        delinCart: function(pd){
            _.remove(this.form, function(n){ return n.product_no == pd.product_no })
            pd.qty = 1
            this.dt.push(pd)   
            this.sumpd()
        }
    },
    filters: {
        formatP: function (value) {
            if (!value) return 0
          return accounting.formatNumber(value, 2);
        }
    }
})
