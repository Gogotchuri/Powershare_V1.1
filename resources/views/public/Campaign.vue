<template>
  <div v-if="campaign != null">
    <div class="gallery-mini">
      <div class="static-gallery">    
        <div class="gallerym-overlay">

        </div>
      </div>
    </div>
    <div>
      <div class="about-mini">
        <div class="header">
          <div>
            <p class="header-text">Let's protect our friends</p>
            <p class="header-date">5/16/2016</p>
          </div>
          <p class="header-dleft">30 days left</p>
        </div>
        <div class="owner">
          <div class="owner-icon">
          </div>
          <div class="owner-name">
            <p>Qeti Pagava</p>
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
        <span>150.0$ </br> Funded</span>
        <span>450.0$ </br> needed</span>
      </div>
      <div class="about hided-on-ms">
        <p class="about-header">About the campaign</p>
        <p class="about-content"> We're From Georgia, people who care about homeless dogs. Tianeti is from Tbilisi about 50-60 km and the whole road you're driving in the forest. There is no food or water, no humans, villages or something for dogs. They live there in hunger and cold. Snow is melting in April, and normal temperature is day - +5, night - -10, so they need food for survival. My friend and I are walking twice a week, we bring food and water. This is too expensive for
us, 20kg food is coast 55 Gell (25$) and petrol for a car for one road 15 $. So if you're interested in this case watch our videos and support us in helping the helpless   </p>
      </div>
      <div class="gallery hided-on-ms">
        <p class="gallery-header">Gallery</p>
        <div class="gallery-content">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
      <div class="comments hided-on-ms">
        <p class="comments-header">Comments</p>
        <div class="comment">
          <div class="icon"></div>
          <p class="comment-name">Tekla Obolashvili</p>
          <p class="comment-content">Great campaign, keep it up. I will donate for sure</p>
        </div>
        <div class="comment">
          <div class="icon"></div>
          <p class="comment-name">Tekla Obolashvili</p>
          <p class="comment-content">Great campaign, keep it up. I will donate for sure</p>
        </div>
      </div>
    </div>
    <div class="about hided-on-l">
        <p class="about-header">About the campaign</p>
        <p class="about-content"> We're From Georgia, people who care about homeless dogs. Tianeti is from Tbilisi about 50-60 km and the whole road you're driving in the forest. There is no food or water, no humans, villages or something for dogs. They live there in hunger and cold. Snow is melting in April, and normal temperature is day - +5, night - -10, so they need food for survival. My friend and I are walking twice a week, we bring food and water. This is too expensive for
us, 20kg food is coast 55 Gell (25$) and petrol for a car for one road 15 $. So if you're interested in this case watch our videos and support us in helping the helpless   </p>
    </div>
    <div class="gallery hided-on-l">
        <p class="gallery-header">Gallery</p>
        <div class="gallery-content">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
    </div>
    <div class="comments hided-on-l">
      <p class="comments-header">Comments</p>
      <div class="comment">
        <div class="icon"></div>
        <p class="comment-name">Tekla Obolashvili</p>
        <p class="comment-content">Great campaign, keep it up. I will donate for sure</p>
      </div>
      <div class="comment">
        <div class="icon"></div>
        <p class="comment-name">Tekla Obolashvili</p>
        <p class="comment-content">Great campaign, keep it up. I will donate for sure</p>
      </div>
    </div>
    <!-- <div class="details-main">
      <div class="photo"></div>
      <div class="details-main-right">
        <div class="owner">
          <div class="hidden-subject">Subject</div>
          <div class="owner-name">{{campaign.author_name}}</div>
        </div>
      </div>
    </div>
    <div class="hidden-donate">Donate</div>
    <div class="details-header">
      <span class="subject">{{campaign.name}}</span>
      <span class="social">^^^social icons^^^</span>
    </div>
    <div class="details-secondary">
      <Tabs></Tabs>
    </div>
  </div>
  <div v-else>
    We are fetching Campaign please wait... (Notifying with this ugly message!) -->
  </div>
</template>

<script>
import Tabs from "./partials/Tab";
import store from "@js/store";

export default {
  components: {
    Tabs
  },
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