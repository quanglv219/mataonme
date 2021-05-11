<template>
  <div>
    <v-alert type="success" :class="{ 'rounded-0': square }" color="teal darken-3" dismissible border="left" v-if="success">{{ message }}</v-alert>
    <v-alert type="error" border="left" v-if="failure">{{ message }}</v-alert>
  </div>
</template>

<script>
export default {
    name: "Errors",
    props: ['success', 'failure', 'message', 'square']
}
</script>

<style>

</style>