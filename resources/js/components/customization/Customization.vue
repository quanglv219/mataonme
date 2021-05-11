<template>
  <div>
    <v-layout row wrap justify-center class="mt-7">
      <v-flex xs11 sm11 md11 lg5 xl5 class="px-5">
        <!-- Customization -->
        <v-card class="mb-5" elevation="0">
          <v-card-title class="grey--text">Link page customization</v-card-title>
          <v-card-text v-if="user.is_subscribed">
            <v-form ref="form">
              <errors :success="customSuccess" :failure="customFailure" :message="customMessage"></errors>
              <!-- Page Background Color -->
              <v-radio-group
                v-model="type"
                column
              >
                <v-radio
                  label="Colors"
                  value="color"
                  @click="pageBackground = defaultColor"
                ></v-radio>
                <v-radio
                  label="Image"
                  value="image"
                  @click="pageBackground = isUrl(customization.pageBackground) ? customization.pageBackground : 'https://resi.ze-robot.com/dl/4k/4k-desktop-wallpaper.-2560%C3%971440.jpg'"
                ></v-radio>
              </v-radio-group>
              <v-layout row wrap justify-center>
                <v-flex xs12 sm12 md12 lg12 xl12 class="px-5" v-if="type == 'color'">
                  <div class="my-3">
                    <p class="text-body-1">Background</p>
                    <div v-if="pageBackground">
                      <p>Color name: {{ pageBackground.name }}</p>
                      <div>
                        <div :style="`display: inline-block; height: 25px; width: 25px;background:${pageBackground.colors[0]}`"></div> 
                        <span>{{ pageBackground.colors[0] }}</span>
                        <div :style="`display: inline-block; height: 25px; width: 25px;background:${pageBackground.colors[1]}`"></div>
                        <span>{{ pageBackground.colors[1] }}</span>
                      </div>
                      <div class="mb-3" :style="`padding: 100px; width: 100%;background: linear-gradient(45deg, ${pageBackground.colors[0]}, ${pageBackground.colors[1]}`"></div>
                    </div>
                    <v-dialog max-width="70%" v-model="dialog">
                      <template v-slot:activator="{ on, attrs }">
                        <v-btn
                          color="primary"
                          outlined
                          v-bind="attrs"
                          v-on="on"
                        >
                          Choose colors
                        </v-btn>
                      </template>
                      <v-card>
                        <v-card-title>Choose a color</v-card-title>
                        <v-divider class="mb-3"></v-divider>
                        <v-card-text>
                          <div style="display: inline-block; width: 100%">
                            <div 
                              class="mx-1"
                              :style="`cursor: pointer; padding: 65px; width: 30px; display: inline-block; background: linear-gradient(45deg, ${gradient.colors[0]}, ${gradient.colors[1]})`" 
                              v-for="(gradient, index) in gradients" 
                              :key="index"
                              @click="pageBackground = gradient, dialog = false"
                            >
                            </div>
                          </div>
                        </v-card-text>
                      </v-card>
                    </v-dialog>
                  </div>
                </v-flex>
                <!-- / Page Background Color -->
                <v-flex xs12 sm12 md12 lg12 xl12 class="px-5" v-if="type == 'image'">
                  <!-- Page Background Image -->
                  <div>
                    <form enctype="multipart/form-data">
                      <v-img 
                      :src="pageBackground ? pageBackground : 'https://cdn.hovia.com/app/uploads/Blue-Illustrated-Landscape-Mountains-Wallpaper-Mural.jpg'"
                      height="200px"
                      class="mb-3"
                      >
                      </v-img>
                      <v-file-input label="Background Image" accept="image/*" v-model="backgroundImage"></v-file-input>
                    </form>
                  </div>
                  <!-- / Page Background Image -->
                </v-flex>
              </v-layout>
              <!-- Font size & . . . -->
                <v-layout row wrap justify-center>
                  <v-flex xs12 sm12 md12 lg6 xl6 class="px-5">
                    <v-text-field :rules="[rules.required]" label="Font size" type="number" v-model="fontSize"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md12 lg6 xl6 class="px-5">
                    <v-text-field :rules="[rules.required]" label="Font weight" type="number" v-model="fontWeight"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md12 lg6 xl6 class="px-5">
                    <v-text-field :rules="[rules.required]" label="Font color" v-model="fontColor"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md12 lg6 xl6 class="px-5">
                    <v-text-field :rules="[rules.required]" label="Font color on hover" v-model="fontColorHover"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md12 lg6 xl6 class="px-5">
                    <v-text-field :rules="[rules.required]" label="Buttons background" v-model="buttonBackground"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md12 lg6 xl6 class="px-5">
                    <v-text-field :rules="[rules.required]" label="Buttons background on hover" v-model="buttonBackgroundHover"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md12 lg6 xl6 class="px-5">
                    <v-text-field :rules="[rules.required]" label="Buttons border size" type="number" v-model="buttonBorderSize"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md12 lg6 xl6 class="px-5">
                    <v-text-field :rules="[rules.required]" label="Buttons border size on hover" type="number" v-model="buttonBorderSizeHover"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md12 lg6 xl6 class="px-5">
                    <v-text-field :rules="[rules.required]" label="Buttons border color" v-model="buttonBorder"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md12 lg6 xl6 class="px-5">
                    <v-text-field :rules="[rules.required]" label="Buttons border color on hover" v-model="buttonBorderHover"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md12 lg6 xl6 class="px-5">
                    <v-text-field :rules="[rules.required]" label="Shape of buttons" type="number" v-model="borderRadius"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md12 lg6 xl6 class="px-5">
                    <v-text-field :rules="[rules.required]" label="Icons colors" v-model="iconColor"></v-text-field>
                  </v-flex>
                </v-layout>
              <!-- / Font size & . . . -->
              <div style="display: flex; justify-content: flex-end">
                <v-btn-toggle>
                  <v-btn target="_blank" :href="'/'+user.username" color="primary accent-3" elevation="0" class="white--text mt-2" large>Preview</v-btn>
                  <v-btn color="cyan accent-3" elevation="0" class="white--text mt-2" large @click="customize">Save Changes</v-btn>
                </v-btn-toggle>
              </div>
            </v-form>
          </v-card-text>
          <v-card-text v-else>
            <p class="text-danger"><a href="/upgrade" class="text-decoration-none">Upgrade</a> to PRO to customize every detail in your page.</p>
          </v-card-text>
        </v-card>
        <!-- / Customization -->

        <!-- Starter templates -->
        <v-card elevation="0" class="mb-5">
          <v-card-title>Starter templates</v-card-title>
          <v-divider></v-divider>
          <v-card-text>
            <v-form ref="themesForm" v-model="themesForm">
              <v-radio-group v-model="theme" :rules="[rules.required]">
                <v-radio label="Light" value="light"></v-radio>
                <v-radio label="Blue" value="blue"></v-radio>
              </v-radio-group>
              <div style="display: flex; justify-content: flex-end">
                <v-btn color="cyan accent-3" elevation="0" class="white--text" large @click="saveTheme">Save</v-btn>
              </div>
            </v-form>
          </v-card-text>
        </v-card>
        <!-- / Starter templates -->

        <!-- Profile Image Upload -->
        <v-card elevation="0" class="mb-5">
          <v-card-title class="grey--text">Upload profile image</v-card-title>
          <v-card-text>
            <v-form ref="form" v-model="valid">
                <form enctype="multipart/form-data">
                  <v-alert type="info" border="left" v-if="imageLoading">Uploading the image ...</v-alert>
                  <errors :success="imageSuccess" :failure="imageFailure" :message="imageMessage"></errors>
                  <v-file-input v-model="profile" accept="image/*" label="Profile image" :rules="[rules.required]" outlined></v-file-input>
                  <div style="display: flex; justify-content: flex-end">
                    <v-btn color="cyan accent-3" elevation="0" class="white--text" large @click="uploadImage">Save</v-btn>
                  </div>
                </form>
            </v-form>
          </v-card-text>
        </v-card>
        <!-- / Profile Image Upload -->
      </v-flex>
      <v-flex xs11 sm11 md11 lg3 xl3 class="px-5">
        <iframe ref="iframe" :src="iframeSrc" style="width: 100%; height: 700px; border-radius: 25px; border: 0px"></iframe>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
