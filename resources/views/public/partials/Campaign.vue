<template>
    <div class="col-xs-12 col-sm-6 col-md-4 campaign-holder">
		<!-- <a class ="explore-card" href="{{Request::url()."/".((string) $campaign->id)}}">
            <div class="photo" style="background-image: url({{$campaign->featured_image_thumbnail_url}})"></div>
                <div class="row explore-card-text">
                    <div class="col-sm-12 campaign-holder-left">
                        {{$campaign->name}}
                    </div>
                    <div class="col-sm-12 campaigns-important">
                        <h6>Important For:<span style="font-weight:200"> {{$campaign->target_audience}}</span></h6>
                    </div>
                    <div class="col-sm-12 campaign-holder-right">
                        <span class="funded" style="float:left">Funded {{number_format($campaign->realized_funding)."$"}}
                        </span>
                        <span class="goal" style="float:right">Goal {{number_format($campaign->required_funding)."$"}}
                        </span>
                    </div>
                    <div class="col-sm-12 fillable-bar">
                        <div class="filled-bar" style="width: {{
                            ($campaign->required_funding == 0)? 0
                                :((int) $campaign->realized_funding)*100/$campaign->required_funding}}%">
                        </div>
                </div>
            </div>
            
        </a> -->
	</div>
</template>
<script>
export default {
    name: "campaign",
    props: ["campaign"],
}
</script>
