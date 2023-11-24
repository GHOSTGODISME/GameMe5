<template>
      <div>
        <QuizHeader :quizTitle="title" />
        <!-- <JoinQuizUsername :quizTitle="title" /> -->

        <div class="container join-quiz-bg">
          <div v-if="!joinedQuiz" class="row join-quiz-screen">
              <div class="col-md-6 col-lg-5 p-5 join-quiz-title">
                  You have joined the "{{ title }}" Quiz!
              </div>
              <div class="col-md-6 col-lg-7 p-5 join-quiz-details">
                  <p class="join-quiz-details-username">Username</p>
                  <input type="text" class="form-control join-quiz-details-input" :style="inputStyle"
                      v-model="username" placeholder="Player's name" required />
                  <!-- <span v-if="showErrorMessage" class="input-fails-text">Username has been used</span> -->
                  <span v-if="emptyUserNameMsg" class="input-fails-text">Please enter a username</span>
                  <p class="join-quiz-details-instruction">
                      Please enter your username and wait for the host to start the game.
                  </p>

                  <div class="button-container">
                      <!-- <button class="btn btn-dark button-style" @click="validateUsername">Confirm</button> -->
                      <button class="btn btn-dark button-style" @click="validateUsername">Confirm</button>
                  </div>

              </div>
          </div>
          <div v-else class="wait-start-screen">
              <p>Waiting for the host to start the quiz...</p>
              <span class="joined-participants-people">{{ username }}</span>
          </div>
      </div>
  
        <button @click="startQuiz">Start Quiz</button>
  
        <JoinQuizJoinedParticipants />
      </div>
  </template>
  
<script>
import { useQuizStore } from '../../../store.js';
import QuizHeader from '../quiz-header.vue';
//   import JoinQuizUsername from '../join-quiz-username.vue';
import JoinQuizJoinedParticipants from '../join-quiz-joined-participants.vue';

export default {
  components: {
    QuizHeader,
    //JoinQuizUsername,
    JoinQuizJoinedParticipants,
  },
  data() {
    return {
      title: "test",
      username: '',
      joinedQuiz: false,
      emptyUserNameMsg: false,
    };
  },
  created() {
    const store = useQuizStore(); // Create store instance
    const code = this.$route.query.code;
    store.setSessionCode(code);
    store.fetchQuizDetails().then(() => {
      this.title = store.quizTitle;
    });

    // store.fetchQuizQuestions(code).then(() => {
    // console.log('Fetched questions:', store.questions);
    // });
    // this.fetchData(code);
  },
  computed: {
    inputStyle() {
      // Compute input field style based on error condition
      return this.emptyUserNameMsg ?
        {
          border: '3px solid #CA0000',
          background: '#FFEDED'
        } :
        {};
    }
  },
  methods: {
    startQuiz() {
      // this.$router.push('/quiz-page-layout');
      this.$router.push('/quiz-loading');
    },
    validateUsername() {
      if (this.username.trim() === '') {
        this.emptyUserNameMsg = true;
      } else {
        this.emptyUserNameMsg = false;
        this.joinedQuiz = true; // Set the flag to indicate user has joined the quiz

        const store = useQuizStore();
        store.setUsername(this.username);
        console.log("store.username " + store.username);
      }
    },
  },
};
  </script>
  