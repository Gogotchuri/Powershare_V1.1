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
          <p class="header-left">ძალაშია: {{campaign.due_date}}</p>
        </div>
        <div class="owner">
          <div class="owner-icon ">
             <img src="/img/default-profile.png" alt="">
          </div>
          <div class="owner-name">
            <p>{{campaign.author_name}}</p>
            <span class="sharesaveHidden">
              <a :href="shareLink" target="_blank">
              <!-- change with svg -->
                <img src="/img/share-2.svg" alt="">
                  გაზიარება
              </a>
              <a v-if="isLoggedIn" style="cursor:pointer;" @click="changeFavouriteStatus">
                <!-- change with svg -->
                <img v-if="favourite" src="/img/heart-red.svg" alt="">
                <img v-else src="/img/heart.svg" alt="">
                შეინახე
              </a>
            </span>
          </div>
        </div>
        <div class="story-mini">
          {{campaign.description}}
        </div>
      </div>
      <div class="completion">
        <p class="completion-donators">{{campaign.num_surveys_filled}} მოხალისე მხარდამჭერი</p>
        <div class="fillable-bar">
          <div class="filled-bar" v-bind:style="{ width : realizedPercentage+'%'}"></div>
        </div>
        <span>{{campaign.required_funding}}$<br> საჭიროა</span>
      </div>
      <div class="about hided-on-ms">
        <p class="about-header">კამპანიის შესახებ</p>
        <p class="about-content"> {{campaign.details}}</p>
      </div>
      <div v-if="hasGallery" class="gallery hided-on-ms">
        <p class="gallery-header">გალერეა</p>
        <div class="gallery-content" v-if="gallery">
          <gallery-modal v-for="image in gallery" v-bind:key="image.id" :campaign_photo_url="image.url" ></gallery-modal>
        </div>
      </div>
      <div class="comments hided-on-ms">
        <p class="comments-header">კომენტარები</p>
        <div class="comment" v-for="comment in campaign.comments" v-bind:key="comment.id">
          <div class="icon"></div>
          <p class="comment-name">{{comment.author_name}}</p>
          <p class="comment-content">{{comment.body}}</p>
        </div>
          <form v-if="isLoggedIn" @submit.prevent="addComment">
              <label>
                  დაამატე კომენტარი
                  <textarea v-model="newComment" required></textarea>
                  <button type="submit">დამატება</button>
              </label>
          </form>
      </div>
    </div>
    <div class="about hided-on-l">
        <p class="about-header">About the campaign</p>
        <p class="about-content"> {{campaign.details}}
        </p>
        </div>
    <div v-if="hasGallery" class="gallery hided-on-l">
        <p class="gallery-header">გალერეა</p>
        <div class="gallery-content" v-if="gallery">
          <gallery-modal></gallery-modal>
          <div v-for="image in gallery" :style="{'background-image': 'url(' + image.url + ')'}"></div>
        </div>
    </div>
    <div class="comments hided-on-l">
      <p class="comments-header">კომენტარები</p>
        <div class="comment" v-for="comment in campaign.comments" v-bind:key="comment.id">
          <div class="icon"></div>
          <p class="comment-name">{{comment.author_name}}</p>
          <p class="comment-content">{{comment.body}}</p>
        </div>
        <form v-if="isLoggedIn" @submit.prevent="addComment">
            <label>
                დაამატე კომენტარი
                <textarea v-model="newComment" required></textarea>
                <button type="submit">დამატება</button>
            </label>
        </form>
    </div>
    <div class="donate-section">
      <div>
        <span class="donate-share-save">
          <p class="donate-header">
            {{campaign.name}}
          </p>
          <a :href="shareLink" target="_blank">
          <!-- change with svg -->
            <img src="/img/share-2.svg" alt="">
              გაზიარება
          </a>
          <a v-if="isLoggedIn" style="cursor:pointer;" @click="changeFavouriteStatus">
          <!-- change with svg -->
            <img v-if="favourite" src="/img/heart-red.svg" alt="">
            <img v-else src="/img/heart.svg" alt="">
                შეინახე
          </a>
        </span>
        <donation-modal :campaign_id="campaign.id" :is_logged_in="isLoggedIn"/>
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
  import {APP_URL} from "@js/Common/config";

  export default {
    components: {
      DonationModal,
      GalleryModal
    },
    data() {
      return {
        campaign: null,
        gallery: null,
        favourite: false,
        newComment: ""
      };
    },
    beforeRouteEnter(to, from, next) {
      store.dispatch("fetchCampaign", to.params.id)
              .then((campaign) => {
                next(vm => vm.setCampaign(campaign));
              }).catch(() => next());
    },
    beforeMount(){
      this.fetchGallery();
      if(this.isLoggedIn){
        HTTP.GET("/user/favourite-campaigns/"+this.$route.params.id)
                .then(res => {
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
      shareLink(){
        return "https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fpowershare.fund%2Fcampaigns%2F"+this.campaign.id;
      },
      realizedPercentage(){
        return (this.campaign.realized_funding/this.campaign.required_funding )*100;
      },
      hasComments(){
        return this.campaign.comments !== null && this.campaign.comments.length !== 0 && this.isLoggedIn;
      },
      hasGallery(){
          return this.gallery !== null && this.gallery.length !== 0;
      }
    },
    methods:{
      setCampaign(campaign){
        this.campaign = campaign;
      },

      fetchGallery(){
        let galleryFetchUri = "/campaigns/" +this.$route.params.id+"/gallery";
        HTTP.GET(galleryFetchUri)
                .then(data => this.gallery = data.data.data)
                .catch(reason => console.error(reason.response));
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
      },
      addComment(){
          if(!this.isLoggedIn) return;
          HTTP.POST("/campaigns/"+this.campaign.id+"/comments", {"body" :this.newComment})
              .then(data => {
                 console.log(data);
                 this.campaign.comments.push(data.data.data);
              }).catch(err => {
                  console.error(err);
                  console.error(err.response);
                  window.alert("Comment couldn't be added sorry... :(")
          });
      }
    },
    metaInfo(){
      let title = this.campaign ? (this.campaign.name + " | ") : "Campaign | ";
      let description = this.campaign ? (this.campaign.description) : "Campaign Description.";
      let image_url = this.campaign ? (this.campaign.featured_image_url)
              : "https://powershare.fund/img/powershare_logo.svg";
      return {
        title: title,
        meta: [
          {vmid: "og:title", property: "og:title", content: title + "Powershare"},
          {vmid: "og:description", property: "og:description", content: description},
          {vmid: "og:image", property: "og:image", content: image_url},
          {vmid: "og:url", property: "og:url", content: APP_URL + this.$route.fullPath}
        ]
      }
    }
  };
</script>
