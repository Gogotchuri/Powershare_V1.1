<template>
  <div v-if="false" id="blog-container">
    <div class="blog-input">
      <input type="text" placeholder="Search.." class="search" v-model="searchKey" @keyup="loadMore(search=true)">
    </div>
    <div class="blogs">
      <article-thumbnail
        v-for="blog in Articles"
        :key="blog.id"
        :blog="blog"
      ></article-thumbnail>
    </div>
  </div>
  <div v-else> No Article to display</div>
</template>


<script>
  import store from "@js/store";
  import ArticleThumbnail from "@views/public/partials/ArticleThumbnail";
  export default {
    name: "Articles",
    components: {ArticleThumbnail},
    data(){
      return{
        articles: []
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