import axios from 'axios'
import Errors from '../partials/Errors.vue'
import gradients from './../../../../public/assets/gradients.json'

export default {
  components: { Errors },
    name: "Customization",
    props: ['user'],
    data() {
      return {
        rules: {
          required: value => !! value || 'Required'
        },
        type: 'color',
        valid: false,
        profile: null,
        imageSuccess: false,
        imageFailure: false,
        imageMessage: '',
        imageLoading: false,
        dialog: false,
        fontSize: '',
        fontWeight: '',
        fontColor: '',
        fontColorHover: '',
        pageBackground: '',
        buttonBackground: '',
        buttonBackgroundHover: '',
        buttonBorderSize: '',
        buttonBorderSizeHover: '',
        buttonBorder: '',
        buttonBorderHover: '',
        borderRadius: '',
        backgroundImage: '',
        iconColor: '',
        customSuccess: false,
        customFailure: false,
        customMessage: '',
        customization: null,
        defaultColor: {
          "name": "Mango Pulp",
          "colors": ["#F09819", "#EDDE5D"]
        },
        iframeSrc: '/' + this.user.username,
        themesForm: '',
        theme: '',
        light: {
            "name": "Light",
            "colors": ["white", "#f4f4f4f4"]
        },
        blue: {
            "name": "Blue",
            "colors": ["#17D8E2", "#28abb2"]
        }
      }
    },
    computed: {
      gradients() {
        return gradients
      }
    },
    methods: {
      isUrl(value) {
        const pattern = new RegExp('^(https?:\\/\\/)?'+ '^(http?:\\/\\/)?'+ // protocol
                            '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
                            '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
                            '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
                            '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
                            '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
        return pattern.test(value)
      },
      uploadImage() {
        this.imageSuccess = false
        this.imageFailure = false
        this.imageMessage = ""
        // Validate the form
        this.$refs.form.validate()
        if (this.valid) {
          this.imageLoading = true
          let formData = new FormData()
          formData.append('photo', this.profile)
          axios.post('/user', formData)
          .then(res => {
            this.imageLoading = false
            this.imageSuccess = true
            this.imageFailure = false
            this.imageMessage = "Image uploaded successfully."
            // Refresh the iframe
            this.$refs.iframe.contentWindow.location.reload()
          })
          .catch(err => {
            this.imageLoading = false
            this.imageFailure = true
            this.imageSuccess = false
            this.imageMessage = "Something went wrong during the upload."
          })
        }
      },
      customize() {
        let backgroundImage = 'https://cdn.hovia.com/app/uploads/Blue-Illustrated-Landscape-Mountains-Wallpaper-Mural.jpg'
        // Upload the background image
        if (this.backgroundImage) {
          let backgroundFormData = new FormData()
          backgroundFormData.append('backgroundImage', this.backgroundImage)
          axios.post('/customize/backgroundImage', backgroundFormData)
          .then(res => this.pageBackground = res.data)
        }
        let customization = {
          fontSize: this.fontSize,
          fontWeight: this.fontWeight,
          fontColor: this.fontColor,
          fontColorHover: this.fontColorHover,
          pageBackground: this.pageBackground,
          buttonBackground: this.buttonBackground,
          buttonBackgroundHover: this.buttonBackgroundHover,
          buttonBorderSize: this.buttonBorderSize,
          buttonBorderSizeHover: this.buttonBorderSizeHover,
          buttonBorder: this.buttonBorder,
          buttonBorderHover: this.buttonBorderHover,
          borderRadius: this.borderRadius,
          iconColor: this.iconColor
        }
        // Update the customization settings
        axios.put('/customization', customization)
        .then(res => {
          this.customSuccess = true
          this.customFailure = false
          this.customMessage = "Information updated successfully."
          this.$refs.iframe.contentWindow.location.reload()
        })
        .catch(err => {
          this.customSuccess = false
          this.customFailure = true
          this.customMessage = "Something went wrong, Please try again later."
        })
      },
      saveTheme() {
        this.$refs.themesForm.validate()
        let theme = null
        if (this.theme == "blue") {
          theme = this.blue
          theme = {
            pageBackground: this.blue,
            iconColor: 'white',
            fontColor: 'white',
            fontColorHover: '#17D8E2',
            buttonBackground: '#17D8E2',
            buttonBackgroundHover: 'white',
            buttonBorder: 'white',
            buttonBorderHover: 'white',
          }
        } else {
          theme = this.light
          theme = {
            pageBackground: this.light,
            iconColor: '#17D8E2',
            buttonborderHover: '#17D8E2'
          }
        }
        axios.put('/change/background', theme)
        .then(res => {
          console.log(res)
          // Refresh the iframe
          this.$refs.iframe.contentWindow.location.reload()
        })
        .catch(err => console.log(err))

      }
    },
    created() {
      axios.get(`/customization?user=${this.user.id}`)
      .then(res => {
        this.customization = res.data
        this.fontSize = res.data.fontSize,
        this.fontWeight = res.data.fontWeight,
        this.fontColor = res.data.fontColor,
        this.fontColorHover = res.data.fontColorHover,
        this.pageBackground = this.isUrl(res.data.pageBackground) ? res.data.pageBackground : JSON.parse(res.data.pageBackground),
        this.buttonBackground = res.data.buttonBackground,
        this.buttonBackgroundHover = res.data.buttonBackgroundHover,
        this.buttonBorderSize = res.data.buttonBorderSize,
        this.buttonBorderSizeHover = res.data.buttonBorderSizeHover,
        this.buttonBorder = res.data.buttonBorder,
        this.buttonBorderHover = res.data.buttonBorderHover,
        this.borderRadius = res.data.borderRadius,
        this.iconColor = res.data.iconColor
        if (this.isUrl(res.data.pageBackground)) {
          this.type = "image"
        } else {
          this.type = "color"
        }
      })
      .catch(err => {
        console.log('Something went wrong')
      })
    }
}
</script>

<style>

</style>