<template>
    <section class="fourColSection earnings-fees-section">
        <div class="container text-center">
            <div class="row">
                <div class="col">
                    <h3 class="m-5">Earnings and Fees</h3>
                    <div class="fourthSecItemContainer">

                        <div class="fItemContainer">

                            <div class="py-5">
                                <img src="images/icons/1124.svg" alt="Sign up" class="img-fluid">
                            </div>
                            <p>You keep 80% of what you make.</p>
                        </div>
                        <div class="fItemContainer">

                            <div class="py-5">
                                <img src="images/icons/1125.svg" alt="Browse" class="img-fluid">
                            </div>
                            <p>Know exactly when you get paid with consistent, weekly payments.</p>
                        </div>
                        <div class="fItemContainer">

                            <div class="py-5">
                                <img src="images/icons/1126.svg" alt="Discover" class="img-fluid">
                            </div>
                            <p>Our fees are clear and all inclusive — that means no surprises later on. Plus, we’ve got your back with fraud and default protection.</p>
                        </div>


                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12 text-center justify-center d-flex">
                    <a  class="btn-action mt-5" 
                    href="javascript:void(0)"
                    @click="openSignUpPopUp()"
                    >
                        Apply Now
                    </a>
                </div>
            </div>
        </div>
    </section>

</template>
<script>
    export default {
        props: ['user', 'guest'],
        data: function () {
            return {
                loading: true,
                errors: [],
                signupDialog: false,
            }
        },
        mounted() {
            this.loadUser();
        },
        ready() {
            this.loadUser();
        },

        methods: {
            openSignUpPopUp(){
                EventBus.$emit('open_sign_up',  {});
            },
            loadUser(){

            }
        }
    }
</script>
<style scoped>
@media only screen and (max-width: 767.98px) {
	.earnings-fees-section {
		padding-bottom: 20px !important;
	}
	.earnings-fees-section .btn-action {
		display: inline-block !important;
	}
}
</style>