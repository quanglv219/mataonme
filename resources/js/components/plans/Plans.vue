<template>
  <div class="py-10">
    <p class="text-center pb-10 text-h4 font-weight-medium">Upgrade to <span class="cyan--text accent-3">PRO</span> and enjoy more features!</p>
    <v-layout row wrap justify-center>
        <v-flex xs10 sm10 md10 lg3 xl3 class="px-5 mt-3">
            <v-card elevation="0">
                <v-card-title class="text-h4 font">Free</v-card-title>
                <v-divider></v-divider>
                <v-alert v-if="!user.is_subscribed" type="info" style="border-radius: 0; background: #00bcd4 !important">Current plan</v-alert>
                <p class="text-center text-h3 font-weight-medium mt-4 mb-0 cyan--text accent-3">RM 0.00</p>
                <v-card-text>
                    <p class="text-h6 dark-gray">
                        <v-icon class="cyan--text accent-3">mdi-check</v-icon> Unlimited links
                    </p>
                    <p class="text-h6 dark-gray">
                        <v-icon class="cyan--text accent-3">mdi-check</v-icon> Social media icons
                    </p>
                    <p class="text-h6 dark-gray">
                        <v-icon class="cyan--text accent-3">mdi-check</v-icon> Profile image & Bio text
                    </p>
                    <p class="text-h6 dark-gray">
                        <v-icon class="cyan--text accent-3">mdi-check</v-icon> Analytics
                    </p>
                </v-card-text>
            </v-card>
        </v-flex>
        <v-flex xs10 sm10 md10 lg3 xl3 class="px-5 mt-3">
            <v-card elevation="0">
                <v-card-title class="text-h4 font">Premium </v-card-title>
                <v-divider></v-divider>
                <v-alert v-if="user.is_subscribed" type="info" style="border-radius: 0">Current plan</v-alert>
                <p class="text-center text-h3 font-weight-medium mt-4 mb-0 cyan--text accent-3">RM 18</p>
                <v-card-text class="mb-0 pb-0">
                    <p class="text-h6 dark-gray">
                        <v-icon class="cyan--text accent-3">mdi-check</v-icon> Unlimited links
                    </p>
                    <p class="text-h6 dark-gray">
                        <v-icon class="cyan--text accent-3">mdi-check</v-icon> Social media icons
                    </p>
                    <p class="text-h6 dark-gray">
                        <v-icon class="cyan--text accent-3">mdi-check</v-icon> Profile image & Bio text
                    </p>
                    <p class="text-h6 dark-gray">
                        <v-icon class="cyan--text accent-3">mdi-check</v-icon> Colors & Image Background
                    </p>
                    <p class="text-h6 dark-gray">
                        <v-icon class="cyan--text accent-3">mdi-check</v-icon> Buttons Customization
                    </p>
                    <p class="text-h6 dark-gray">
                        <v-icon class="cyan--text accent-3">mdi-check</v-icon> Icons Customization
                    </p>
                    <p class="text-h6 dark-gray">
                        <v-icon class="cyan--text accent-3">mdi-check</v-icon> Analytics
                    </p>
                    <p class="text-h6 dark-gray">
                        <v-icon class="cyan--text accent-3">mdi-check</v-icon> No Logo
                    </p>
                </v-card-text>
                <v-card-actions>
                    <v-btn href="/plans/premium" class="cyan accent-3 white--text" large elevation="0" block :disabled="user.is_subscribed">Go Pro</v-btn>
                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
  </div>
</template>

<script>
export default {
    props: ['user']
}
</script>

<style>

</style>