<?php
/**
 * This route contains api route constants used in api tests
 * User: gogotchuri
 * Date: 3/25/19
 * Time: 3:54 PM
 */

namespace Tests\Feature\APITests;


class APIRoutes
{

    //auth routes
    public const LOGIN ="/api/login";
    public const REGISTER ="/api/register";
    public const LOGOUT ="/api/logout";

    //public routes
    public const PUBLIC_HOME ="/api/home";
    public const PUBLIC_CAMPAIGNS ="/api/campaigns";
    public const PUBLIC_ARTICLES ="/api/articles";
    public const PUBLIC_FAQ ="/api/faq";
    public const PUBLIC_ABOUT ="/api/about";
    public const PUBLIC_CONTACT ="/api/contacts";
    public const PUBLIC_TERMS ="/api/terms";
    public const PUBLIC_PRIVACY_POLICY ="/api/privacy-policy";

    //user routes
    public const USER_CAMPAIGNS ="/api/user/campaigns";
    public const USER_ALL_COMMENTS ="/api/user/comments";
    public const USER_CAMPAIGN_COMMENTS = "/api/campaigns/%d/";


}