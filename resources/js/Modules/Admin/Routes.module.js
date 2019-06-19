import Dashboard from "@/views/admin/Dashboard";
import Index from "@views/admin/Index";
import Users from "@/views/admin/Users";
import Campaign from "@/views/admin/campaigns/Campaign";
import FAQQuestions from "@/views/admin/FAQQuestions";
import CreateSurvey from "@views/admin/surveys/CreateSurvey";
import EditSurvey from "@views/admin/surveys/EditSurvey";
import Surveys from "@views/admin/surveys/Surveys";
import CampaignEdit from "@views/shared/campaigns/CampaignEdit";
import Campaigns from "@views/shared/campaigns/Campaigns";
import VideoAds from "@views/admin/videos/VideoAds";
import CreateVideoAd from "@views/admin/videos/CreateVideoAd";

export default [
    {
        path: "/admin",
        component: Index,
        meta: {
            authRequired: true,
            adminRequired: true
        },
        children:[
            {
                path: "",
                name: "Admin.Dash",
                component: Dashboard
            },
            {
                path: "campaigns",
                name: "Admin.Campaigns",
                component: Campaigns
            },
            {
                path: "campaigns/:id",
                name: "Admin.Campaigns.Show",
                component: Campaign
            },
            {
                path: "campaigns/:id/edit",
                name: "Admin.Campaigns.Edit",
                component: CampaignEdit
            },
            {
                path: "users",
                name: "Admin.Users",
                component: Users
            },
            {
                path: "FAQ",
                name: "Admin.FAQ",
                component: FAQQuestions
            },
            {
              path: "surveys",
              name: "Admin.Surveys",
              component: Surveys
            },
            {
                path: "surveys/create",
                name: "Admin.Surveys.Create",
                component: CreateSurvey
            },
            {
                path: "surveys/:id",
                name: "Admin.Surveys.Edit",
                component: EditSurvey
            },
            {
                path: "video-ads",
                name: "Admin.VideoAds",
                component: VideoAds
            },
            {
                path: "video-ads/create",
                name: "Admin.VideoAds.Create",
                component: CreateVideoAd
            },
            {
                path: "video-ads/:id",
                name: "Admin.VideoAds.Edit",
                component: CreateVideoAd
            }
        ]
    }
];