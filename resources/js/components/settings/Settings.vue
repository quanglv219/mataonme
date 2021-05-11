<template>
  <div>
    <v-layout row wrap justify-center class="py-10 px-5">
        <v-flex xs12 sm12 md3 lg3 xl3 class="px-8 mb-6">
            <v-list class="py-0" shaped style="background: #f4f4f4f4">
                <v-list-item-group v-model="selectedItem" color="cyan accent-3">
                    <v-list-item :href="item.href" v-for="(item, i) in items" :key="i">
                        <v-list-item-icon>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>{{ item.text }}</v-list-item-title>
                    </v-list-item>
                    <v-list-item href="#cancel" v-if="isSubscribed == true">
                        <v-list-item-icon>
                            <v-icon>mdi-cancel</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Cancel subscription</v-list-item-title>
                    </v-list-item>
                </v-list-item-group>
            </v-list>
        </v-flex>
        <v-flex xs12 sm12 md6 lg6 xl6 class="px-5">
            <v-layout row wrap>
                <v-flex xs12 sm12 md12 lg12 xl12 class="px-5">
                    <v-alert type="info" color="cyan accent-3" class="py-0 pt-3">
                        <p>You are currently on the 
                            <span class="font-weight-medium" v-if="isSubscribed == true">Premium</span> 
                            <span class="font-weight-medium" v-else>Free</span> plan.
                        </p>
                    </v-alert>
                    <v-card class="rounded pa-3" flat id="settings">
                        <v-card-title class="grey--text text--accent-3">Settings</v-card-title>
                        <v-card-text>
                            <v-form ref="settings" v-model="validSettings">
                                <errors :success="success" :failure="failure" :message="message"></errors>
                                <v-text-field label="Name" v-model="name" color="cyan accent-3" :rules="[rules.required]" outlined flat></v-text-field>
                                <v-text-field label="Username" v-model="username" color="cyan accent-3" :rules="[rules.required, rules.username]" outlined flat></v-text-field>
                                <v-text-field label="Email" v-model="email" color="cyan accent-3" :rules="[rules.required, rules.email]" outlined flat></v-text-field>
                                <v-text-field label="Bio" v-model="description" color="cyan accent-3" outlined flat></v-text-field>
                                <div style="justify-content: flex-end; display: flex">
                                    <v-btn class="white--text" color="cyan accent-3" large @click="validateSettings" elevation="0">Save</v-btn>
                                </div>
                            </v-form>
                        </v-card-text>
                    </v-card>
                </v-flex>
                
                <v-flex xs12 sm12 md12 lg12 xl12 class="px-5 mt-10">
                    <v-card class="rounded pa-3" flat id="social-media-links">
                        <v-card-title class="grey--text text--accent-3">Social media links</v-card-title>
                        <v-card-text>
                            <v-form ref="SocialMediaLinks" v-model="validSocialMediaLinks">
                                <errors :success="successSocial" :failure="failureSocial" :message="messageSocial"></errors>
                                <v-text-field prefix="https://facebook.com/" label="Facebook page URL" v-model="facebook" color="cyan accent-3" outlined flat></v-text-field>
                                <v-text-field prefix="https://twitter.com/" label="Twitter username" v-model="twitter" color="cyan accent-3" outlined flat></v-text-field>
                                <v-text-field prefix="https://instagram.com/" label="Instagram username" v-model="instagram" color="cyan accent-3" outlined flat></v-text-field>
                                <v-text-field prefix="https://youtube.com/" label="Youtube URL" v-model="youtube" color="cyan accent-3" outlined flat></v-text-field>
                                <v-text-field prefix="https://linkedin.com/" label="Linkedin URL" v-model="linkedin" color="cyan accent-3" outlined flat></v-text-field>
                                <v-text-field prefix="https://twitch.com/" label="Twitch URL" v-model="twitch" color="cyan accent-3" outlined flat></v-text-field>
                                <v-text-field prefix="https://t.me/" label="Telegram URL" v-model="telegram" color="cyan accent-3" outlined flat></v-text-field>
                                <div style="justify-content: flex-end; display: flex">
                                    <v-btn class="white--text" color="cyan accent-3" large @click="validateSocialMediaLinks" elevation="0">Save</v-btn>
                                </div>
                            </v-form>
                        </v-card-text>
                    </v-card>
                </v-flex>
                
                <v-flex xs12 sm12 md12 lg12 xl12 class="px-5 mt-10">
                    <v-card class="rounded pa-3" flat id="change-password">
                        <v-card-title class="grey--text text--accent-3">Change Password</v-card-title>
                        <v-card-text>
                            <v-form ref="changePassword" v-model="changePasswordValid">
                                <errors :success="successChangePassword" :failure="failureChangePassword" :message="messageChangePassword"></errors>
                                <v-text-field label="Old password" type="password" v-model="oldPassword" color="cyan accent-3" :rules="[rules.required]" outlined flat></v-text-field>
                                <v-text-field label="New password" type="password" v-model="newPassword" color="cyan accent-3" :rules="[rules.required, rules.password_should_not_match]" outlined flat></v-text-field>
                                <v-text-field label="New password confirmation" type="password" v-model="newPassword_confirmation" color="cyan accent-3" :rules="[rules.required, rules.password_confirmation]" outlined flat></v-text-field>
                                <div style="justify-content: flex-end; display: flex">
                                    <v-btn class="white--text" color="cyan accent-3" large @click="changePassword" elevation="0">Save</v-btn>
                                </div>
                            </v-form>
                        </v-card-text>
                    </v-card>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12 xl12 class="px-5 mt-10" v-if="isSubscribed == true">
                    <v-card class="rounded pa-3" flat id="cancel" style="border: 2px dashed red!important">
                        <v-card-title class="grey--text text--accent-3">Cancel subscription</v-card-title>
                        <v-card-text>
                            <errors :success="cancelSuccess" :failure="cancelFailure" :message="cancelMessage"></errors>
                            <p v-if="subscription.ends_at != null">Your subscription will end at {{ new Date(subscription.ends_at).toString() }}</p>
                            <v-btn v-if="subscription.ends_at == null" color="red accent-3" class="white--text" @click="cancel" elevation="0">Cancel my subscription</v-btn>
                        </v-card-text>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-flex>
    </v-layout>
  </div>
