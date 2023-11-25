<template>
        <QuizHeaderWithProgressBar :ranking="ranking" :questionsRemaining="questionsRemaining" :quizTitle="quizTitle"
        :timeRemaining="timeRemaining" :progressBarValue="progressBarValue" />


    <div id="answer-explaination-container">
        <h2 style="margin:10px 0 20px 0;">Answer Explaination</h2>
        <p>{{ question.answer_explaination }}</p>
    </div>

    <!-- <ForwardBackwardBtn /> -->
</template>
<script>
import { useQuizStore } from '../../../store.js';
import QuizHeaderWithProgressBar from '../quiz-header-with-progress-bar.vue';

    export default {
        components: {
        QuizHeaderWithProgressBar,
        },
        data() {
        return {
            // question: {}, // Initialize question object
            ranking: "1st",
            questionsRemaining: "1/2",
            quizTitle: "Basic Math",
            timeRemaining: 10,
            progressBarValue: 100,
            timerInterval: null,
        };
    },
        mounted() {
            // // Code to handle displaying results and enabling/disabling buttons

            // // Transition to the next section after 10 seconds
            // setTimeout(() => {
            //     // Code to navigate to the quiz leaderboard or next section
            //     // Use Vue Router to navigate
            //     this.$router.push({
            //         name: 'quiz-leaderboard'
            //     }); // Change 'quiz-leaderboard' to your route name
            // }, 10000); // 10 seconds in milliseconds
        },
        created() {
        const store = useQuizStore(); // Create store instance
        this.quizTitle = store.quizTitle;
        this.startTimer();
    },
    methods: {
        startTimer() {
            this.timeRemaining = 5;
            this.progressBarValue = 100;

            this.timerInterval = setInterval(() => {
                if (this.timeRemaining > 0) {
                    this.timeRemaining--; // Decrement timeRemaining by 1 every second
                    this.progressBarValue = (this.timeRemaining / 5) * 100; // Update progress bar value accordingly
                } else {
                    clearInterval(this.timerInterval);
                    this.$router.push('/quiz-leaderboard');
                }
            }, 1000); // Update every second (1000 milliseconds)
        },
    },
        computed: {
        question() {
            const store = useQuizStore(); // Access the Vuex store
            console.log(store.questions[store.currentQuestionIndex]);
            return store.questions[store.currentQuestionIndex] || {}; // Get current question
        },
    },
    beforeDestroy() {
        clearInterval(this.timerInterval);
    },
    };
</script>
<style>
    #answer-explaination-container {
        background-color: whitesmoke;
        border: 1px solid black;
        border-radius: 10px;
        padding: 20px;
        margin: 30px;
        min-height: 250px;
    }
</style>
