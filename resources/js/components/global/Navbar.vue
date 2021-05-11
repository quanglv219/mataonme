<template>
    <nav>
        <v-layout row wrap justify-center class="my-0 white">
            <v-flex xs12 md10 xl10>
                <v-toolbar flat class="navbar">
                    <v-toolbar-title class="mr-2 hidden-md-and-down">
                        <a href="/">
                            <v-img contain :src="logo" class="logo"></v-img>
                        </a>
                    </v-toolbar-title>
                    <v-app-bar-nav-icon class="hidden-lg-and-up" @click="drawer = !drawer" v-if="user"></v-app-bar-nav-icon>
                    <v-spacer></v-spacer>
                    <v-toolbar-items v-if="user" class="hidden-md-and-down">
                        <v-btn-toggle
                            rounded
                            class="mt-2"
                            >
                            <v-btn :href="item.link" v-for="(item, index) in items" :key="index">
                                <v-icon class="mr-2">{{ item.icon }}</v-icon> {{ item.title }}
                            </v-btn>
                            <v-btn href="/upgrade" color="cyan accent-3" class="white--text" v-if="!user.is_subscribed">
                                <v-icon class="white--text mr-2">mdi-crown-outline</v-icon> Upgrade
                            </v-btn>
                        </v-btn-toggle>
                    </v-toolbar-items>
                    <v-spacer></v-spacer>
                    <v-btn href="/register" color="cyan accent-3" large class="ml-2 white--text rounded" elevation="0" v-if="!user">Register</v-btn>
                    <div v-if="user">
                        <v-btn href="/admin" color="black lighten-4 mr-2" elevation="0" class="white--text" large v-if="user && user.is_admin">Go to admin dashboard</v-btn>
                    </div>
                    <v-btn color="red darken-3" large class="ml-2 white--text rounded" elevation="0" v-if="user" @click="logout">
                        <v-icon>mdi-logout</v-icon> Logout
                    </v-btn>
                </v-toolbar>
            </v-flex>
        </v-layout>
        <v-navigation-drawer temporary class="d-lg-none" v-model="drawer" app v-if="user">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="title" style="display: flex; justify-content: center">
                        <a href="/">
                            <v-img contain :src="logo" class="logo-mobile"></v-img>
                        </a>
                    </v-list-item-title>
                    <p class="grey--text text-center mt-5 font-weight-medium">{{ user.name }}</p>
                    <p class="caption text-center">@{{ user.username }}</p>
                    <v-list>
                        <v-list-item-group color="cyan accent-3">
                            <v-list-item :href="item.link" v-for="(item, index) in items" :key="index">
                                <v-list-item-icon><v-icon>{{ item.icon }}</v-icon></v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <!-- Upgrade Button -->
                            <div style="display: flex; justify-content: center" v-if="!user.is_subscribed">
                                <v-btn href="/upgrade" color="cyan accent-3" elevation="0" class="white--text" large block>
                                    <v-icon class="white--text mr-2">mdi-crown-outline</v-icon> Upgrade
                                </v-btn>
                            </div>
                            <!-- / Upgrade Button -->
                        </v-list-item-group>
                    </v-list>
                </v-list-item-content>
            </v-list-item>
        </v-navigation-drawer>
        <div v-if="user">
            <div v-if="!user.email_verified_at && emailSuccess == false">
                <v-progress-linear indeterminate color="cyan accent-3" v-if="loading"></v-progress-linear>
                    <v-alert class="cyan accent-3 rounded-0" v-if="!user.email_verified_at && emailSuccess == false">
                        Your links page will not be visible until you verify your email, 
                        <span class="text-decoration-underline" style="cursor: pointer" @click="sendVerificationEmail">Resend verification link.</span>
                    </v-alert>
            </div>
            <errors :success="emailSuccess" :failure="emailFailure" :message="emailMessage" :square="true"></errors>
        </div>
    </nav>
</template>

<script>
import axios from 'axios'
import Errors from '../partials/Errors.vue'

export default {
  components: { Errors },
    name: "Navbar",
    props: ['user', 'active', 'logo'],
    data() {
        return {
            token: document.head.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            emailSuccess: false,
            emailFailure: false,
            emailMessage: '',
            loading: false,
            drawer: false,
            items: [
                { icon: 'mdi-link-variant', title: 'Links', link: '/links' },
                { icon: 'mdi-circle-edit-outline', title: 'Customization', link: '/customization' },
                { icon: 'mdi-cog', title: 'Settings', link: '/user/settings' },
            ]
        }
    },
    methods: {
        logout() {
            // Get the CSRF token
            this.user.token = this.token
            // Log the user out
            axios.post('/logout', this.user)
            .then(res => {
                console.log('logged out successfully')
                window.location.href = '/'
            })
        },
        sendVerificationEmail() {
            this.loading = true
            axios.post('/email/resend', { _token: this.token })
            .then(res => {
                this.emailSuccess = true
                this.emailFailure = false
                this.emailMessage = "Verification link was sent successfully."
                this.loading = false
            })
            .catch(err => {
                this.emailFailure = true
                this.emailSuccess = false
                this.emailMessage = 'Something went wrong, Please try again later.'
                this.loading = false
            })
        }
    }
}
</script>

<style>
    .logo {
        height: 45px;
        width: 250px;
    }
    .logo-mobile {
        height: 60px;
        width: 200px;
    }
    #form {
        background: white;
        padding: 25px;
        border-radius: 14px;
        border: 2px solid #14756a23;
    }
</style>
