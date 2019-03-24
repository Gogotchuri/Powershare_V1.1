<template>
    <div>
      <!-- Nav-Bar -->
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <router-link :to="{name: 'Home'}" class="navbar-brand">Powershare</router-link>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto"></ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <router-link :to="{ name: 'Campaigns' }" class="nav-link" v-bind:style="{color: colour}">Campaigns</router-link>
                        <router-link :to="{ name: 'Articles' }" class="nav-link">Articles</router-link>
                        <router-link :to="{ name: 'Login' }" class="nav-link" v-if="!isLoggedIn">Login</router-link>
                        <router-link :to="{ name: 'Register' }" class="nav-link" v-if="!isLoggedIn">Register</router-link>
                        <router-link :to="{ name: 'Profile' }" class="nav-link" v-if="currentUser">Profile of {{currentUser.name}}</router-link>                        
                        <a href="#" @click.prevent="logout" class="nav-link" v-if="isLoggedIn">LogOut</a>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Content -->
        <main class="py-4">
            <button @click="changeColour">Change Color</button>
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
    import {logout} from "../js/helpers/auth";
    import ApiService from "../js/common/ApiService";
    
    export default {
        data(){
            return {
                colour:"red"
            };
        },
        computed: {
            isLoggedIn(){
                return this.$store.getters.isAuthenticated;
            },
            currentUser(){
                return this.$store.getters.currentUser;
            }   
        },
        methods: {
            logout(){
                logout()
                .then(response => {
                    alert(response.data);
                    this.$store.dispatch("logout");
                    this.$router.push({name: 'Login'});
                })
                .catch(err => {
                    console.error(err);
                });
            },
            changeColour(){
                if(this.colour === "red")
                    this.colour = "yellow";
                else
                    this.colour = "red";
            }
        }

    }
</script>
