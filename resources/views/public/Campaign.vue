<template>
  <div v-if="campaign != null">
    <div class="gallery-mini">
      <div class="static-gallery">
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
          <p class="header-dleft">30 days left</p>
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
              <a href="#">
                <!-- change with svg -->
                <img src="/img/heart.svg" alt="">
                Save
              </a>
            </span>
          </div>
        </div>
        <div class="story-mini">
          Millions of animals need our help: shelters, food, proper health care. Get on board, let's help them
        </div>
      </div>
      <div class="completion">
        <p class="completion-donators">23500 free donators</p>
        <div class="fillable-bar">
          <div class="filled-bar"></div>
        </div>
        <span>{{campaign.realized_funding}}$<br> Funded</span>
        <span>{{campaign.required_funding}}$<br> needed</span>
      </div>
      <div class="about hided-on-ms">
        <p class="about-header">About the campaign</p>
        <p class="about-content"> {{campaign.details}}</p>
      </div>
      <div class="gallery hided-on-ms">
        <p class="gallery-header">Gallery</p>
        <div class="gallery-content">
          <div style="background-image: url(https://images.unsplash.com/photo-1444212477490-ca407925329e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1400&q=80);"></div>
          <div style="background-image: url(https://images.unsplash.com/photo-1518717758536-85ae29035b6d?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60);"></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
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
        <div class="gallery-content">
          <div style="background-image: url(https://images.unsplash.com/photo-1444212477490-ca407925329e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1400&q=80)"></div>
          <div style="background-image: url(https://images.unsplash.com/photo-1518717758536-85ae29035b6d?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60)"></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
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
    <div class="donate-section">
      <div>
        <span class="donate-share-save">
          <p class="donate-header">
            {{campaign.name}}
          </p>
          <a href="#">
          <!-- change with svg -->
            <img src="/img/share-2.svg" alt="">
                  Share
          </a>
          <a href="#">
          <!-- change with svg -->
            <img src="/img/heart.svg" alt="">
                Save
          </a>
        </span>
        <router-link :to="{name: 'User.Survey', query: {campaign_id : campaign.id}}" class="donate-button">
          Donate for free
        </router-link>
      </div>
    </div>
    <div class="donate-underspace">
    </div>
  </div>
</template>

<script>
  import store from "@js/store";

  export default {
    data() {
      return {
        campaign: null
      };
    },
    beforeRouteEnter(to, from, next) {
      store.dispatch("fetchCampaign", to.params.id)
              .then((campaign) => {
                console.log(campaign);
                next(vm => vm.setCampaign(campaign));
              }).catch(() => next());
    },
    computed: {
      id() {
        return this.$route.params.id;
      }
    },
    methods:{
      setCampaign(campaign){
        this.campaign = campaign;
      }
    }
  };
</script>
