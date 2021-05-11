<template>
    <v-main class="main">
        <v-layout row wrap justify-center class="mt-15">
            <v-flex xs11 md4 lg6 xl4>
                <div id="form">
                    <p class="teal--text text--darken-3 text-center text-md-h4 text-sm-h5 text-h5" style="font-family: 'Rubik'!important">Reset your password</p>
                    <v-form v-model="valid" ref="form">
                        <v-alert border="left" type="info" v-if="loading">Please wait...</v-alert>
                        <errors :success="success" :failure="failure" :message="message"></errors>
                        <v-text-field label="Email" :rules="[rules.required, rules.email]" v-model="email" outlined></v-text-field>
                        <v-text-field type="password" label="Password" :rules="[rules.required]" v-model="password" outlined></v-text-field>
                        <v-text-field type="password" label="Confirm Password" :rules="[rules.required, rules.password_confirmation]" v-model="password_confirmation" outlined></v-text-field>
                        <v-btn color="teal darken-3" elevation="0" class="white--text" large @click="validate">Change Password</v-btn>
                        <div class="mt-3">
                            <a href="/register" class="text-decoration-none">Register</a>
                        </div>
                        <div>
                            <a href="/login" class="text-decoration-none">Login</a>
                        </div>
                    </v-form>
                </div>
            </v-flex>
        </v-layout>
    </v-main>
</template>

<script>
import axios from 'axios'
import Errors from '../partials/Errors.vue'

export default {
    name: "PasswordReset",
    props: ['token'],
    components: { Errors }, 
    data() {
        return {
            rules: {
                required: value => !!value || 'Required',
                password_confirmation: value => this.password == value || 'Passwords must be matched',
                email: value => {
                    const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                    return pattern.test(value) || 'Invalid e-mail.'
                }
            },
            valid: false,
            email: new URLSearchParams(window.location.search).get('email'),
            password: '',
            password_confirmation: '',
            success: false,
            failure: false,
            message: false,
            loading: false
        }
    },
    methods: {
        validate() {
            this.$refs.form.validate()
            this.success = false
            this.failure = false
            this.message = ''
            this.loading = true
            if (this.valid) {
                axios.post('/password/reset', { 
                    email: this.email, 
                    password: this.password, 
                    password_confirmation: this.password_confirmation, 
                    token: this.token 
                })
                .then(res => {
                    console.log(res)
                    this.success = true
                    this.failure = false
                    this.message = res.data.message
                    // Hide the loading alert
                    this.loading = false
                    // Redirect the user to the homepage
                    window.location.href = '/home'
                })
                .catch(err => {
                    console.log(err.response)
                    this.failure = true
                    this.success = false
                    this.message = err.response.data.errors.email[0]
                    // Hide the loading alert
                    this.loading = false
                })
            }
        }
    }
}
</script>

<style scoped>
    .main {
        background-image: url(https://images.unsplash.com/photo-1485627941502-d2e6429a8af0?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1350&q=80);
        background-size: cover;
    }
</style>
