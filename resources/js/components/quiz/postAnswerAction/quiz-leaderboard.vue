<template>
    <QuizHeaderWithProgressBar
        :ranking="ranking"
        :questionsRemaining="questionsRemaining"
        :quizTitle="quizTitle"
        :timeRemaining="timeRemaining"
        :progressBarValue="progressBarValue"
        :score="score"
    />

    <div class="leaderboard-container">
        <h1>Leaderboard</h1>
        <div class="table-container">
            <table class="" style="width: 100%">
                <thead>
                    <tr>
                        <th scope="col" style="width: 20%">Rank</th>
                        <th scope="col" style="width: 55%">Name</th>
                        <th scope="col" style="width: 25%">Score</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(player, index) in leaderboardData"
                        :key="player.id"
                    >
                        <th scope="row">{{ index + 1 }}</th>
                        <td>{{ player.username }}</td>
                        <!-- Access "username" property -->
                        <td>{{ player.score }}</td>
                        <!-- Access "score" property -->
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- <ForwardBackwardBtn /> -->
</template>

<script>
// import ForwardBackwardBtn from './forward-backward-btn.vue';
import { useQuizStore } from "../../../store.js";
import QuizHeaderWithProgressBar from "../quiz-header-with-progress-bar.vue";

export default {
    components: {
        QuizHeaderWithProgressBar,
    },
    data() {
        return {
            leaderboard: [
                { id: 1, name: "Player 1", score: 100 },
                { id: 2, name: "Player 2", score: 90 },
                { id: 3, name: "Player 3", score: 80 },
                // Add more dummy data as needed
            ],
            ranking: "1st",
            questionsRemaining: "1/2",
            quizTitle: "Basic Math",
            timeRemaining: 10,
            progressBarValue: 100,
            timerInterval: null,
            leaderboardData: [],
        };
    },
    mounted() {
        this.socket = io("http://localhost:3000");
        this.socket.on("update leaderboard", (leaderboard) => {
            console.log("Received updated leaderboard:", leaderboard);
            this.leaderboardData = leaderboard;
            const store = useQuizStore(); // Create store instance
            store.updateUserRank(this.leaderboardData);
        });
        this.socket.emit("get leaderboard");
    },

    created() {
        const store = useQuizStore(); // Create store instance
        this.quizTitle = store.quizTitle;
        this.questionsRemaining = `${store.currentQuestionIndex + 1}/${
            store.quizTotalQuestion
        }`;
        this.score = store.totalPoints;

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
                    // Time is up, perform necessary actions or stop the timer
                    clearInterval(this.timerInterval);
                    const store = useQuizStore();
                    store.currentQuestionIndex += 1;
                    console.log(
                        "store.questions.length " + store.questions.length
                    );
                    console.log(
                        "store.currentQuestionIndex " +
                            store.currentQuestionIndex
                    );
                    if (store.currentQuestionIndex < store.questions.length) {
                        // this.$router.push('/quiz-page.vue');
                        this.$router.push("/quiz-page-layout");
                    } else {
                        this.$router.push("/quiz-closure");
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
    beforeUnmount() {
        if (this.socket) {
            this.socket.disconnect();
        }
    },
};
</script>
