<template>

        <div v-if="content.length">
<!--            <v-carousel v-if="!mobile" class="no-mobile"  style="position: absolute; width: 100%; max-width: 100%"-->
<!--                        height="44"-->
<!--                        hide-delimiter-background-->
<!--                        :show-arrows="false"-->
<!--            >-->
<!--                <v-carousel-item-->
<!--                        v-for="(text, i) in content"-->
<!--                        :key="i"-->
<!--                >-->
<!--                    <v-sheet-->
<!--                            height="100%"-->
<!--                            color="#F3C150"-->
<!--                    >-->
<!--                        <v-row-->
<!--                                class="fill-height"-->
<!--                                align="center"-->
<!--                                justify="center"-->
<!--                        >-->
<!--                            <v-row class="p-lg-4 py-0">-->
<!--                                <v-col style="font-size: 12px" >-->
<!--                                    <v-container class="ma-0" style="max-width: 650px">-->
<!--                                        {{text}}-->
<!--                                    </v-container>-->
<!--                                </v-col>-->
<!--                            </v-row>-->
<!--                        </v-row>-->
<!--                    </v-sheet>-->
<!--                </v-carousel-item>-->
<!--            </v-carousel>-->

<!--            <v-carousel v-else-->
<!--                        height="auto"-->
<!--                        hide-delimiter-background-->
<!--                        :show-arrows="false"-->
<!--            >-->
<!--                <v-carousel-item-->
<!--                        v-for="(text, i) in content"-->
<!--                        :key="i"-->
<!--                >-->
<!--                    <v-sheet-->
<!--                            height="100%"-->
<!--                            color="#F3C150"-->
<!--                    >-->
<!--                        <v-row-->
<!--                                class="fill-height"-->
<!--                                align="center"-->
<!--                                justify="center"-->
<!--                        >-->
<!--                            <v-col>-->
<!--                            <v-row class="p-lg-4 py-0 mb-8">-->
<!--                                <v-col style="font-size: 12px" >-->
<!--                                    <v-container class="ma-0 text-center"  style="max-width: 650px">-->
<!--                                        {{text}}-->
<!--                                    </v-container>-->
<!--                                </v-col>-->
<!--                            </v-row></v-col>-->
<!--                        </v-row>-->
<!--                    </v-sheet>-->
<!--                </v-carousel-item>-->
<!--            </v-carousel>-->

            <v-carousel class="no-mobile d-none d-md-block"  style="position: absolute; width: 100%; max-width: 100%"
                        height="54"
                        hide-delimiter-background
                        :show-arrows="false"
            >
                <v-carousel-item
                        v-for="(text, i) in content"
                        :key="i"
                >
                    <v-sheet
                            height="100%"
                            color="#F3C150"
                    >
                        <v-row
                                class="fill-height"
                                align="center"
                                justify="center"
                        >
                            <v-row class="p-lg-4 py-0">
                                <v-col style="font-size: 12px" >
                                    <v-container class="ma-0 text md-content">
                                        {{text}}
                                    </v-container>
                                </v-col>
                            </v-row>
                        </v-row>
                    </v-sheet>
                </v-carousel-item>
            </v-carousel>

            <v-carousel class="d-none d-sm-block d-md-none" style="position: absolute; left: 0px"
                        height="auto"
                        hide-delimiter-background
                        :show-arrows="false"
            >
                <v-carousel-item
                        v-for="(text, i) in content"
                        :key="i"
                >
                    <v-sheet
                            height="100%"
                            color="#F3C150"
                    >
                        <v-row
                                class="fill-height"
                                align="center"
                                justify="center"
                        >
                            <v-col>
                                <v-row class="p-lg-4 py-0 mb-8">
                                    <v-col style="font-size: 12px" >
                                        <v-container class="ma-0 text-center"  style="max-width: 650px">
                                            {{text}}
                                        </v-container>
                                    </v-col>
                                </v-row></v-col>
                        </v-row>
                    </v-sheet>
                </v-carousel-item>
            </v-carousel>
            <div class="d-none d-sm-block d-md-none" style="width: 100%; height: 80px"></div>
            <v-carousel class="d-block d-sm-none"
                        height="auto"
                        hide-delimiter-background
                        :show-arrows="false"
            >
                <v-carousel-item
                        v-for="(text, i) in content"
                        :key="i"
                >
                    <v-sheet
                            height="100%"
                            color="#F3C150"
                    >
                        <v-row
                                class="fill-height"
                                align="center"
                                justify="center"
                        >
                            <v-col>
                                <v-row class="p-lg-4 py-0 mb-8">
                                    <v-col style="font-size: 12px" >
                                        <v-container class="ma-0 text-center"  style="max-width: 650px">
                                            {{text}}
                                        </v-container>
                                    </v-col>
                                </v-row></v-col>
                        </v-row>
                    </v-sheet>
                </v-carousel-item>
            </v-carousel>
        </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    export default {
        props: ['route'],
        data(){
            return{
                content: []
            }
        },
        computed: {
            ...mapGetters({
                mobile: 'util/mobile'
            }),
        },
        created() {
            if(this.route == 'dashboard'){
                this.content = [
                    'Your dashboard has quick access to your Earnings & Analytics snapshot, Calendar and Appointments.',
                    'Tapping the Respectfully™ logo above will always get you back to your dashboard.',
                ];
                this.content.push(this.mobile? 'In the hamburger menu above, tap the Edit Profile button' : 'On your lefthand side, tap the Edit Profile button.')
            }
            else if(this.route == 'psychic_profile'){
                this.content = [
                    'Complete the information below to show off your experience, qualifications and personality.',
                    'Save your changes, then share your Profile URL with your social following and potential clients.',
                ];
                this.content.push(this.mobile? 'In the hamburger menu above, tap the Schedule button.' : 'On your lefthand side, tap the Schedule button.')
            }
            else if(this.route == 'dashboard_services'){
                this.content = [
                    'Enable services with the toggle and set rates for each individually.',
                    'If you would like to offer chat for free, tap the checkbox.',
                    'Set your schedule and we’ll automatically update your status to online during those windows.'
                ];
            }
            else if(this.route == 'dashboard_payout_method'){
                this.content = [
                    'Tap Money to view your earnings quick stats, transaction and payout history.',
                    'Tap Analytics to view your detailed stats and set your earnings goal.'
                ];
            }


        }
    }
</script>

<style>
    .no-mobile .v-carousel__controls__item.v-btn.v-item--active, .v-carousel__controls__item.v-btn.v-item--active{
        color: #9759FF;
    }

    .no-mobile .v-carousel__controls .v-item-group{
        position: absolute !important;
        left: 54%;
        /*left: 200px;*/
    }

    .no-mobile .v-carousel__controls{
        display: grid;
    }
    .md-content{
        max-width: 650px;
    }
    @media (max-width: 1200px) {
        .container.md-content {
            max-width: 580px;
        }
    }
</style>
