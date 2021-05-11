<template>
    <v-main class="main">
        <v-layout row wrap justify-center class="mt-15">
            <v-flex xs11 md4 lg6 xl4>
                <div id="form">
                    <p class="cyan--text accent-3 text-center text-md-h4 text-sm-h5 text-h5" style="font-family: 'Rubik'!important">Welcome back!</p>
                    <v-form v-model="valid" ref="form">
                        <errors :success="success" :failure="failure" :message="message"></errors>
                        <v-text-field label="Email" :rules="[rules.required, rules.email]" v-model="email" outlined></v-text-field>
                        <v-text-field type="password" label="Password" :rules="[rules.required]" v-model="password" outlined></v-text-field>
                        <v-switch label="Remember me" color="cyan darken-3" class="mt-0" v-model="rememberMe"></v-switch>
                        <v-btn color="cyan accent-3" elevation="0" class="white--text" large @click="validate">Login</v-btn>
                        <div class="mt-3">
                            <a href="/register" class="text-decoration-none">Don't have an account?</a>
                        </div>
                        <div>
                            <a href="/password/reset" class="text-decoration-none">Reset password</a>
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
  components: { Errors },
    name: "Login",
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
            email: '',
            password: '',
            rememberMe: false,
            token: document.head.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            success: false,
            failure: false,
            message: ''
        }
    },
    methods: {
        validate() {
            // Validate the form
            this.$refs.form.validate()
            let user = {
                email: this.email,
                password: this.password,
                remember: this.rememberMe,
                _token: this.token
            }
            // Check the validation and continue
            if (this.valid) {
                // Reset the errors to their initial status on every attempt to login
                this.failure = false
                this.success = false
                this.message = ''
                axios.post('/login', user)
                .then(res => {
                    window.location.href = '/home'
                })
                .catch(err => {
                    // Show the error
                    this.failure = true
                    this.success = false
                    this.message = err.response.data.errors.email[0]
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
