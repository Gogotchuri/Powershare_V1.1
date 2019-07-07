<template>
    <div v-if="!!article" id="container" class="blog-details">
        <h2>{{article.name}}</h2>
        <div class="blog-details-photo" :style="{'background-image': 'url(' + article.image_url + ')'}"></div>
        <div class="blog-details-photo" :style="{'background-image': 'url(' + article.image_url + ')'}"></div>
        <div class="blog-details-photo-under"></div>
        <p class="blog-details-content">
            <span v-html="article.body"></span>
        </p>
        <div class="related-blogs">

        </div>
    </div>
    <div v-else class="blog-details">
        404!
    </div>
</template>

<script>
    import store from "@js/store";

    export default {
        name: "Article",
        data(){
            return{
                article: null
            }
        },
        beforeRouteEnter(to, from, next) {
            store.dispatch("fetchArticle", to.params.id)
                .then((article) => {
                    next(vm => vm.setArticle(article));
                }).catch(() => next());
        },
        methods:{
            setArticle(article){
                this.article = article;
            }
        },
        metaInfo(){
            let name = (this.article && this.article.name)? this.article.name : "";
            return {
                title: name + " | "
            }
        }
    };
</script>
<style scoped>
    /*p{*/
    /*    text-indent: 2em;*/
    /*}*/
</style>