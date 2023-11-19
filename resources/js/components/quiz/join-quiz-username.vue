<template>
    <div class="container join-quiz-bg">
      <div v-if="!joinedQuiz" class="row join-quiz-screen">
        <div class="col-md-6 col-lg-5 p-5 join-quiz-title">
          You have joined the "{{ quizTitle }}" Quiz!
        </div>
        <div class="col-md-6 col-lg-7 p-5 join-quiz-details">
          <p class="join-quiz-details-username">Username</p>
          <input
            type="text"
            class="form-control join-quiz-details-input"
            :style="inputStyle"
            v-model="username"
            placeholder="Player's name"
            required
          />
          <span v-if="showErrorMessage" class="input-fails-text">Username has been used</span>
          <p class="join-quiz-details-instruction">
            Please enter your username and wait for the host to start the game.
          </p>
          <div class="button-container">
            <button class="btn btn-dark button-style" @click="validateUsername">Confirm</button>
          </div>
        </div>
      </div>
      <div v-else class="wait-start-screen">
        <p>Waiting for the host to start the quiz...</p>
        <span v-for="(participant, index) in participants" :key="index" class="joined-participants-people">{{ participant }}</span>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        username: '', // Holds the entered username
        showErrorMessage: false, // Flag to show/hide error message
        quizTitle: 'Basic Math', // Default quiz title
        joinedQuiz: false, // Flag to determine if the user has joined the quiz
        // Other data properties...
      };
    },
    computed: {
      inputStyle() {
        // Compute input field style based on error condition
        return this.showErrorMessage
          ? {
              border: '3px solid #CA0000',
              background: '#FFEDED'
            }
          : {};
      }
    },
    methods: {
      validateUsername() {
        // Simulated validation - replace with your actual validation logic
        if (this.username === 'existingUsername') {
          this.showErrorMessage = true; // Show error message if username already exists
          // Additional logic as needed for your validation
        } else {
          this.showErrorMessage = false; // Hide error message if username is valid
          this.joinedQuiz = true; // Set the flag to indicate user has joined the quiz
          // Proceed with further actions (e.g., joining the quiz, sending data to server)
        }
      }
      // Other methods...
    }
  };
  </script>
  
  <style>
  /* Other styles as needed */
  </style>
  