<template>
            <QuizHeaderWithProgressBar :ranking="ranking" :questionsRemaining="questionsRemaining" :quizTitle="quizTitle"
        :timeRemaining="timeRemaining" :progressBarValue="progressBarValue" />


    <div class="leaderboard-container">
        <h1>Leaderboard</h1>
        <div class="table-container">
            <table class="" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col" style="width: 20%;">Rank</th>
                        <th scope="col" style="width: 55%;">Name</th>
                        <th scope="col" style="width: 25%;">Score</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(player, index) in leaderboard" :key="player.id">
                        <th scope="row">{{ index + 1 }}</th>
                        <td>{{ player . name }}</td>
                        <td>{{ player . score }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- <ForwardBackwardBtn /> -->

</template>

<script>
    // import ForwardBackwardBtn from './forward-backward-btn.vue';
import { useQuizStore } from '../../../store.js';
import QuizHeaderWithProgressBar from '../quiz-header-with-progress-bar.vue';

    export default {
        components: {
        QuizHeaderWithProgressBar,
        },
        data() {
            return {
                leaderboard: [
                { id: 1, name: 'Player 1', score: 100 },
                { id: 2, name: 'Player 2', score: 90 },
                { id: 3, name: 'Player 3', score: 80 },
                // Add more dummy data as needed
                ],
                ranking: "1st",
            questionsRemaining: "1/2",
            quizTitle: "Basic Math",
            timeRemaining: 10,
            progressBarValue: 100,
            timerInterval: null,
            };
        },
        mounted() {
            // this.fetchLeaderboard();
        },
        created() {
        const store = useQuizStore(); // Create store instance
        this.quizTitle = store.quizTitle;
        this.startTimer();
    },
        methods: {
            startTimer() {
            //const store = useQuizStore();
            //const currentQuestion = store.questions[store.currentQuestionIndex];

            this.timeRemaining = 5;
            this.progressBarValue = 100;

            this.timerInterval = setInterval(() => {
                if (this.timeRemaining > 0) {
                    this.timeRemaining--; // Decrement timeRemaining by 1 every second
                    this.progressBarValue = (this.timeRemaining / 10) * 100; // Update progress bar value accordingly
                } else {
                    // Time is up, perform necessary actions or stop the timer
                    clearInterval(this.timerInterval);
                    const store = useQuizStore();
                    store.currentQuestionIndex += 1;
                    console.log("store.questions.length " + store.questions.length);
                    console.log("store.currentQuestionIndex " + store.currentQuestionIndex);
                    if(store.currentQuestionIndex < store.questions.length){
                        // this.$router.push('/quiz-page.vue');
                        this.$router.push('/quiz-page-layout'); 
                    }else{
                        this.$router.push('/quiz-closure');
                    }
                    // For example, emit an event or perform a specific action when the time is up
                    // this.$emit('timeUp');
                }
            }, 1000); // Update every second (1000 milliseconds)
        },
        },
        beforeDestroy() {
        clearInterval(this.timerInterval);
    },
    };
</script>

<style>
    /* Add your styles here */
</style>



<!--

  <template>
    <div class="leaderboard-container">
      <h1>Leaderboard</h1>
      <div class="table-container">
        <table class="" style="width:100%">
          <thead>
            <tr>
              <th scope="col" style="width: 20%;">Rank</th>
              <th scope="col" style="width: 55%;">Name</th>
              <th scope="col" style="width: 25%;">Score</th>
            </tr>
          </thead>
          <transition-group name="leaderboard" tag="tbody">
            <tr v-for="(player, index) in leaderboard" :key="player.id">
              <td>{{ index + 1 }}</td>
              <td>{{ player . name }}</td>
              <td>{{ player . score }}</td>
            </tr>
          </transition-group>
        </table>
      </div>
    </div>
  </template>
  
  <script>
      export default {
          data() {
              return {
                  leaderboard: [],
                  previousLeaderboard: [], // Store previous leaderboard data
              };
          },
          mounted() {
              this.fetchLeaderboard();
          },
          methods: {
              fetchLeaderboard() {
                  // Make an API call to fetch leaderboard data from the backend
                  axios.get('/leaderboard')
                      .then(response => {
                          this.previousLeaderboard = [...this.leaderboard]; // Store previous leaderboard data
                          this.leaderboard = response.data;
                          this.checkLeaderboardChanges();
                      })
                      .catch(error => {
                          console.error('Error fetching leaderboard:', error);
                      });
              },
              checkLeaderboardChanges() {
                  // Compare current and previous leaderboard data to check for changes
                  // Implement your logic to check for rank changes or username changes here
                  // For demonstration, let's assume the rank changes were detected

                  // For example, if the ranks shifted from 3 to 1, animate a moving up effect
                  if (this.previousLeaderboard.length === this.leaderboard.length) {
                      // Implement logic to detect rank changes and trigger animations
                      // For instance, using CSS classes to animate the table rows
                  }
              },
          },
      };
  </script>
  
  <style>
  /* Add your styles here */
  /* Example CSS for animation */
  .leaderboard-enter-active {
    transition: all 0.5s;
  }
  
  .leaderboard-leave-active {
    transition: all 0.5s;
  }
  
  .leaderboard-enter, .leaderboard-leave-to /* .leaderboard-leave-active in <2.1.8 */ {
    opacity: 0;
    transform: translateY(30px);
  }
  </style> -->
