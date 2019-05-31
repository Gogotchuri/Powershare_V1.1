<template>
    <div v-if="!!article" id="container">
        This is a blog page!
    </div>
    <div v-else>
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
        }
    };
</script>
