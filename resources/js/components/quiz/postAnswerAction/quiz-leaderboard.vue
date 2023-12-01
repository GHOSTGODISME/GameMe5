<template>
    <QuizHeaderWithProgressBar :timeRemaining="timeRemaining" :progressBarValue="progressBarValue" />

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
                    <tr v-for="(player, index) in leaderboardData" :key="player.id">
                        <th scope="row">{{ index + 1 }}</th>
                        <td>{{ player . username }}</td>
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
    import {
        useQuizStore
    } from "../../../store.js";
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
            };
        },
        mounted() {
            this.initializeSocket();
            this.startTimer();
        },
        methods: {
            initializeSocket() {
                this.socket = io("http://localhost:3000");
                const store = useQuizStore();

                this.socket.emit("rejoinRoom", store.sessionCode);
                this.socket.emit("get leaderboard", store.sessionCode);
    
                console.log("triggered get leaderboard");

                this.socket.on("update leaderboard", (leaderboard) => {
                    console.log("Received updated leaderboard:", leaderboard);
                    this.leaderboardData = leaderboard;
                    store.updateUserRank(this.leaderboardData);
                });
            },
            startTimer() {
                this.timeRemaining = 1;
                this.progressBarValue = 100;

                this.timerInterval = setInterval(() => {
                    if (this.timeRemaining > 0) {
                        this.timeRemaining--;
                this.progressBarValue = (this.timeRemaining / 10) * 100;
                    } else {
                        this.handleTimeUp();
                    }
                }, 1000);
            },
            handleTimeUp() {
                clearInterval(this.timerInterval);
                const store = useQuizStore();
                store.currentQuestionIndex += 1;

                if (store.currentQuestionIndex < store.questions.length) {
                    this.$router.push("/quiz/quiz-page-layout");
                } else {
                    this.$router.push("/quiz/quiz-closure");
                }
            },
        },
        beforeDestroy() {
            clearInterval(this.timerInterval);
            this.socket.disconnect();
        },
    };
</script>
