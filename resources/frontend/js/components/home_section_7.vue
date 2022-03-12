<template>

    <section class="footerAboveSection">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="footerAboveContainer">
                        <div class="imgContainer">
                            <img src="/images/footer-phone.png" alt="Phone" class="img-fluid">
                        </div>
                        <div class="footerRightContainer">
                            <h4>Open your eyes to what’s
                                ahead and take control of
                                your future today.</h4>
                            <a @click.prevent="openSignUpPopUp()" class="ctaBtn">Sign Up for Free</a>
                        </div>
                    </div>
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
                EventBus.$emit('open_sign_up_user',  {});
            },
            loadUser(){

            }
        }
    }
</script>