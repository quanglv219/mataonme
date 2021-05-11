<template>
    <v-main class="main">
        <v-layout row wrap justify-center class="mt-15">
            <v-flex xs11 md4 lg6 xl4>
                <div id="form">
                    <p class="cyan--text accent-3 text-center text-md-h4 text-sm-h5 text-h5" style="font-family: 'Rubik'!important">Register now, It's Free!</p>
                    <v-alert type="info" indeterminate border="left" v-if="loading">Processing ...</v-alert>
                    <v-form v-model="valid" ref="form">
                        <errors :success="success" :failure="failure" :message="message"></errors>
                        <v-text-field label="Full Name" :rules="[rules.required]" v-model="name" outlined></v-text-field>
                        <v-text-field label="Email" :rules="[rules.required, rules.email]" v-model="email" outlined></v-text-field>
                        <v-text-field label="Username" :prefix="domain+'/'" :rules="[rules.required, rules.username]" v-model="username" outlined></v-text-field>
                        <v-text-field type="password" label="Password" :rules="[rules.required, rules.min]" v-model="password" outlined></v-text-field>
                        <v-text-field type="password" label="Confirm password" :rules="[rules.required, rules.min, rules.password_confirmation]" v-model="password_confirmation" outlined></v-text-field>
                        <div>
                            <a href="/login" class="text-decoration-none">Already have an account?</a>
                        </div>
                        <v-btn color="cyan accent-3" elevation="0" class="white--text" large @click="validate">Register</v-btn>
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
    props: ['domain'],
    components: { Errors },
    name: "Register",
    data() {
        return {
            rules: {
                required: value => !!value || 'Required',
                password_confirmation: value => this.password == value || 'Passwords must be matched',
                email: value => {
                    const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                    return pattern.test(value) || 'Invalid e-mail.'
                },
                username: value => {
                    const pattern = /^[a-zA-Z0-9]+$/
                    return pattern.test(value) || 'Invalid username, usernames should not contain chars like - , $ '
                },
                min: value => value.length >= 8 || 'The password must be at least 8 characters.'
            },
            valid: false,
            name: '',
            email: '',
            username: '',
            password: '',
            password_confirmation: '',
            success: false,
            failure: false,
            message: '',
            token: document.head.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            loading: false
        }
    },
    methods: {
        validate() {
            this.$refs.form.validate()
            // Check if the form is valid
            this.loading = true
            if (this.valid) {
                // Register the user
                let user = {
                    name: this.name,
                    email: this.email,
                    username: this.username,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                    _token: this.token
                }
                axios.post('/register', user)
                .then(res => {
                    this.loading = false
                    this.success = true
                    this.message = "Successfully registred."
                    this.failure = false
                    setTimeout(() => {
                        window.location.href = '/home'
                    }, 1000)
                })
                .catch(err => {
                    this.loading = false
                    this.failure = true
                    // Show the error message
                    console.log(err.response)
                    this.message = err.response.data.errors['email'] != null ? err.response.data.errors['email'][0] : err.response.data.errors['username'][0]
                    this.success = false
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
