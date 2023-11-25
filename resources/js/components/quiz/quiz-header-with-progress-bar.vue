<template>
    <div class="header">
        <div>
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

        <div class="header-time-remaining">
            {{ timeRemaining }}s
        </div>

        <div class="header-setting">
            <i class="fa-solid fa-gear"></i>
        </div>
    </div>

    <!-- progress bar -->
    <div class="progress">
        <div id="time-progress" class="progress-bar progress-bar-striped bg-black" role="progressbar"
            :style="{ width: progressBarValue + '%', transition: 'width 0.5s'}" :aria-valuenow="progressBarValue" aria-valuemin="0"
            aria-valuemax="100"></div>
    </div>
</template>

<script>
    export default {
        props: {
            ranking: String,
            questionsRemaining: String,
            quizTitle: String,
            timeRemaining: {
                type: Number,
                default: 0
            },
            progressBarValue: {
                type: Number,
                default: 0
            },
            score:{
                type:Number,
                default: 0
            },
        },
    };
</script>

<style scoped>
.progress-bar {
  transition: width 0.5s ease; /* Use a transition effect on width change */
}
</style>