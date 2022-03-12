<template>
	<div class="vue-dashboard-media dashboard_new_post dashboard_edit_post" style="padding: 0px;">
		<form class="form-dashboard" @submit="edit_post_submit">
			<div class="row main-split">
				<div class="col" id="list-of-media" style="padding-left: 12px !important; padding-right: 12px !important;">
					<div style="height: 30px"></div>

					<div class="list-of-media" v-if="post_medium[0].length != 0">
						<div class="a-media" v-for="(media, key) in post_medium[0]" >
							<div class="hover-wrapper">

								<div class="x-hover"><div class="x-style" @click="remove_media(media);">
									<i class="fas fa-times"></i></div></div>

								<img v-if="media.type == 'IMAGE'" v-bind:src="media.url" />

								<div class="a-video" v-if="media.type == 'VIDEO'"> 
									<i class="fas fa-play-circle"></i>
									<video v-bind:src="media.url" muted="true" preload="metadata"></video>
								</div>
							</div>

							<div class="details">
								<h4 style="font-size: 14px; padding-bottom: 0; margin-bottom: 0;">{{ media.name }}</h4>

								<span class="text-danger" style="font-size: 75%; font-weight: 600; cursor: pointer;" @click="remove_media(media);">
									Remove
							  	</span>
							</div>
						</div>

						<div class="a-media">
							
							<div style="text-align: center; padding: 81.5px 0px; font-weight: 600; border: 2px solid; background-color: #fff; cursor: pointer;" data-toggle="modal" data-target="#addMediaModal">
								
								<span class="btn btn-pink">
									+ Add Media +
								</span>

							</div>

						</div>

						<div class="clearfix"></div>
						
					</div>

					<div v-if="post_medium[0].length == 0" style="background-color: #fff; padding: 25px 0px; font-weight: 600; text-align: center;">
						No Media Attached

						<br>
						<br>

						<div style="font-weight: 500; text-align: center;">
							<span class="btn btn-pink" data-toggle="modal" data-target="#addMediaModal" style="cursor: pointer;">
								+ Add Media +
							</span>
						</div>
					</div>

					<hr>

					<div class="form-group">
						<label>Title</label>
						<input type="text" v-model="post.title" class="form-control">
					</div>

					<div class="form-group">
						<label>Description</label>
						<textarea v-model="post.description" class="form-control"></textarea>
					</div>

					<hr>

					<div class="form-group">
						<label class="styled" style="margin-right: 5px;">
							<input type="radio" v-model="post.pricing" value="Teaser">
							<span class="styled-radio"> Teaser</span>
						</label>

						<label class="styled">
							<input type="radio" v-model="post.pricing" value="Premium" checked>
							<span class="styled-radio"> Premium</span>
						</label>
					</div>

					<div class="form-group footer-btns">
						<div class="schedule-toggle show">
							<v-btn type="submit" class="btn btn-primary btn-pink" :loading="sending_post" :disabled="sending_post" style="font-size: 16px; text-transform: none;">
							  Update Post
							</v-btn>

							<span class="d-md-inline d-lg-none">

								<v-btn id="btn-post-now" type="button" class="btn btn-primary btn-pink" :loading="sending_post && post.status == 'PUBLISHED'" :disabled="sending_post && post.status == 'PUBLISHED'"  v-if="post.status == 'DRAFT' || post.is_scheduled" @click="post_as_new();" style="font-size: 16px; text-transform: none;">
								  Post Now
								</v-btn>

								<v-btn id="btn-post-draft" type="button" class="btn btn-purple" :loading="sending_post && post.status == 'DRAFT'" :disabled="sending_post && post.status == 'DRAFT'"  v-if="post.status == 'PUBLISHED'" @click="post_as_draft();" style="font-size: 16px; text-transform: none;">
								  Save as draft
								</v-btn>

								<button type="button" class="btn btn-purple-border" style="font-size: 16px; padding: 0.375rem 0.75rem;" data-toggle="collapse" data-target=".schedule-toggle" v-if="! (! post.is_scheduled && post.status == 'PUBLISHED')">Schedule</button>
							</span>
						</div>
					</div>

					<div class="d-md-block d-lg-none">
						<div class="Schedule-Overlay collapse schedule-toggle">
							<div class="card card-body" style="border: 0px; padding: 0px;">
								<i class="fas fa-times" style="float: left; cursor: pointer;" data-toggle="collapse" data-target=".schedule-toggle"></i>

								<h4>Set schedule time</h4>

								<div class="row form-group">
									<div class="col-auto mr-auto">Day</div> 
									<div class="col-auto"><input type="date" class="form-control" v-model="pick_post_schedule.date" style="width: 135px;"></div>
								</div>
								<div class="row form-group">
									<div class="col-auto mr-auto">Time</div> 
									<div class="col-auto"><input type="time" class="form-control" v-model="pick_post_schedule.time" style="width: 135px;"></div>
								</div>

								<div class="form-group text-danger"  v-if="errors.available_after">
									<span>{{ errors.available_after[0] }}</span>
								</div>

								<button type="button" class="btn btn-block btn-purple" @click="post_as_scheduled();">Confirm Schedule</button>
							</div>
						</div>

						<br>
						<span class="text-success" v-if="sending_post" style="font-weight: 600;">Saving Post...</span>        
						<span class="text-success" v-if="successfully_edited" style="font-weight: 600;">Saved Post..!</span>  

						<p>
							<span class="text-danger" v-if="error_message" style="font-weight: 600;">*{{ error_message }}</span>

							<ul v-if="media_to_remove.length > 0">
								<li><span style="font-size: 75%; font-weight: bold;">*try removing them</span></li>
								<li v-for="r_media in media_to_remove">{{ r_media.name }}</li>
							</ul>        
						</p>
					</div>

				</div>

				<div class="col-3 selected-file-details" style="">
					
					<div style="height: 30px;"></div>
				  
					<p>
						Status: 
						<b class="text-success" v-if="! post.is_scheduled">{{ post.status }}</b>
						<b class="text-success" v-if="post.is_scheduled">SCHEDULED</b>
					</p>

					<div class="schedule-toggle show">

						<div v-if="post.status == 'DRAFT' || post.is_scheduled">
							<v-btn id="btn-post-now" type="button" class="btn btn-block btn-primary btn-pink" :loading="sending_post && post.status == 'PUBLISHED'" :disabled="sending_post && post.status == 'PUBLISHED'" @click="post_as_new();" style="font-size: 16px; text-transform: none;">
							  Post Now
							</v-btn>

							<br>
							<br>
						</div>

						<div v-if="post.status == 'PUBLISHED'">
							<v-btn id="btn-post-draft" type="button" class="btn btn-block btn-purple" :loading="sending_post && post.status == 'DRAFT'" :disabled="sending_post && post.status == 'DRAFT'" @click="post_as_draft();" style="font-size: 16px; text-transform: none;">
							  Save as draft
							</v-btn>

							<br>
							<br>
						</div>

						<button type="button" class="btn btn-block btn-purple-border" style="font-size: 16px; padding: 0.375rem 0.75rem;" data-toggle="collapse" data-target=".schedule-toggle" v-if="! (! post.is_scheduled && post.status == 'PUBLISHED')">Schedule</button>
					</div>

					<div class="Schedule-Overlay collapse schedule-toggle">
						<div class="card card-body" style="border: 0px; padding: 0px;">
							<i class="fas fa-times" style="float: left; cursor: pointer;" data-toggle="collapse" data-target=".schedule-toggle"></i>

							<h4>Set schedule time</h4>

							<div class="row form-group">
								<div class="col-auto mr-auto">Day</div> 
								<div class="col-auto"><input type="date" class="form-control" v-model="pick_post_schedule.date" style="width: 135px;"></div>
							</div>
							<div class="row form-group">
								<div class="col-auto mr-auto">Time</div> 
								<div class="col-auto"><input type="time" class="form-control" v-model="pick_post_schedule.time" style="width: 135px;"></div>
							</div>

							<div class="form-group text-danger"  v-if="errors.available_after">
								<span>{{ errors.available_after[0] }}</span>
							</div>

							<button type="button" class="btn btn-block btn-purple" @click="post_as_scheduled();">Confirm Schedule</button>
						</div>
					</div>
				  
					<br>
					<span class="text-success" v-if="sending_post" style="font-weight: 600;">Saving Post...</span>        
					<span class="text-success" v-if="successfully_edited" style="font-weight: 600;">Saved Post..!</span>  

					<p>
						<span class="text-danger" v-if="error_message" style="font-weight: 600;">*{{ error_message }}</span>

						<ul v-if="media_to_remove.length > 0">
							<li><span style="font-size: 75%; font-weight: bold;">*try removing them</span></li>
							<li v-for="r_media in media_to_remove">{{ r_media.name }}</li>
						</ul>        
					</p>
				</div>
			</div>
		</form>
	
		<div class="modal fade" id="addMediaModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content" style="border-radius: 0px;">
                    <div class="modal-header" style="background-color: #fff; border-bottom: 0px; border-radius: 0px;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: -1rem auto -1rem -1rem; z-index: 900;">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        <h5 class="modal-title" style="position: absolute; z-index: 800; width: 100%; text-align: center;">Add Media</h5>
                    </div>
                    <div class="modal-body" style="background-color: #F9F9F9;">                        
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

				                <list-of-media ref="media_list" ></list-of-media>

				              </v-card>
				            </v-tab-item>
				        </v-tabs> 
                    </div>
                    <div class="modal-footer" style="border-radius: 0px;">
                        <button type="button" class="btn btn-pink" @click="add_media_to_post();">Add To Post</button>
                    </div> 
                </div>
            </div>
        </div>
	</div>
