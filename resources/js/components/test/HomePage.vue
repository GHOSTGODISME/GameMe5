<template>
    <div>
      <h2>Welcome to the Quiz</h2>
      <label for="quizCode">Enter Quiz Code:</label>
      <input type="text" id="quizCode" v-model="quizCode">
      <button @click="checkQuizCode">Enter</button>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        quizCode: '',
      };
    },
    methods: {
      checkQuizCode() {
        // Validate the quiz code entered by the user
        // If the code is valid, navigate to the next page for username entry
        // Use Vue Router to navigate to the username entry page
        this.$router.push({ name: 'UsernameEntry', params: { quizCode: this.quizCode } });
      },
    },
  };
  </script>
  