</template>

<script>
import axios from 'axios'
import Errors from '../partials/Errors.vue'

export default {
    name: "Settings",
    components: { Errors },
    props: ['user', 'current'],
    data () {
        return {
            selectedItem: 0,
            items: [
                { text: 'My settings', icon: 'mdi-cog', href: '#settings' },
                { text: 'Social media links', icon: 'mdi-web', href: '#social-media-links' },
                { text: 'Change Password', icon: 'mdi-key', href: '#change-password' },
            ],
            rules: {
                required: value => !!value || 'Required',
                password_confirmation: value => this.newPassword == value || 'Passwords must be matched',
                email: value => {
                    const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                    return pattern.test(value) || 'Invalid e-mail.'
                },
                username: value => {
                    const pattern = /^[a-zA-Z0-9]+$/
                    return pattern.test(value) || 'Invalid username, usernames should not contain chars like - , $ '
                },
                password_should_not_match: value => value != this.oldPassword || 'Old password and new password should not match.'
            },
            // First From
            name: JSON.parse(this.user).name,
            username: JSON.parse(this.user).username,
            email: JSON.parse(this.user).email,
            description: JSON.parse(this.user).description,
            validSettings: false,
            success: false,
            failure: false,
            message: '',
            // Second Form
            validSocialMediaLinks: false,
            facebook: JSON.parse(this.user).social.facebook,
            twitter: JSON.parse(this.user).social.twitter,
            instagram: JSON.parse(this.user).social.instagram,
            youtube: JSON.parse(this.user).social.youtube,
            linkedin: JSON.parse(this.user).social.linkedin,
            twitch: JSON.parse(this.user).social.twitch,
            telegram: JSON.parse(this.user).social.telegram,
            successSocial: false,
            failureSocial: false,
            messageSocial: false,
            // Third Form
            changePasswordValid: false,
            successChangePassword: false,
            failureChangePassword: false,
            messageChangePassword: false,
            oldPassword: '',
            newPassword: '',
            newPassword_confirmation: '',
            // Fourth Form
            cancelSuccess: false,
            cancelFailure: false,
            cancelMessage: "",
        }
    },
    computed: {
        isSubscribed() {
            return JSON.parse(this.user).is_subscribed
        },
        subscription() {
            return JSON.parse(this.current)
        }
    },
    methods: {
        validateSettings() {
            this.success = false
            this.failure = false
            this.message = ''
            if (this.validSettings) {
                // Define the user object
                let user = {
                    name: this.name,
                    email: this.email,
                    username: this.username,
                    description: this.description
                }
                // Send the request
                axios.post('/user/settings', user)
                .then(res => {
                    // Show the success alert message
                    this.success = true
                    this.failure = false
                    this.message = "Information updated successfully."
                })
                .catch(err => {
                    // Show the failure alert message
                    this.failure = true
                    this.success = false
                    this.message = "Something went wrong"
                })
            }
        },
        validateSocialMediaLinks() {
            this.$refs.SocialMediaLinks.validate()
            if (this.validSocialMediaLinks) {
                this.successSocial = false
                this.failureSocial = false
                this.messageSocial = false
                // Define the links object
                let links = {
                    facebook: this.facebook,
                    twitter: this.twitter,
                    instagram: this.instagram,
                    youtube: this.youtube,
                    linkedin: this.linkedin,
                    twitch: this.twitch,
                    telegram: this.telegram,
                }
                // Send the request
                axios.put('/user/social', links)
                .then(res => {
                    this.successSocial = true
                    this.failureSocial = false
                    this.messageSocial = "Social media links updated successfully."
                })
                .catch(err => {
                    this.failureSocial = true
                    this.successSocial = false
                    this.messageSocial = "Something went wrong."
                })
            }
        },
        changePassword() {
            // Reset the alert to their initial values
            this.successChangePassword = false
            this.failureChangePassword = false
            this.messageChangePassword = ""
            // Validate the form
            this.$refs.changePassword.validate()
            // Send the request
            if (this.changePasswordValid) {
                axios.put('/password/change', { oldPassword: this.oldPassword, newPassword: this.newPassword })
                .then(res => {
                    this.successChangePassword = true
                    this.failureChangePassword = false
                    this.messageChangePassword = "Password changed successfully."
                    this.$refs.changePassword.reset()
                })
                .catch(err => {
                    this.failureChangePassword = true
                    this.successChangePassword = false
                    this.messageChangePassword = 'Your old password is not correct.'
                })
            }
        },
        cancel() {
            if (confirm('Are you sure that you want to cancel your subscription?')) {
                axios.post('/user/subscription/cancel')
                .then(res => {
                    this.cancelSuccess = true
                    this.cancelFailure = false
                    this.cancelMessage = "Your subscription was cancelled successfully."
                })
                .catch(err => {
                    this.cancelFailure = true
                    this.cancelSuccess = false
                    this.cancelMessage = "Something went wrong, please try again later."
                })
            }
        }
    }
}
</script>

<style>
    html {
        scroll-behavior: smooth;
    }
    .v-card {
        border-radius: 14px !important;
        border: 2px solid #14756a23 !important;
    }
</style>
