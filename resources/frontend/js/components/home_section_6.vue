<template>
    <section class="sixthSection" style="background: #43425D;">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="sixthSecContainer">
                        <h3 style="text-transform: capitalize;">Are You A Model? Join Our Network</h3>
                        <h4>Connect, Support and Earn on your Terms.</h4>
                        <a @click.prevent="openSignUpPopUp()" class="ctaBtn applyBtnMob mt-6" v-if="$vuetify.breakpoint.xsOnly">Apply Now</a>
                        <a href="#" @click.prevent="openSignUpPopUp" class="ctaBtn mt-6 applyBtn" style="margin: auto;" v-if="!$vuetify.breakpoint.xsOnly">Apply Now</a>
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
                EventBus.$emit('open_sign_up',  {});
            },
            loadUser(){

            }
        }
    }
</script>