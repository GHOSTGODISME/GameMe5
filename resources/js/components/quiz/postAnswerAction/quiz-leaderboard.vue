<template>
    <QuizHeaderWithProgressBar
        :timeRemaining="timeRemaining"
        :progressBarValue="progressBarValue"
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
                        :class="{
                            'highlighted-row': player.id === store.userId,
                        }"
                    >
                        <th scope="row">{{ index + 1 }}</th>
                        <td>{{ player.username }}</td>
                        <td>{{ player.score }}</td>
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
            timeRemaining: 10,
            progressBarValue: 100,
            timerInterval: null,
            leaderboardData: [],
            socket: null,
            store: null,
        };
    },
    mounted() {
        this.initializeSocket();
        this.startTimer();
    },
    created() {
        this.socket = io("http://localhost:3000");
        this.store = useQuizStore();
        document.body.className = "play-quiz-body";
    },
    methods: {
        initializeSocket() {
            this.socket.emit("rejoinRoom", this.store.sessionCode);
            this.socket.emit("get leaderboard", this.store.sessionCode);

            this.socket.on("update leaderboard", (leaderboard) => {
                this.leaderboardData = leaderboard;
                this.store.updateUserRank(this.leaderboardData);
            });
        },
        startTimer() {
            this.timeRemaining = 5;
            this.progressBarValue = 100;

            this.timerInterval = setInterval(() => {
                if (this.timeRemaining > 0) {
                    this.timeRemaining--;
                    this.progressBarValue = (this.timeRemaining / 5) * 100;
                } else {
                    this.handleTimeUp();
                }
            }, 1000);
        },
        handleTimeUp() {
            clearInterval(this.timerInterval);
            this.store.setCurrentQuestionIndex(
                this.store.currentQuestionIndex + 1
            );

            if (this.store.currentQuestionIndex < this.store.questions.length) {
                this.$router.push("/quiz/quiz-page-layout");
            } else {
                this.$router.push("/quiz/quiz-closure");
            }
        },
    },
    beforeUnmount() {
        this.socket.emit("exitRoom", this.store.sessionCode);
        clearInterval(this.timerInterval);
    },
};
</script>

<style scoped>
.highlighted-row {
    background-color: #0195ff;
}
</style>
