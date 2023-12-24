<template>
    <QuizHeaderWithProgressBar
        :timeRemaining="timeRemaining"
        :progressBarValue="progressBarValue"
    />

    <div id="answer-explaination-container">
        <h2 style="margin: 10px 0 20px 0">Answer Explaination</h2>
        <p>{{ question.answer_explaination }}</p>
    </div>

</template>
<script>
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
        };
    },
    created() {
        this.startTimer();
    },
    methods: {
        startTimer() {
            this.timeRemaining = 5;
            this.progressBarValue = 100;
            const store = useQuizStore();

            this.timerInterval = setInterval(() => {
                if (this.timeRemaining > 0) {
                    this.timeRemaining--;
                    this.progressBarValue = (this.timeRemaining / 5) * 100;
                } else {
                    clearInterval(this.timerInterval);
                    if (store.showLeaderboardFlag === 1) {
                        this.$router.push("/quiz/quiz-leaderboard");
                    } else {
                        store.currentQuestionIndex += 1;
                        if (
                            store.currentQuestionIndex < store.questions.length
                        ) {
                            this.$router.push("/quiz/quiz-page-layout");
                        } else {
                            this.$router.push("/quiz/quiz-closure");
                        }
                    }
                }
            }, 1000);
        },
    },
    computed: {
        question() {
            const store = useQuizStore();
            return store.questions[store.currentQuestionIndex] || {};
        },
    },
    beforeDestroy() {
        clearInterval(this.timerInterval);
    },
};
</script>