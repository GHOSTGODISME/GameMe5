<template>
    <div class="header">
        <div class="header-small-block-cont">
            <div class="header-small-block-style">
                <i class="fa-solid fa-ranking-star"></i>
                <span class="ranking-text">{{ ranking }}</span>
            </div>

            <div class="header-small-block-style">
                <span class="num-ques-remaining">{{ questionsRemaining }}</span>
            </div>

            <div class="header-small-block-style">
                <span class="totalScore">{{ score }}</span>
            </div>
        </div>

        <div class="header-quiz-title">
            {{ quizTitle }}
        </div>

        <div class="header-time-remaining">{{ timeRemaining }}s</div>
    </div>

    <!-- progress bar -->
    <div class="progress">
        <div
            id="time-progress"
            class="progress-bar bg-info"
            role="progressbar"
            :style="{ width: progressBarValue + '%', transition: 'width 0.5s' }"
            :aria-valuenow="progressBarValue"
            aria-valuemin="0"
            aria-valuemax="100"
        ></div>
    </div>
</template>

<script>
import { useQuizStore } from "../../store.js";

export default {
    props: {
        timeRemaining: {
            type: Number,
            default: 0,
        },
        progressBarValue: {
            type: Number,
            default: 0,
        },
    },
    data() {
        return {
            quizTitle: "",
            questionsRemaining: "",
            score: 0,
            ranking: 0,
        };
    },
    mounted() {
        this.fetchQuizData();
    },
    methods: {
        fetchQuizData() {
            const store = useQuizStore();
            this.quizTitle = store.quizTitle;
            this.questionsRemaining = `${store.currentQuestionIndex + 1}/${
                store.quizTotalQuestion
            }`;
            this.score = store.totalPoints;
            this.ranking = store.userRank;
        },
    },
};
</script>