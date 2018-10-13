const prefix = '#app ';
const HTTP = $;

const app = new Vue({
    el: prefix.trim(),
    data: function() {
        return {
            dt: [],
            form:[],
            senddate: '',
            order_detail: '',
            file: new FormData(),
            sum:0
        }
    },
    created: function() {
        this.fetchdata();
    },

    methods: {
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
        },
        previewFiles() {
            $vm = this
            let data = this.$refs.myFiles.files[0]
            $vm.file.append('file', data)
        },
        onSave: function(){
            let dt = this.file 
            dt.append('pdorder', JSON.stringify(this.form))
            dt.append('senddate', this.senddate)
            dt.append('orderdetail', this.order_detail)

            HTTP.ajax({ 
                url: '/requireorder',  
                method: 'POST', 
                cache: false,
                contentType: false,
                processData: false,
                data: dt,
                success: function(data){
                    if(data.status=='success'){
                        swal({
                        type: 'success',
                        title: 'บันทึกสำเร็จ',
                        showConfirmButton: false,
                        timer: 1000
                        });
                        window.location.href = "/requireorder/"+data.id+"/edit"
                    }
                }
            })
        }
    },
    filters: {
        formatP: function (value) {
            if (!value) return 0
          return accounting.formatNumber(value, 2);
        }
    },
    mounted: function (){       
        $vm = this     
        $('#senddate').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        }).on('changeDate', function (ev) {
            $vm.senddate = moment(ev.date).format('DD-MM-YYYY');
        });
    },
})
