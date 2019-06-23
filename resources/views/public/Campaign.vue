<template>
  <div v-if="campaign != null">
    <div class="gallery-mini">
      <div class="static-gallery" :style="{'background-image': 'url(' + campaign.featured_image_url + ')'}">
        <div class="gallery-overlay">
        </div>
      </div>
    </div>
    <div>
      <div class="about-mini">
        <div class="header">
          <div>
            <p class="header-text">{{campaign.name}}</p>
            <p class="header-date">{{campaign.date}}</p>
          </div>
          <p class="header-left">Due to: {{campaign.due_date}}</p>
        </div>
        <div class="owner">
          <div class="owner-icon">
          </div>
          <div class="owner-name">
            <p>{{campaign.author_name}}</p>
            <span class="sharesaveHidden">
              <a href="#">
                <!-- change with svg -->
                <img src="/img/share-2.svg" alt="">
                Share
              </a>
              <a style="cursor: pointer" @click="changeFavouriteStatus">
                <!-- change with svg -->
                <img src="/img/heart.svg" alt="">
                Save
              </a>
            </span>
          </div>
        </div>
        <div class="story-mini">
          {{campaign.description}}
        </div>
      </div>
      <div class="completion">
        <p class="completion-donators">{{campaign.num_surveys_filled}} free donators</p>
        <div class="fillable-bar">
          <div class="filled-bar"></div>
        </div>
        <span>{{campaign.required_funding}}$<br> needed</span>
      </div>
      <div class="about hided-on-ms">
        <p class="about-header">About the campaign</p>
        <p class="about-content"> {{campaign.details}}</p>
      </div>
      <div class="gallery hided-on-ms">
        <p class="gallery-header">Gallery</p>
        <div class="gallery-content" v-if="gallery">
          <gallery-modal v-for="image in gallery" :campaign_photo_url="image.url" ></gallery-modal>
        </div>
      </div>
      <div class="comments hided-on-ms">
        <p class="comments-header">Comments</p>
        <div class="comment" v-for="comment in campaign.comments" v-bind:key="comment.id">
          <div class="icon"></div>
          <p class="comment-name">{{comment.author_name}}</p>
          <p class="comment-content">{{comment.body}}</p>
        </div>
      </div>
    </div>
    <div class="about hided-on-l">
        <p class="about-header">About the campaign</p>
        <p class="about-content"> {{campaign.details}}
        </p>
        </div>
    <div class="gallery hided-on-l">
        <p class="gallery-header">Gallery</p>
        <div class="gallery-content" v-if="gallery">
          <gallery-modal></gallery-modal>
          <div v-for="image in gallery" :style="{'background-image': 'url(' + image.url + ')'}"></div>
        </div>
    </div>
    <div class="comments hided-on-l">
      <p class="comments-header">Comments</p>
        <div class="comment" v-for="comment in campaign.comments" v-bind:key="comment.id">
          <div class="icon"></div>
          <p class="comment-name">{{comment.author_name}}</p>
          <p class="comment-content">{{comment.body}}</p>
        </div>
    </div>
    <div v-if="isLoggedIn" class="donate-section">
      <div>
        <span class="donate-share-save">
          <p class="donate-header">
            {{campaign.name}}
          </p>
          <a v-if="false" href="#">
          <!-- change with svg -->
            <img src="/img/share-2.svg" alt="">
                  Share
          </a>
          <a style="cursor:pointer;" @click="changeFavouriteStatus">
          <!-- change with svg -->
            <img v-if="favourite" src="/img/heart-red.svg" alt="">
            <img v-else src="/img/heart.svg" alt="">
                Save
          </a>
        </span>
        <donation-modal :campaign_id="campaign.id"/>
      </div>
    </div>
    <div class="donate-underspace">
    </div>
  </div>
</template>

<script>
  import store from "@js/store";
  import HTTP from "@js/Common/Http.service";
  import DonationModal from "@views/user/partials/DonationModal";
  import GalleryModal from "@views/public/partials/GalleryModal";

  export default {
    components: {
      DonationModal,
      GalleryModal
    },
    data() {
      return {
        campaign: null,
        gallery: null,
        favourite: false
      };
    },
    beforeRouteEnter(to, from, next) {
      store.dispatch("fetchCampaign", to.params.id)
              .then((campaign) => {
                console.log(campaign);
                next(vm => vm.setCampaign(campaign));
              }).catch(() => next());
    },
    beforeMount(){
      this.fetchGallery();
      if(this.isLoggedIn){
        HTTP.GET("/user/favourite-campaigns/"+this.$route.params.id)
                .then(res => {
                  console.log(res);
                  this.favourite = res.data.data;
                });
      }
    },
    computed: {
      id() {
        return this.$route.params.id;
      },
      isLoggedIn() {
        return this.$store.getters.isAuthenticated;
      },
    },
    methods:{
      setCampaign(campaign){
        this.campaign = campaign;
      },

      fetchGallery(){
        let galleryFetchUri = "/campaigns/" +this.$route.params.id+"/gallery";
        HTTP.GET(galleryFetchUri)
                .then(data => this.gallery = data.data.data)
                .catch(reason => console.log(reason.response));
      },

      changeFavouriteStatus(){
        if(!this.isLoggedIn) return;
        if(this.favourite)
          HTTP.DELETE("/user/favourite-campaigns/"+this.campaign.id)
                .then(() => this.favourite = false)
                  .catch(err => {
                    console.error(err.response);
                    window.alert("Couldn't be removed from favourites!");
                  });
        else
          HTTP.POST("/user/favourite-campaigns", {campaign_id: this.campaign.id})
                  .then(() => this.favourite = true)
                  .catch(err => {
                    console.error(err.response);
                    window.alert("Couldn't be added to favourites!");
                  })
      }
    }
  };
</script>
