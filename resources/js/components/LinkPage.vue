<template>
    <div class="py-15">
        <v-layout row wrap justify-center>
            <v-flex xs10 sm10 md10 lg4 xl4>
                <!-- Profile image -->
                <div style="display: flex; justify-content: center">
                    <v-avatar
                        color="lighten-2"
                        size="150"
                    >
                        <v-img
                            class="user-profile"
                            loading="lazy"
                            :lazy-src="user.photo || 'https://appvital.com/images/profile/file-uploader-api-profile-avatar-2.jpg'"
                            :src="user.photo || 'https://appvital.com/images/profile/file-uploader-api-profile-avatar-2.jpg'"
                            :alt="'@'+user.username+' on Linktree'"
                        ></v-img>
                    </v-avatar>
                </div>
                <!-- / Profile image -->
                <!-- Username -->
                <div style="display: flex; justify-content: center">
                    <a :href="user.username" class="text-center text-decoration-none black--text font-weight-bold mt-2 text-h6">{{ '@'+user.username }}</a>
                </div>
                <p class="text-center caption mt-2" style="font-size: 15px!important">{{ user.description }}</p>
                <!-- / Username -->
                <div v-if="user.links.length == 0">
                    <p class="text-center">This user has no links yet.</p>
                </div>
                <!-- Links --> 
                <div>
                    <v-btn 
                    @mousemove="onMouseOver(link.id)"
                    @mouseout="onMouseOut(link.id)"
                    ref="button"
                    v-for="(link, index) in links" 
                    :id="link.id"
                    :key="index"
                    @click="analytic(link)"
                    block 
                    class="main-btn my-3 py-8" 
                    elevation="0" 
                    large
                    :style="`
                        font-size: ${user.customization.fontSize}px;
                        font-weight: ${user.customization.fontWeight};
                        background: ${user.customization.buttonBackground};
                        border: ${user.customization.buttonBorderSize}px solid ${user.customization.buttonBorder};
                        color: ${user.customization.fontColor};
                        border-radius: ${user.customization.borderRadius}px;
                    `"
                    >
                        {{ link.name }}
                    </v-btn>
                </div>
                <!-- / Links --> 
                <!-- Social media links -->
                <div v-if="social" :style="`display: flex; justify-content: center; margin-top: 40px; margin-bottom: 15px;`">
                    <v-icon @click="goToSm('facebook')" :style="`color: ${user.customization.iconColor}!important`" class="outlined mx-2 text-h4" v-if="social.facebook">
                        mdi-facebook
                    </v-icon>
                    <v-icon @click="goToSm('twitter')" :style="`color: ${user.customization.iconColor}!important`" class="mx-2 text-h4" v-if="social.twitter">
                        mdi-twitter
                    </v-icon>
                    <v-icon @click="goToSm('youtube')" :style="`color: ${user.customization.iconColor}!important`" class="mx-2 text-h4" v-if="social.youtube">
                        mdi-youtube
                    </v-icon>
                    <v-icon @click="goToSm('instagram')" :style="`color: ${user.customization.iconColor}!important`" class="mx-2 text-h4" v-if="social.instagram">
                        mdi-instagram
                    </v-icon>
                    <v-icon @click="goToSm('telegram')" :style="`color: ${user.customization.iconColor}!important`" class="mx-2 text-h4" v-if="social.telegram">
                        mdi-telegram
                    </v-icon>
                    <v-icon @click="goToSm('twitch')" :style="`color: ${user.customization.iconColor}!important`" class="mx-2 text-h4" v-if="social.twitch">
                        mdi-twitch
                    </v-icon>
                    <v-icon @click="goToSm('linkedin')" :style="`color: ${user.customization.iconColor}!important`" class="mx-2 text-h4" v-if="social.linkedin">
                        mdi-linkedin
                    </v-icon>
                </div>
                <div style="display: flex; justify-content: center">
                    <a href="/">
                        <v-img contain :src="JSON.parse(website).logo" class="linkPageLogo"></v-img>
                    </a>
                </div>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: "LinkPage",
    props: ["user", "website", "auth"],
    computed: {
        links() {
            return this.user.links.filter(link => link.is_active == true);
        },
        social() {
            return this.user.social;
        }
    },
    methods: {
        onMouseOut(buttonId) {
            let customization = this.user.customization
            if (customization) {
                let button = document.getElementById(`${buttonId}`)
                // Typographie
                button.style.fontSize = customization.fontSize
                button.style.fontWeight = customization.fontWeight
                button.style.color = customization.fontColor
                button.style.backgroundColor = customization.buttonBackground
                button.style.border = customization.buttonBorderSize + 'px solid ' + customization.buttonBorder
            }
        },
        onMouseOver(buttonId) {
            let customization = this.user.customization
            if (customization) {
                let button = document.getElementById(`${buttonId}`)
                button.style.fontSize = customization.fontSizeHover
                button.style.fontWeight = customization.fontWeightHover
                button.style.color = customization.fontColorHover
                button.style.backgroundColor = customization.buttonBackgroundHover
                button.style.border = customization.buttonBorderSizeHover + 'px solid ' + customization.buttonBorderHover
            }
        },
        isUrl(value) {
            const pattern = new RegExp('^(https?:\\/\\/)?'+ '^(http?:\\/\\/)?'+ // protocol
                                '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
                                '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
                                '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
                                '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
                                '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
            return pattern.test(value)
        },
        analytic(link) {
            console.log(this.auth)
            if (this.auth == undefined) {
                axios.put('/clicks/add', link)
                .then(res => {
                    window.location.href = link.link
                })
                .catch(err => {
                    //
                })
            } else {
                window.location.href = link.link
            }
        },
        goToSm(sm) {
            if (sm == 'facebook') {
                window.location.href = 'https://www.facebook.com/' + this.social.facebook
            }
            if (sm == 'twitter') {
                window.location.href = 'https://www.twitter.com/' + this.social.twitter
            }
            if (sm == 'instagram') {
                window.location.href = 'https://www.instagram.com/' + this.social.instagram
            }
            if (sm == 'linkedin') {
                window.location.href = 'https://www.linkedin.com/' + this.social.linkedin
            }
            if (sm == 'youtube') {
                window.location.href = 'https://www.youtube.com/' + this.social.youtube
            }
            if (sm == 'telegram') {
                window.location.href = 'https://www.t.me/' + this.social.telegram
            }
            if (sm == 'twitch') {
                window.location.href = 'https://www.twitch.tv/' + this.social.telegram
            }
        }
    },
    created() {
        let customization = this.user.customization
        // The page background
        if (this.isUrl(customization.pageBackground)) {
            document.getElementById('app').style.backgroundImage = `url(${customization.pageBackground})!important`
            document.body.style.backgroundImage = `url('${customization.pageBackground}')!important`
        } else {
            document.getElementById('app').style.background = `linear-gradient(45deg, ${customization.pageBackground[0]}, ${customization.pageBackground[1]})!important`
        }

        // Increment the views of this link
        this.links.forEach(link => {
            axios.put('/views/add', link)
            .then(res => {
                //
            })
        })
    }
};
</script>

<style>
    .main-btn {
        transition: .2s;
    }
    .linkPageLogo {
        height: 30px;
        margin-top: 15px;
    }
</style>
