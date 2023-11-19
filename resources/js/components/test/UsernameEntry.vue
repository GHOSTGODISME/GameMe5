<template>
    <div>
      <h2>Enter Username</h2>
      <label for="username">Username:</label>
      <input type="text" id="username" v-model="username">
      <button @click="joinQuiz">Join Quiz</button>
      <div>
        <h3>Participants</h3>
        <ul>
          <li v-for="participant in participants" :key="participant.id">
            {{ participant.name }}
          </li>
        </ul>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        username: '',
        participants: [], // Array to store participants' names
      };
    },
    created() {
      // Fetch initial participants list from the backend upon component creation
      this.fetchParticipants();
    },
    methods: {
      fetchParticipants() {
        // Fetch participants' names from the backend API
        // Update this.participants with the retrieved data
      },
      joinQuiz() {
        // Validate if the username is unique
        // If unique, send the username and quiz code to the backend API to join the quiz
        // If successful, update the participants list with the new participant
        // If username is not unique or other errors occur, display appropriate message to the user
      },
    },
  };
  </script>
  