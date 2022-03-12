<template>
    <v-dialog v-model="dialog_message" scrollable max-width="335px">

        <v-card class="px-4 d-block">
           
            <!-- <v-card-title :style="{color:color()}" class="message_title py-8">{{message_title}}</v-card-title> -->
            <v-subheader  class="" style="position: absolute; right: 0;"> 
                 <v-icon class="d-block text-right" style="position: absolute;right: 15px;z-index: 9;"
                                 @click="dialog_message=false">mdi-close
                </v-icon>

            </v-subheader>
            <v-subheader  class="message">
                <h2>{{message_title}}</h2>
                <p>{{message}}</p>       
                <div v-if="message_title=='appointment'" style="display: initial">
                    <a href="/dashboard/appointments">Appointments</a>
                </div>
                       
            </v-subheader>
                

            <div class="text-center">
                <v-btn type="button" depressed rounded  @click="dialog_message = false"
                       color="dialog-ok"> OK
                </v-btn>
            </div>

        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: 'c_message',      
        data () {
            return {
                dialog_message:false,
                color_title:'red',
                message:'',
                message_title:'',
                credits: "",
               

            }
        },

        mounted() {
            this.$root.$on('open_dialog_message', (data) =>
            {
               
                this.message_title = data.message_title;
                
                if(typeof(data.message) !== 'string' || data.message === ''){
                    this.message = 'Please update your card details and try again.';
                }else{
                     this.message = data.message;
                }

                if( this.message_title == "PURCHASE"){
                    this.track(data);
                }
                this.dialog_message = true;
            });


        },
        ready() {
            //EventBus.$on('open_dialog_message', () => this.dialog_message = true);

        },
        methods:{
            color(){

                switch (this.message_title) {
                    case 'ERROR':
                        this.color_title = '#f77f98';
                        break;
                    case 'SUCCESS':
                        this.color_title = '#2cc05f';
                        break;
                    case 'INFORMATION':
                        this.color_title = '#bebeec';
                        break;
                     default:
                            break;

                }
                return this.color_title;
                            },

            track (data) {
            this.$gtag.purchase({
                
                "transaction_id": data.purchase.id,
                "affiliation": "Respectfully™ Purchase",
                "value": data.purchase.credits
            })
    }
        }
    }
</script>

<style scoped>

    .dialog-ok {
        background: transparent linear-gradient(256deg, #7272FF 0%, var(--unnamed-color-9759ff) 100%) 0% 0% no-repeat padding-box;
        background: transparent linear-gradient(256deg, #7272FF 0%, #9759FF 100%) 0% 0% no-repeat padding-box;
        box-shadow: 0px 2px 4px #9759FF4D;
        border-radius: 12px;
        opacity: 1;
        color: #fff!important;
        font-size: 12px!important;
        font-weight: 600!important;
        height: 40px!important;
        width: 159px;
        margin: 20px 0 48px;
    }
    .message_title{
        font-size: 30px !important;
        text-align: center;
        font-weight: 600;
        display: block;
    }
    .message{
        /* display: block; */
        text-align: center;
        font-size: 20px;
        display: block;
        height: auto;
    }
    .message h2 {
        font-size: 18px;
        font-weight: 600;
        color: #131220;
        margin: 56px 0 20px;
    }
    .message p {
        font-size: 14px;
        font-weight: 500;
        color: #131220;
        margin: 0;
    }



</style>