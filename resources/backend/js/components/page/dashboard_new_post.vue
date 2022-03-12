<template>
	<div class="vue-dashboard-media dashboard_new_post" style="padding: 0px;">
    <form class="form-dashboard" @submit="new_post_submit">
      <div class="row main-split">
        <div class="col-md" id="list-of-media">
            
          <v-tabs v-model="tab_in_use">
            <v-tab :key="'upload'" :href="'#upload'">
              Upload Media
            </v-tab>
            <v-tab :key="'albums'" :href="'#albums'">
              Albums
            </v-tab>
            <v-tab :key="'media'" :href="'#media'">
              Choose from Gallery
            </v-tab>

            <v-tab-item :key="'upload'" :value="'upload'">
              <v-card flat tile>               

                <dashboard-media-uploader ref="uploader"></dashboard-media-uploader>

              </v-card>
            </v-tab-item>
            <v-tab-item :key="'albums'" :value="'albums'">
              <v-card flat tile>
              
                <list-of-album ref="albums"></list-of-album>

              </v-card>
            </v-tab-item>
            <v-tab-item :key="'media'" :value="'media'">
              <v-card flat tile>

                <list-of-media ref="media_list" only-show-unsigned="true"></list-of-media>

              </v-card>
            </v-tab-item>
          </v-tabs> 
        </div>

        <div class="col-md selected-file-details" style="">
        	
        	<div style="height: 15px;"></div>
          
          <!-- <h2>Create a post</h2> -->

          <div >

            <div class="form-group">
              <input type="text" v-model="new_post.title" class="form-control" placeholder="Title" required="" min="3">
              <span v-if="errors.title" class="text-danger">{{ errors.title[0] }}</span>
            </div>

            <div class="form-group">
              <textarea v-model="new_post.description" class="form-control" placeholder="Description">
                
              </textarea>
              <span v-if="errors.description" class="text-danger">{{ errors.description[0] }}</span>
            </div>

            <div class="form-group">
              <label class="styled" style="margin-right: 5px;">
                <input type="radio" v-model="new_post.pricing" value="Teaser">

                <span class="styled-radio"> Teaser</span>
              </label>

              <label class="styled">
                <input type="radio" v-model="new_post.pricing" value="Premium" checked>
                <span class="styled-radio"> Premium</span>
              </label>
            </div>
          </div>

          <div class="schedule-toggle show">

            <v-btn id="btn-post-now" type="button" class="btn btn-block btn-primary btn-pink" :loading="sending_post && new_post.status == 'PUBLISHED'" :disabled="sending_post && new_post.status == 'PUBLISHED'" @click="post_as_new();" style="font-size: 16px; text-transform: none;">
              Post Now
            </v-btn>

          	<!-- <button type="button" class="btn btn-block btn-pink" style="font-size: 16px;" @click="post_as_new();">Post Now</button> -->
          	<br>
            <br>
            <!-- <button type="button" class="btn btn-block btn-purple" style="font-size: 16px;" @click="post_as_draft();">Save as draft</button> -->
            
            <v-btn id="btn-post-draft" type="button" class="btn btn-block btn-purple" :loading="sending_post && new_post.status == 'DRAFT'" :disabled="sending_post && new_post.status == 'DRAFT'" @click="post_as_draft();" style="font-size: 16px; text-transform: none;">
              Save as draft
            </v-btn>

            <br>
            <br>

          	<button type="button" class="btn btn-block btn-purple-border" style="font-size: 16px; padding: 0.375rem 0.75rem;" data-toggle="collapse" data-target=".schedule-toggle">Schedule</button>
          </div>

          <datepicker v-model="date" name="hello_world"></datepicker>

          <div class="Schedule-Overlay collapse schedule-toggle">
            <div class="card card-body" style="border: 0px; padding: 0px;">
              <i class="fas fa-times" style="float: left; cursor: pointer;" data-toggle="collapse" data-target=".schedule-toggle"></i>

        			<h4>Set schedule time</h4>

        			<div class="row form-group">
        				<div class="col-auto mr-auto">Day</div> 
        				<div class="col-auto"><input type="date" class="form-control" v-model="pick_post_schedule.date"></div>
        			</div>
        			<div class="row form-group">
        				<div class="col-auto mr-auto">Time</div> 
        				<div class="col-auto"><input type="time" class="form-control" v-model="pick_post_schedule.time"></div>
        			</div>

              <div class="form-group text-danger"  v-if="errors.available_after">
                <span>{{ errors.available_after[0] }}</span>
              </div>

        			<button type="button" class="btn btn-block btn-purple" @click="post_as_scheduled();">Confirm Schedule</button>
            </div>
        	</div>
          
          <br>

          <span class="text-success" v-if="sending_post" style="font-weight: 600;">Creating Post...</span>

          <span class="text-success" v-if="successfully_created" style="font-weight: 600;">Created Post..!</span>  

          <p class="text-danger" v-if="error_message" style="font-weight: 600;">*{{ error_message }}</p>        
        </div>
      </div>
    </form>
  </div>
</template>

