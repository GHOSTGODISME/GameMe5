<template>
    <div id="loading-body" v-if="showText">
        <transition name="scale">
            <p :key="countdown" class="countdown-text">{{ countdown }}</p>
        </transition>
    </div>
</template>

<script>
import { useQuizStore } from "../../store.js";

export default {
    data() {
        return {
            showText: true,
            countdownArray: [3, 2, 1, "Start"],
            currentIndex: 0,
            countdown: "",
        };
    },
    mounted() {
        this.startCountdown();
    },
    created() {
        this.fetchQuizSettings();
        this.fetchQuizQuestions();
    },
    methods: {
        async fetchQuizSettings() {
            const store = useQuizStore();
            await store.fetchSessionSettings();
        },
        async fetchQuizQuestions() {
            const store = useQuizStore();
            await store.fetchQuizQuestions();
        },
        startCountdown() {
            const interval = setInterval(() => {
                if (this.currentIndex < this.countdownArray.length) {
                    this.countdown = this.countdownArray[this.currentIndex];
                    this.currentIndex++;
                } else {
                    this.finishCountdown();
                    clearInterval(interval);
                }
            }, 1500);
        },
        finishCountdown() {
            this.showText = false;
            this.$router.push("/quiz/quiz-page-layout");
        },
    },
};
</script>