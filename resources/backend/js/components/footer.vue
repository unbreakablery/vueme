<template>
    <footer v-if="!mobile" class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3 order-1 order-md-1">
                <div class="widget">
                    <div class="footer-title">GET RESOURCES</div>
                    <div class="menu">
                        <ul>
                            <li style="width:100%"><a href="/apply">Become a Model</a></li>
                            <li style="width:100%"><a href="/privacy-policy">Privacy</a></li>
                            <li style="width:100%"><a href="/dmca-policy">DMCA</a></li>
                            <li style="width:100%"><a href="/payment-terms">Payment Terms</a></li>
                            <li style="width:100%"><a href="/terms">Terms of Service</a></li>
                        </ul>
                    </div>
                </div>
                </div>
                <div class="col-md-3 order-3 order-md-2">
                <div class="widget">
                    <div class="footer-title">GET SOCIAL</div>
                    <div class="iconlist">
                        <ul>
                            <li><a target="_blank" href="https://www.instagram.com/respectfullylive/" class="instagram"><i class="fab fa-instagram"></i></a></li>
                            <li><a target="_blank" href="https://www.facebook.com/profile.php?id=100055374485642"><i class="fab fa-facebook-f"></i></a></li>
                            <!--<li><a href="https://twitter.com/respectfully/"><i class="fab fa-twitter"></i></a></li>-->
                        </ul>
                    </div>
                </div>
                </div>
                <div class="col-md-3 order-2  order-md-3">
                <div class="widget">
                    <div class="footer-title">GET HELP</div>
                    <div class="iconlist">
                        <ul>
                            <!--<li><a href="https://respectfully.zendesk.com/hc/en-us"><i class="fas fa-question"></i></a></li>-->
                            <li><a href="mailto:nicky@respectfully.com"><i class="fas fa-envelope"></i></a></li>
                        </ul>
                    </div>
                </div>
                </div>
                <div class="col-md-3 order-md-4"></div>
            </div>
            <div class="copyrights text-center">Copyright 2020 VueMe.com, LLC</div>
        </div>
    </footer>
</template>

<script>
    import { mapGetters } from "vuex";
    export default {
        data: () => ({
          signupDialog:false,
            year: 2020,
        }),
        computed: {
            ...mapGetters({
                mobile: "util/mobile",
            }),
        },
        props: ['guest', 'home'],
         methods:{
             
             f_open_login(){
                 EventBus.$emit('open_login',  {});
             },
             f_sign_up(){
                 EventBus.$emit('open_sign_up',  {});
             },
              f_sign_up_user(){
                 EventBus.$emit('open_sign_up_user',  {});
             },

         },
         mounted() {

            var now_date=new Date();

            this.year = now_date.getFullYear();




         },
        
        
        }
 
</script>

<style scoped>
.footer
{
	background:#E4E3EB;
	padding-top:30px;
	padding-bottom:30px;
}
.footer .container {
  padding: 0;
}
.footer .widget .footer-title
{
	font-size:16px;
	font-weight:600;
	line-height:24px;
	letter-spacing: 0.32px;
  color: #131220;
	margin-bottom:20px;
	padding-top:10px;

}
.footer .widget .footer-title:before
{
	content:"";
	background:#131220;
	width:170px;
	height:2px;
	position: absolute;
    top: 0px;	
}
.footer .widget .menu ul
{
	padding:0px;
	margin:0px;
	list-style:none;
}
.footer .widget .menu ul li
{
	margin-bottom:10px;
}
.footer .widget .menu ul li a
{
	font-size:14px;
	font-weight:600;
	line-height:18px;
  letter-spacing: 0.28px;
  color: #131220;
}
.footer .widget .menu ul li a:hover
{
	color:#9759FF;
}
.footer .widget .iconlist ul
{
	padding:0px;
	margin:0px;
	list-style:none;
}
.footer .widget .iconlist ul li
{
	display:inline-block;
	width:30px;
	height:30px;
	position:relative;
}
.footer .widget .iconlist ul li a
{
	display:block;
	width:20px;
	height:20px;
	text-align:center;
	background:#131220;
	text-align:center;
	line-height:20px;
	color:#FFF !important;
	font-size:12px;
	position:absolute;
	top:0px;
	bottom:0px;
	left:0px;
	right:0px;
	/* margin:auto; */
  border-radius: 4px;
}
.footer .widget .iconlist ul li a:hover
{
	background:#9759FF;
}
.footer .widget .iconlist ul li a i
{
	line-height: 1.75;
}
    
.footer .copyrights
{
	padding-top:30px;
	padding-bottom:0px;
	font-size:14px;
	line-height:18px;
	font-weight:300;
	color:#131220;
}
@media (min-width: 320px) and (max-width: 767px) {
  .footer .widget {
    margin-bottom: 30px;
  }
}
</style>