<script>
	
  export default {

    data() {
      return {
        date: new Date(2016, 9,  16),
        tab_in_use: 'upload',
        selectedMedia: [],
        selectedAlbum: {},

        user_subscriptions: [],

        pick_post_schedule: {
          date: '',
          time: '',
        },

        new_post: {},

        post_reset: {
          title: '',
          status: '',
          //subscription: 1, // i dont like
          pricing: 'Premium',
          _available_after: '',
          medium: [],
        },

        sending_post: false,
        successfully_created: false,
        message: '',
        error_message: '',
        errors: [],
      };
    },

    methods: {
      get_subscriptions() {
        axios.get('/api/v1/user/subscriptions')
        .then(response => {
            this.user_subscriptions=response.data.subscriptions;

            this.post_reset.subscription=this.user_subscriptions[0].id;
            this.new_post.subscription=this.user_subscriptions[0].id;
        })
        .catch(function (error) {
            if (error.response && (error.response.status === 401 || error.response.status === 419)) {
                location.reload();
            }
        });
      },

      new_post_submit(e) {

        e.preventDefault();

        /*if (this.new_post.status == '' || typeof this.new_post.status == 'undefined') {
          this.new_post.status="DRAFT";
        }*/

       
      },

      post_as_new() {
        this.new_post.status="PUBLISHED";
        this.new_post._available_after=new Date();

        this.send_off();
      },

      post_as_draft() {
        this.new_post.status="DRAFT";
        this.new_post._available_after=new Date();
                
        this.send_off();
      },

      post_as_scheduled() {
        this.new_post.status="PUBLISHED";

        if (this.pick_post_schedule.date != '' && this.pick_post_schedule.time != '') {
          this.new_post._available_after=new Date(this.pick_post_schedule.date+' '+this.pick_post_schedule.time);
          this.errors={};
        }
        else {
          this.errors = {
            'available_after': [
              'Please fill in date and time of when you like this post to be public!',
            ]
          };
        }

        if (typeof this.new_post._available_after != 'undefined' && this.new_post._available_after != '') {
          this.send_off();
          this.errors={};
        }
        else {
          this.errors = {
            'available_after': [
              'Please fill in date and time of when you like this post to be public!',
            ]
          };
        }

      },

      all_done(response) {
        setTimeout(() => { 
          this.sending_post=false;
          this.successfully_created=true;

          this.message = response.data.message;
          this.errors = [];

          setTimeout(() => {
            //this.successfully_created=false;
          
            window.open('/dashboard', '_self');
          }, 500);

          /*        
            this.new_post=JSON.parse(JSON.stringify(this.post_reset));
            
            this.pick_post_schedule.date="";
            this.pick_post_schedule.time="";

            if (typeof this.$refs.media_list != 'undefined') {
              this.$refs.media_list.medium.forEach((media) => {

                this.$refs.media_list.$set(media, 'active', false);                  

              });

              this.$refs.media_list.page=1;
              this.$refs.media_list.get_medias();

            }

            if (typeof this.$refs.albums != 'undefined') {
              this.$refs.albums.selected_album=0;
            }
          */
        }, 500);

      },

      all_done_error(error) {

        setTimeout(() => {

          if (error.response && (error.response.status === 401 || error.response.status === 419)) {
              location.reload();
          }

          if (typeof error.response.data.error === 'string') {
            this.error_message = error.response.data.error;
          }
          else if (typeof error.response.data === 'object') {
            this.errors = error.response.data.errors;
          } else {
            this.errors = ['Something went wrong. Please try again.'];
          }
          
          this.sending_post=false;
          this.successfully_created=false;
          this.message = "";
        }, 500);

      },

      send_off() {
        if (this.sending_post == false) {
          return new Promise((resolve) => {
            this.sending_post=true;

            this.new_post.available_after=this.new_post._available_after.toISOString().slice(0, 19).replace('T', ' '); 
            
            switch (this.tab_in_use) {

              case 'upload':
                console.log(this.$refs.uploader);

                axios.post(
                  '/api/v1/post', 
                  Object.assign(JSON.parse(JSON.stringify(this.new_post)), {status: "DRAFT"})
                )
                .then(response => {
                  
                  this.$refs.uploader.upload_process().then(( uploaded_media ) => {

                    this.new_post.medium=uploaded_media.map((media) => {return media.id;});

                    resolve(response.data.data);
                    
                  }); 

                })
                .catch(error => {
                  setTimeout(() => {
                    if (error.response && (error.response.status === 401 || error.response.status === 419)) {
                        location.reload();
                    }
                    if (typeof error.response.data === 'object') {
                        this.errors = error.response.data.errors;
                    } else {
                        this.errors = ['Something went wrong. Please try again.'];
                    }
                    
                    this.sending_post=false;
                    this.message = "";
                    resolve();
                  }, 500);
                });
                
                break;

              case 'albums':
                console.log(this.$refs.albums);

                this.new_post.medium=this.$refs.albums.selectedAlbum.medium.map((media) => {
                  return media.id;
                });

                resolve();

                break;

              case 'media':
                console.log(this.$refs.media_list);

                this.new_post.medium=this.$refs.media_list.selectedMedia.map((media) => {
                  return media.id;
                });

                resolve();

                break;

            }

          }).then((response_data) => {
            switch (this.tab_in_use) {

              case 'upload':
                axios.put('/api/v1/post/'+response_data.id, this.new_post)
                  .then(this.all_done)
                  .catch(this.all_done_error);

                break;

              default:
                axios.post('/api/v1/post', this.new_post)
                  .then(this.all_done)
                  .catch(this.all_done_error);

                break;
            }
          });  

        }      
      },
    },

    mounted() {
      this.$set(this, 'new_post', JSON.parse(JSON.stringify(this.post_reset)));

      this.get_subscriptions();
    }

  }

</script>