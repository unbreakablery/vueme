<template>
	<div>


        <form class="form-dashboard" @submit="updateUserSchedule">
			<v-container class="row-gray-area p-0 mt-7">
				<v-row
						no-gutters
				>
					<v-col class="px-lg-0 px-md-0" cols="12"><div class="mb-0"><b>Schedule</b></div></v-col>
					<v-col class="px-lg-0 px-md-0" cols="12"><p class="grey--text small">Set the days and times when you are available to text, call or video chat with users</p></v-col>
				</v-row>
			</v-container>
			<v-container class="p-0">
	        <div class="weekly-schedule row m-0 ">
	        	
                <div class="day-of-week" v-for="(schedule, day) in user_schedule" :class="{ error: errors['user_schedule.'+day+'.from'] || errors['user_schedule.'+day+'.till'], }">
    	        	<label style="display: block; width: 100%; margin-bottom: 0px;">
    	        		<input type="checkbox" v-model="schedule.active" @change="defaultTime(schedule);">

    	        		<div class="style">
    		       			<span class="day">{{ day }}</span>
    		        		<span class="time">
    		        			<span v-if="! schedule.active">Not Scheduled</span>

    		        			<span v-if="schedule.active && (! schedule.from || ! schedule.till)">Set Time</span>

                                <span v-if="schedule.active && schedule.from && schedule.till" class="">
                                    {{ schedule.from | ampmtime }}-{{ schedule.till | ampmtime }}
                                </span>
    		        		</span>
    	        		</div>
    	        	</label>		        	

                    <div class="outter-overlay" v-if="schedule.active">
    	        		<div class="overlay">
    	        			<h6 style="color: rgba(31, 30, 52, .8);">Set schedule time</h6>

    	        			<div>
                                <input type="time" v-model="schedule.from" class="form-control"> 
        	        			<span class="to"></span> 
        	        			<input type="time" v-model="schedule.till" class="form-control"
                                :class="{'text-danger':errors['user_schedule.'+day+'.till']}">
    	              		</div>

                            <div>
                                <p v-if="errors['user_schedule.'+day+'.from']" class="text-danger">
                                    {{ errors['user_schedule.'+day+'.from'][0] }}
                                </p>
                                <p v-if="errors['user_schedule.'+day+'.till']" class="text-danger">
                                    {{ errors['user_schedule.'+day+'.till'][0] }}
                                </p> 
                            </div>
                        </div>
                    </div>
                </div>

	        </div>
			</v-container>

            <v-container>
                <v-row no-gutters>
                    <v-col cols="12" md="6" class="px-lg-0 px-md-0"> 
                        <div class="form-group">
                            <label>Timezone</label>
                            <v-select :items='timezonesok'
                                  label="Select"
                                  background-color="white lineSelect"
                                  filled
                                  dense
                                  flat
                                  hide-details
                                  solo
                                  v-model="timezone"
                                  :menu-props="{contentClass: 'checkList-line'}"
                            ></v-select>

                            <span v-if="errors['profile.country']" class="float-left text-danger small">{{ errors['profile.country'][0] }}</span>
                        </div>
                    </v-col>
                </v-row>
            </v-container>

			<v-container class="row-gray-area p-0 mt-5 mb-7">
				<v-row
						no-gutters
				>
					<v-col class="px-lg-0 px-md-0" cols="12"><div class="subtitle-1 mb-0">

						<v-btn  style="height: auto !important; min-width: auto !important; padding: 10px 20px !important;"
								type="submit"
								color="primary"
								:loading="savingSchedule"
								:disabled="savingSchedule"
								rounded
						>
							Save Schedule
						</v-btn>

						<span style="color: #01BF16; font-size: 75%;" v-if="savedSchedule">Successfully Saved.</span>
					</div></v-col>

				</v-row>
			</v-container>

        </form>
    </div>
</template>

<script>
    export default {
        props: ['timezones'],
        data() {
            return {
                savingSchedule: false,
                savedSchedule: false,
                user_id: 0,
                user_schedule: {
                	mon: {active: 0, from: '', till: '',},
                	tue: {active: 0, from: '', till: '',},
                	wed: {active: 0, from: '', till: '',},
                	thu: {active: 0, from: '', till: '',},
                	fri: {active: 0, from: '', till: '',},
                	sat: {active: 0, from: '', till: '',},
                	sun: {active: 0, from: '', till: '',}
                },
                errors: [],
                message: "",

                timezone: '',
                timezonesok: [],
            };


        },
        filters: {
            ampmtime: function (time) {
                if (typeof time == "string") {

                    time = time.split(':'); // convert to array

                    // fetch
                    var hours = Number(time[0]);
                    var minutes = Number(time[1]);
                    
                    if (typeof time[2] != 'undefined') {
                        var seconds = Number(time[2]);
                    }
                    else {
                       var seconds=0;
                    }

                    // calculate
                    var timeValue;

                    if (hours > 0 && hours <= 12) {
                      timeValue= "" + hours;
                    } else if (hours > 12) {
                      timeValue= "" + (hours - 12);
                    } else if (hours == 0) {
                      timeValue= "12";
                    }
                     
                    timeValue += (minutes < 10) ? ":0" + minutes : ":" + minutes;  // get minutes
                    //timeValue += (seconds < 10) ? ":0" + seconds : ":" + seconds;  // get seconds
                    timeValue += (hours >= 12) ? " P.M." : " A.M.";  // get AM/PM
                
                    return timeValue;
                }        
            }
        },
      
        methods: {

            /**
             * Prepare the component.
             */
            getUserSchedule() {

                axios.get('/api/v1/user/schedule')
                .then(response => {

                    this.user_id=response.data.success.user_id;

                    this.timezone = response.data.success.timezone;

                    if (Object.keys(response.data.success.user_schedule).length > 0) {
                        this.user_schedule=response.data.success.user_schedule;                    
                    }
                    
                })
                .catch(function(error) {
                    if (error.response && (error.response.status === 401 || error.response.status === 419)) {
                        location.reload();
                    }
                });

            },
            updateUserSchedule(e) {
                e.preventDefault();

                this.savingSchedule=true;

                for (var day in this.user_schedule) {

                    if (! this.user_schedule[day].active) {

                        delete this.user_schedule[day].from;
                        delete this.user_schedule[day].till;

                    }

                }

                axios.post('/api/v1/user/schedule/save', {'user_id': this.user_id, user_schedule: this.user_schedule, timezone: this.timezone,})
                    .then(response => {
                        setTimeout(() => {
                            this.savingSchedule=false;
                            this.savedSchedule=true;
                            
                            setTimeout(() => {
                                this.savedSchedule=false;

                            }, 2000);
                        }, 1000);
                        
                        this.message = response.data.message;
                        this.errors = [];
                    })
                    .catch(error => {
                        if (error.response && (error.response.status === 401 || error.response.status === 419)) {
                            location.reload();
                        }
                        if (typeof error.response.data === 'object') {
                            this.errors = error.response.data.errors;
                        } else {
                            this.errors = ['Something went wrong. Please try again.'];
                        }
                        
                        this.savingSchedule=false;
                        this.message = "";
                    });

            },

            defaultTime(schedule) {

                if (
                    (schedule.from == '' && schedule.till == '')
                    ||
                    (schedule.from == null && schedule.till == null)                
                ) {

                    schedule.from = '09:00';
                    schedule.till = '17:00';

                }

            }

        },  /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.getUserSchedule();

            var entries = Object.entries(this.timezones);
            entries.forEach((the_s) => {
                this.timezonesok.push({
                    text: the_s[0],
                    value: the_s[1],
                });
            });
        }
    }
</script>
