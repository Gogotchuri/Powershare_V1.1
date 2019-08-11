<template>
  <div v-if="!!articles && articles.length > 0" id="blog-container">
<!--    <div class="blog-input">-->
<!--      <input type="text" placeholder="Search.." class="search" v-model="searchKey" @keyup="loadMore(search=true)">-->
<!--    </div>-->
    <div class="blogs">
      <article-thumbnail
        v-for="article in articles"
        :key="article.id"
        :article="article"
      ></article-thumbnail>
    </div>
  </div>
  <div v-else>{{$t("snippets.no-articles")}}</div>
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
