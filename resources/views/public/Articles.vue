<template>
  <div v-if="!!articles" id="blog-container">
    <div class="blog-first-row">
      <div class="blog"></div>
      <div class="blog"></div>
      <div class="blog"></div>
      <div class="blog"></div>
    </div>
    <div class="blog-entire">
      <div class="blog"></div>
      <div class="blog"></div>
      <div class="blog"></div>
      <div class="blog"></div>
      <div class="blog"></div>
      <div class="blog"></div>
      <div class="blog"></div>
      <div class="blog"></div>
      <div class="blog"></div>
      <div class="blog"></div>
      <div class="blog"></div>
      <div class="blog"></div>
      <div class="blog"></div>
      <div class="blog"></div>
      <div class="blog"></div>
    </div>
  </div>
  <div v-else> No Article to display</div>
</template>


<script>
  import store from "@js/store";
  export default {
    name: "Articles",
    data(){
      return{
        articles: null //tu ginda aq miawere array ([]) statiebis rac ginda da prosta renderistvis gamoiene
        //an zevit martivi for ciklit gadauyevi da ise gaakete thumbnail-ebze rogorc campaignsshia
      }
    },

    beforeRouteEnter(to, from, next) {
      store.dispatch("fetchArticles")
              .then((articles) => {
                next(vm => vm.setArticles(articles));
              }).catch(() => next());
    },

    methods:{
      setArticles(articles){
        this.articles = articles;
      }
    }
  };
</script>
