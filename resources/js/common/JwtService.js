
//Takes care of token manipulations
const TOKEN_KEY = "powershare_token";

const JwtService = 
{
    getToken() {
        return window.localStorage.getItem(TOKEN_KEY);
    },

    saveToken(token) {
        window.localStorage.setItem(TOKEN_KEY, token);
    },

    destroyToken() {
        window.localStorage.removeItem(TOKEN_KEY);
    }
};

export default JwtService;