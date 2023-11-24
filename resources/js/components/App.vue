<template>
    <router-view></router-view>
  </template>

<script>
export default {
  
    name: 'App',
    data(){

      return{
        code:''
      }
    },
    methods: {
    // goToQuiz() {
    //   this.$router.push({ name: 'join-quiz' }); // Navigate to the quiz page defined in Vue Router
    // }
  }
}
</script>
