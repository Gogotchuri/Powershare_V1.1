<template>
    <div>
        <h2>create campaign</h2>
        <form action="" method="post">
            <div>
                <label for = "campaign-name">Name</label>
                <input id = "campaign-name"
                       type = "text" 
                       name = "campaign-name"
                       placeholder = "Campaign Name(max.30 characters)"
                       maxlength = "30"
                       required = "1"
                />
            </div>
            <div>
                <label for = "campaign-category">Category</label>
                <input id = "campaign-category"
                       type = "text"
                       name = "campaign-category"
                       placeholder = "Campaign category"
                       required = "1"
                />
            </div>
            <div>
                <label for="short-description">Short description (max. 3000 char)</label>
                <textarea id="short-description"
                          name="short-description" 
                          maxlength="3000"
                          rows="5"
                          required="1">
                </textarea>
            </div>
            <button type="submit">Continue</button>
        </form>
    </div>
</template>

<script>
    export default {
        name: "CampaignCreate"
    }
</script>

<style scoped>
    form{
        width: 100%;
    }
    form > div{
        width: 100%;
    }
    form > div > input{
        width: 70%;
    }
</style>
