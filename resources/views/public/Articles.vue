<template>
  <div v-if="false" id="blog-container">
    <div class="blog-first-row">
      <div class="blog">
        <!-- for loopi unda iyos mxolod 4 unda daweros -->
        <blog-thumbnail
          v-for="blog in Articles"
          :key="blog.id"
          :blog="blog"
        ></blog-thumbnail>
      </div>
    </div>
    <div class="blog-entire">
      <div class="blog">
        <blog-thumbnail
          v-for="blog in Articles"
          :key="blog.id"
          :blog="blog"
        ></blog-thumbnail>
      </div>
    </div>
  </div>
  <div v-else> No Article to display</div>
</template>


<script>
  import store from "@js/store";
  import BlogThumbnail from "@views/public/partials/BlogThumbnail";
  export default {
    name: "Articles",
    components: {BlogThumbnail},
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
