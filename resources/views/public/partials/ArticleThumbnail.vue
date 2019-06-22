<template>
    <div class="blogThumbnail">
        <router-link class ="explore-card" :to="`/articles/${article.id}`">
            <!-- campaignis surati unda styleshi -->
            <div class="blogThBackground" :style="{'background-image': 'url(' + article.featured_image_url + ')'}">
            </div>
            <div class="blogThText">
                <div class="explore-card-text">
                        <div class="blog-holder-left">
                            {{article.name}}
                        </div>
                        <div class="blog-important">
                            <h6>Category:<span style="font-weight:200"> {{article.category_name}}</span></h6>
                        </div>
                        <div class="campaign-desc">
                            {{article.description | subStr}}
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
    filters: {
  	subStr: function(string) {
    	return string.substring(0,70) + '...';
    }
    }
}
</script>
