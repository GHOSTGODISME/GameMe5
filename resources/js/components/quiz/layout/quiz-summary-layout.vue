<template>
    <div id="summary-container">
        <div id="summary-general-container">
            <h2>Summary</h2>
            <p id="quiz-username">Chloe Lee</p>
            <QuizSummaryBlock1
                :rank="rank"
                :numOfParticipants="numOfParticipants"
                :score="score"
                :accuracy="accuracy"
            />
            <QuizSummaryBlock2
                :numOfCorrect="numOfCorrect"
                :numOfIncorrect="numOfIncorrect"
                :avgTime="avgTime"
            />

            <!-- <div style="display: flex; justify-content: space-evenly; flex-wrap: wrap;align-items: center;">
                <div class="submit-button-container">
                    <button id="play-again-button" class="btn btn-primary button-style">Play again</button>
                </div>

                <div class="submit-button-container">
                    <button id="find-new-quiz-button" class="btn btn-primary button-style">Find new quiz</button>
                </div>
            </div> -->
        </div>

        <QuizSummaryReviewQuestion
            :questionsData="questions"
            :userResponses="userAnswers"
            :correctness="correctnessData"
        />

        <div class="horizontal-line-with-text">
            <span> You have reach to the end of the summary </span>
        </div>
    </div>
</template>

<script>
import QuizSummaryBlock1 from "../quiz-summary-block1.vue";
import QuizSummaryBlock2 from "../quiz-summary-block2.vue";
import QuizSummaryReviewQuestion from "../quiz-summary-review-question.vue";
import { useQuizStore } from "../../../store.js";

export default {
    components: {
        QuizSummaryBlock1,
        QuizSummaryBlock2,
        QuizSummaryReviewQuestion,
    },
    data() {
        return {
            /// block1
            rank: 1,
            numOfParticipants: 20,
            score: 20,
            accuracy: 100,
            /// block2
            numOfCorrect: 4,
            numOfIncorrect: 5,
            avgTime: 7.5,
            /// reviewquestion
            questions: [],
            userAnswers: {},
            correctnessData:{},
        };
    },
    mounted() {
        this.socket = io("http://localhost:3000");
        const store = useQuizStore();
        // Listen for the total participants count from the server
        this.socket.on("total participants", (totalParticipants) => {
            this.numOfParticipants = totalParticipants;
        });

        this.socket.on("update leaderboard", (leaderboard) => {
            console.log("Received updated leaderboard:", leaderboard);
            this.leaderboardData = leaderboard;
            store.updateUserRank(this.leaderboardData);
            this.rank - store.rank;
        });
        this.socket.emit("get leaderboard");

        this.score = store.totalPoints;
        this.accuracy = store.quizAccuracy;

        this.numOfCorrect = store.correctAnswersCount;
        this.numOfIncorrect = store.incorrectAnswersCount;
        this.avgTime = store.averageTime;

        this.questions = store.questions;
        this.userAnswers = store.userResponses;
        this.correctnessData = store.correctness;

        console.log(this.questions);
        console.log(this.userAnswers);
        console.log(this.correctnessData);
    },
};
</script>

<style>
.header-container {
    width: 100%;
    height: 100px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(to right, #00C6FF, #0082FF, #0072FF);
    color: white;
    padding: 30px;
    flex-wrap: wrap;
}

.header-quiz-title {
    font-weight: bold;
    font-size: 32px;
    color: white;
    margin: auto;
}

.header-setting {
    font-size: 24px;
}

.quiz-body {
    background-image: url('img/play-quiz-bg.png');
    background-repeat: repeat;
}

#summary-container {
    background: white;
    width: 500px;
    margin: auto;
    padding-top: 50px;
    padding-bottom: 20px;
}

#summary-general-container {
    width: 80%;
    margin: auto;
    text-align: center;
}

.summary-container-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 30px;
    margin-bottom: 30px;
    font-size: 18px;
    color: white;
    background: #0195FF;
}

.summary-color-block {
    display: flex;
    justify-content: space-evenly;
    align-items: center;
    flex-wrap: wrap;
}

.summary-container-block {
    background: yellowgreen;
    color: white;
    width: 100px;
    padding: 10px;
    margin: 10px;
    word-break: break-all;
}

.summary-container-block p:first-child {
    text-align: left;
    font-size: 18px;
    font-weight: 300;
    margin: 0;
}

.summary-container-block p:nth-child(2) {
    text-align: center;
    font-size: 32px;
    font-weight: bolder;
    margin: 0;
    display: inline-block;
}

.summary-container-block span {
    font-size: 20px;
}

#review-question-container {
    width: 90%;
    background: white;
    margin: auto;
    margin-top: 30px;
}


.review-question-title {
    font-size: 24px;
}

.review-question-container-single {
    margin: 15px;
}

.container-style {
    padding: 10px 20px;
    word-break: break-all;
}

.review-answer {
    margin-left: 30px;
}

.correct-ans {
    color: #35A32B;
}

.correct-ans-title-bg {
    border-radius: 10px 10px 0 0;
    background: #85FFB6;
}

.correct-ans-options-bg {
    border-radius: 0 0 10px 10px;
    background: #DCFFE4;
}

.incorrect-ans {
    color: #B90000;
}

.incorrect-ans-title-bg {
    border-radius: 10px 10px 0 0;
    background: #FF9191;
}

.incorrect-ans-options-bg {
    border-radius: 0 0 10px 10px;
    background: #FFC7C7;
}

.horizontal-line-with-text {
    margin: auto;
    width: 70%;
    height: 8px;
    border-bottom: 1px solid black;
    text-align: center;
    margin-bottom: 50px;
    margin-top: 30px;
}

.horizontal-line-with-text span {
    font-size: 14px;
    background-color: white;
    padding: 0 15px;
}

.radio-text {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    flex-wrap: wrap;
}

/* Styling for the custom circular icons */
.icon-style {
    margin-right: 10px;
    margin-top: 3px;
    font-size: 18px;
    vertical-align: middle;
}

.default {
    color: rgb(132, 132, 132);
    /* Style for unchecked */
}

.correct {
    color: green;
    /* Style for correct answer */
}

.incorrect {
    color: red;
    /* Style for incorrect answer */
}

.submit-button-container {
    display: flex;
    justify-content: center;
    margin-top: 30px;
}

.button-style {
    font-size: 16px;
    padding: 10px 40px;
    display: flex;
    background: #123956;
}
</style>
