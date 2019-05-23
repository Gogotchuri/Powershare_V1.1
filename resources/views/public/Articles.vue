<template>
  <div v-if="!!articles" id="blog-container">
    <div class="blog-first-row">
      <div class="blog">
        <!-- for loopi unda iyos mxolod 4 unda daweros -->
        <BlogThumbnail
          v-for="blog in Articles"
          :key="blog.id"
          :blog="blog"
        />
      </div>
    </div>
    <div class="blog-entire">
      <div class="blog">
        <blogThumbnail
          v-for="blog in Articles"
          :key="blog.id"
          :blog="blog"
        />
      </div>
    </div>
  </div>
  <div v-else> No Article to display</div>
</template>


<script>
  import BlogThumbnail from "@views/public/partials/BlogThumbnail.vue";
  import store from "@js/store";
  export default {
    name: "Articles",
    computed: {
      BlogThumbnail
    },
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