</template>

<script>
	
  export default {
	props: ['postId'],

	data() {
	  return {
			tab_in_use: 'media',

			user_subscriptions: [],
			
			post: {title: '', medium: { '0': [], count: 0}},
			post_medium: { '0': [], count: 0},
			pick_post_schedule: {
			  date: '',
			  time: '',
			},

			sending_post: false,
			successfully_edited: false,

			message: '',
			error_message: '',
			errors: [],
			media_to_remove: [],
	  };
	},

	methods: {
	  get_subscriptions() {
			axios.get('/api/v1/user/subscriptions')
			.then(response => {
				this.user_subscriptions=response.data.subscriptions;

			})
			.catch(function (error) {
				if (error.response && (error.response.status === 401 || error.response.status === 419)) {
					location.reload();
				}
			});
	  },

	  get_post() {
			axios.get('/api/v1/post/'+this.postId)
			.then(response => {

				console.log( response.data.data );

				this.post = response.data.data; 
				this.post_medium = JSON.parse(JSON.stringify(response.data.data.medium));

				if (this.post.is_scheduled) {

					var available_after=this.post.available_after.split(' ');

					this.pick_post_schedule.date=available_after[0];
					this.pick_post_schedule.time=available_after[1];

				}
			})
			.catch(function (error) {
				if (error.response && (error.response.status === 401 || error.response.status === 419)) {
					location.reload();
				}
			});

	  },

	  edit_post_submit(e) {

			e.preventDefault();

			this.post._available_after=new Date(this.post.available_after);

			this.send_off();

	  },

	  remove_media(media) {
			this.$delete(
				this.post_medium[0], 
				this.post_medium[0].map((media) => {return media.id;}).indexOf(media.id)
			);

			this.$delete(
				this.media_to_remove, 
				this.media_to_remove.map((media) => {return media.id;}).indexOf(media.id)
			);
	  },

	  post_as_new() {
			this.post.status="PUBLISHED";
			this.post._available_after=new Date();

			this.send_off();
	  },

	  post_as_draft() {
			this.post.status="DRAFT";
			this.post._available_after=new Date();
					
			this.send_off();
	  },

	  post_as_scheduled() {
			this.post.status="PUBLISHED";

			if (this.pick_post_schedule.date != '' && this.pick_post_schedule.time != '') {
			  this.post._available_after=new Date(this.pick_post_schedule.date+' '+this.pick_post_schedule.time);
			  this.errors={};

			  if (typeof this.post._available_after != 'undefined' && this.post._available_after != '') {
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
			}
			else {
			  this.errors = {
					'available_after': [
					  'Please fill in date and time of when you like this post to be public!',
					]
			  };
			}
			
	  },

	  send_off() {
		return new Promise((resolve) => {
			this.sending_post=true;

			this.post.available_after=this.post._available_after.toISOString().slice(0, 19).replace('T', ' '); 

			this.post.medium = this.post_medium[0].map((media) => {return media.id;});

			resolve();

		}).then(() => {

			axios.put('/api/v1/post/'+this.post.id, this.post)
				.then(response => {
					setTimeout(() => {
					  
						this.sending_post=false;
						this.successfully_edited=true;

						setTimeout(() => {
							this.successfully_edited=false;
						}, 1000);

						this.pick_post_schedule.date="";
						this.pick_post_schedule.time="";

						this.message = response.data.message;
						this.errors = [];
						this.error_message="";
						this.media_to_remove=[];

				  }, 500);
				})
				.catch(error => {
				  setTimeout(() => {
				  	this.media_to_remove=[];

					if (error.response && (error.response.status === 401 || error.response.status === 419)) {
						location.reload();
					}

					if (typeof error.response.data.error === 'string') {
					  this.error_message = error.response.data.error;

					  if (this.error_message == 'Incorrect media Premium') {
					  	this.media_to_remove=[];

					  	error.response.data.data.forEach((de) => {
							
							this.media_to_remove.push(
						  		this.post_medium[0].filter((p_media) => {

						  			return de.media_id == p_media.id;

						  		})[0]
					  		);
					  		
					  	});
					  }
					}
					else if (typeof error.response.data === 'object') {
					  this.errors = error.response.data.errors;
					} else {
					  this.errors = ['Something went wrong. Please try again.'];
					}
					
					this.sending_post=false;
					this.successfully_edited=false;
					this.message = "";
				  }, 500);
				});

		});
	  },

	  push_to_medium(media) {

	  	var current_ids=this.post_medium[0].map((post_media) => {return post_media.id;});

	  	if (current_ids.indexOf( media.id ) == -1) {

	  		this.post_medium[0].push(media);

	  	}
	  },

	  add_media_to_post() {
	  	return new Promise((resolve) => {
	  		switch (this.tab_in_use) {

              case 'upload':
                console.log(this.$refs.uploader);

				this.$refs.uploader.upload_process().then(( uploaded_media ) => {

					uploaded_media.forEach((u_media) => {

						this.push_to_medium( u_media );

					});

					resolve();

				});
            
                break;

              case 'albums':
           		console.log(this.$refs.albums);

                this.$refs.albums.selectedAlbum.medium.forEach((album_media) => {
                	
                	this.push_to_medium( album_media );

                });
				
				resolve();

                break;

              case 'media':
                console.log(this.$refs.media_list);

                this.$refs.media_list.selectedMedia.forEach((media) => {

                	this.push_to_medium( media );

                });

                resolve();

                break;

            }
	  	}).then(() => {

	  		jQuery('#addMediaModal').modal('hide');

	  	})


	  },

	},

	mounted() {
	  
	  this.get_subscriptions();
	  this.get_post();

	}

  }
</script>