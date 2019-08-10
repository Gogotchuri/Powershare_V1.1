<template>
    <div class="blogThumbnail">
        <router-link class ="explore-card" :to="`/articles/${article.id}`">
            <!-- campaignis surati unda styleshi -->
            <div class="blogThBackground" :style="{'background-image': 'url(' + article.image_url + ')'}">
            </div>
            <div class="blogThText">
                <div class="explore-card-text">
                        <div class="blog-holder-left">
                            {{article.name}}
                        </div>
                        <div class="blog-important">
                            <h6>{{$t("words.date")}}:<span style="font-weight:200"> {{article.date}}</span></h6>
                        </div>
                        <div class="campaign-desc" v-html="article.body.substring(0,100)+'...'">
                        </div>
                </div>
            </div>
		</router-link>
    </div>
</template>

<script>
export default {
    name: "ArticleThumbnail",
    props: ["article"],
    // filters: {
    //     subStr: function(string) {
    //         return string.substring(0,70) + '...';
    //     }
    // },
    metaInfo(){
        return {
            title: "Blog | "
        }
    }
}
</script>
