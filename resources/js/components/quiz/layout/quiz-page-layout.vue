<template>
    <QuizHeaderWithProgressBar
        :ranking="ranking"
        :questionsRemaining="questionsRemaining"
        :quizTitle="quizTitle"
        :timeRemaining="timeRemaining"
        :progressBarValue="progressBarValue"
        :score="score"
    />

    <QuizQuestionText :title="question.title" />

    <div class="quiz-body">
        <div>
            <template v-if="question.type === '0'">
                <!-- Check question type -->
                <QuizTypeMCQ
                    :options="question.options"
                    :correctAnswer="question.correct_ans"
                    :timeRemaining="timeRemaining"
                    @returnValues="handleReturnValues"
                />
            </template>

            <template v-else-if="question.type === '1'">
                <!-- Check question type -->
                <QuizTypeTrueFalse
                    :correctAnswer="question.correct_ans"
                    :timeRemaining="timeRemaining"
                    @returnValues="handleReturnValues"
                />
            </template>

            <template v-else-if="question.type === '2'">
                <!-- Check question type -->
                <QuizTypeText
                    :correctAnswer="question.correct_ans"
                    :timeRemaining="timeRemaining"
                    @returnValues="handleReturnValues"
                />
            </template>
        </div>
    </div>
</template>

<script>
import { useQuizStore } from "../../../store.js";
import QuizHeaderWithProgressBar from "../quiz-header-with-progress-bar.vue";
import QuizQuestionText from "../quizComponent/quiz-question-text.vue";
import QuizTypeMCQ from "../quizComponent/quiz-type-mcq.vue";
import QuizTypeTrueFalse from "../quizComponent/quiz-type-truefalse.vue";
import QuizTypeText from "../quizComponent/quiz-type-text.vue";

import ForwardBackwardBtn from "../postAnswerAction/forward-backward-btn.vue";
import QuizExplaination from "../postAnswerAction/quiz-explaination.vue";
import QuizLeaderboard from "../postAnswerAction/quiz-leaderboard.vue";

export default {
    components: {
        QuizHeaderWithProgressBar,
        QuizQuestionText,
        QuizTypeMCQ,
        QuizTypeTrueFalse,
        QuizTypeText,
        ForwardBackwardBtn,
        QuizExplaination,
        QuizLeaderboard,
    },
    data() {
        return {
            // question: {}, // Initialize question object
            ranking: "1st",
            questionsRemaining: "1/2",
            quizTitle: "Basic Math",
            timeRemaining: 0,
            progressBarValue: 100,
            timerInterval: null,
            submitted: false,
            defaultTime: 10,
            leaderboardTime: 5,
            score: 0,
        };
    },
    mounted() {
        const store = useQuizStore(); // Create store instance
        this.quizTitle = store.quizTitle;
        this.questionsRemaining = `${store.currentQuestionIndex + 1}/${
            store.quizTotalQuestion
        }`;
        this.score = store.totalPoints;
        this.startTimer();
        //   this.fetchQuizDetails(code);
    },
    methods: {
        // ... other methods
        startTimer() {
            const store = useQuizStore();
            const currentQuestion = store.questions[store.currentQuestionIndex];
            const questionDuration = currentQuestion
                ? currentQuestion.duration
                : this.defaultTime;

            this.timeRemaining = questionDuration;
            this.progressBarValue = 100;

            this.timerInterval = setInterval(() => {
                if (this.timeRemaining > 0) {
                    this.timeRemaining--; // Decrement timeRemaining by 1 every second
                    this.progressBarValue =
                        (this.timeRemaining / questionDuration) * 100; // Update progress bar value accordingly
                } else {
                    clearInterval(this.timerInterval);
                }
            }, 1000); // Update every second (1000 milliseconds)
        },
        handleReturnValues(returnedValues) {
            this.submitted = true;
            const { selectedOptions, answeredCorrectly } = returnedValues;
            console.log("Selected Options:", selectedOptions);
            console.log("Answered Correctly:", answeredCorrectly);

            this.postSubmitAction(selectedOptions, answeredCorrectly);
        },

        postSubmitAction(submitedAns, answeredCorrectly) {
            const store = useQuizStore();
            const currentTime = this.timeRemaining;
            const timeTaken =
                store.questions[store.currentQuestionIndex].duration -
                currentTime;
            const questionId = store.questions[store.currentQuestionIndex].id;
            console.log("questionId " + questionId);
            console.log("timeTaken " + timeTaken);
            console.log(" this.timeRemaining " + this.timeRemaining);
            // store.recordQuestionTime({ questionId , timeTaken });

            clearInterval(this.timerInterval);

            store.storeQuestionTime(questionId, timeTaken);
            store.storeQuizResponse(questionId, submitedAns);
            store.storeCorrectness(questionId, answeredCorrectly);
            store.storeQuestionPoints(questionId);

            this.score = store.totalPoints;

            console.log("submitedAns");
            console.log(submitedAns);

            console.log(store.questionTimes);
            console.log(store.userResponses);
            console.log(store.correctness);

            this.socket = io("http://localhost:3000");
            this.socket.emit("update score", {
                id: store.userId,
                newScore: store.totalPoints,
            });

            // this.socket.emit('get leaderboard');

            this.submitResponseToDatabase(
                timeTaken,
                submitedAns,
                answeredCorrectly
            );

            this.timeRemaining = 1;
            this.progressBarValue = 100;

            this.timerInterval = setInterval(() => {
                if (this.timeRemaining > 0) {
                    this.timeRemaining--; // Decrement timeRemaining by 1 every second
                    this.progressBarValue = (this.timeRemaining / 5) * 100; // Update progress bar value accordingly
                } else {
                    clearInterval(this.timerInterval);
                    console.log(
                        store.questions[store.currentQuestionIndex]
                            .answer_explaination
                    );
                    if (
                        store.questions[store.currentQuestionIndex]
                            .answer_explaination !== null &&
                        store.questions[store.currentQuestionIndex]
                            .answer_explaination !== "[]"
                    ) {
                        this.$router.push("/quiz-explaination");
                    } else {
                        this.$router.push("/quiz-leaderboard");
                    }
                }
            }, 1000); // Update every second (1000 milliseconds)
        },
        async submitResponseToDatabase(
            timeTaken,
            submitedAns,
            answeredCorrectly
        ) {
            const store = useQuizStore();
            const payload = {
                session_id: store.sessionId, // Replace with the session ID
                user_id: store.userId, // Replace with the user ID
                question_id: this.question.id, // Replace with the question ID
                quiz_id: store.quizId,
                time_taken: timeTaken, // Replace with time taken
                user_response: submitedAns, // Replace with user response array or data
                correctness: answeredCorrectly, // Replace with correctness boolean
                points: store.questionPoints[this.question.id], // Replace with points awarded
                // Add other necessary data
            };

            await store.storeIndividualResponse(payload);
        },
        resetTimer(time) {
            clearInterval(this.timerInterval);
            this.timeRemaining = time;
            this.progressBarValue = 100;
        },
        setTimer(duration) {
            this.timeRemaining = duration;
            this.progressBarValue = 100;

            this.timerInterval = setInterval(() => {
                if (this.timeRemaining > 0) {
                    this.timeRemaining--;
                    this.progressBarValue =
                        (this.timeRemaining / duration) * 100;
                } else {
                    clearInterval(this.timerInterval);
                }
            }, 1000);
        },
    },
    computed: {
        question() {
            const store = useQuizStore(); // Access the Vuex store
            console.log("123123123");
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
.quiz-body {
    background-image: url("../../../../../public/img/play-quiz-bg.png");
    background-repeat: repeat;
}
</style>
