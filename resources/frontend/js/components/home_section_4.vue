<template>
<section class="thirdSectionHeading thirdSectionHeading-about" style="background: #fff">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="thirdSectionHeadingContainer">
                    <p>
                        At Respectfully™, you will enjoy personal readings and real answers from the world’s best models, mediums, healers, and astrologers who are always available to connect with you. Our clients can’t stop praising the accurate, in-depth answers they receive when they need them the most. Plus, you will always feel safe with total privacy with every reading. 
                        <br><br>
                        First psychic readings can be daunting, which is why we’ve made our gallery of trusted spiritual advisors as transparent as possible before you decide on a psychic for your first reading. You can see ratings from our real clients, bios, personalized introductory videos, and more to make you feel as comfortable as possible before hitting send.
                        
                    </p>
                    <a @click.prevent="openSignUpPopUp()" class="ctaBtn applyBtnMob mt-5" v-if="$vuetify.breakpoint.xsOnly">Sign Up for Free</a>
                    <a @click="openSignUpPopUp()" class="ctaBtn applyBtn mt-5" style="margin: auto; " v-if="!$vuetify.breakpoint.xsOnly">Sign Up for Free</a>
                    
                </div>
            </div>
        </div>
    </div>
</section>
    <!-- <section class="fourthSection">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="fourthSecContainer">
                        <h3>Why we’re Better</h3>
                        <div class="fourthSecItemContainer">
                            <div class="fItemContainer">
                                <div class="iconContainer">
                                    <img src="/images/icons/easy-access.png" alt="Easy Access" class="img-fluid">
                                </div>
                                <div class="fitemContent">
                                    <h5>Easy Access</h5>
                                    <p>Our user-friendly platform makes it easy to get started and simple to find
                                        exactly what you’re looking for.</p>
                                </div>
                            </div>

                            <div class="fItemContainer">
                                <div class="iconContainer">
                                    <img src="/images/icons/flexibility.png" alt="Total Flexibility" class="img-fluid">
                                </div>
                                <div class="fitemContent">
                                    <h5>Total Flexibility</h5>
                                    <p>Forget long wait times and hard-to-get appointments. Log on with one click from
                                        anywhere in the world, as often as you want.</p>
                                </div>
                            </div>

                            <div class="fItemContainer">
                                <div class="iconContainer">
                                    <img src="/images/icons/empowered.png" alt="Empowered Connections" class="img-fluid">
                                </div>
                                <div class="fitemContent">
                                    <h5>Empowered Connections</h5>
                                    <p>Through direct, 1:1 conversations you’ll gain more clarity and deeper
                                        understandings of what matters most to you.</p>
                                </div>
                            </div>
                        </div>
                        <a @click.prevent="openSignUpPopUp()" class="ctaBtn">Sign Up for Free</a>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

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