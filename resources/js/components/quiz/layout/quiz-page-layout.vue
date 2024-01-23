<template>
    <QuizHeaderWithProgressBar
        :timeRemaining="timeRemaining"
        :progressBarValue="progressBarValue"
        :score="score"
    />

    <div id="quiz-title-container">{{ question.title }}</div>

    <div>
        <template v-if="question.type === 0">
            <QuizTypeMCQ
                :options="question.options"
                :correctAnswer="question.correct_ans"
                :singleSelectFlag="question.single_ans_flag"
                :timeRemaining="timeRemaining"
                @returnValues="handleReturnValues"
            />
        </template>

        <template v-else-if="question.type === 1">
            <QuizTypeTrueFalse
                :correctAnswer="question.correct_ans"
                :timeRemaining="timeRemaining"
                @returnValues="handleReturnValues"
            />
        </template>

        <template v-else-if="question.type === 2">
            <QuizTypeText
                :correctAnswer="question.correct_ans"
                :timeRemaining="timeRemaining"
                @returnValues="handleReturnValues"
            />
        </template>
    </div>
</template>

<script>
import { useQuizStore } from "../../../store.js";
import QuizHeaderWithProgressBar from "../quiz-header-with-progress-bar.vue";
import QuizTypeMCQ from "../quizComponent/quiz-type-mcq.vue";
import QuizTypeTrueFalse from "../quizComponent/quiz-type-truefalse.vue";
import QuizTypeText from "../quizComponent/quiz-type-text.vue";

import QuizExplaination from "../postAnswerAction/quiz-explaination.vue";
import QuizLeaderboard from "../postAnswerAction/quiz-leaderboard.vue";

export default {
    components: {
        QuizHeaderWithProgressBar,
        QuizTypeMCQ,
        QuizTypeTrueFalse,
        QuizTypeText,
        QuizExplaination,
        QuizLeaderboard,
    },
    data() {
        return {
            timeRemaining: 0,
            progressBarValue: 100,
            timerInterval: null,
            submitted: false,
            defaultTime: 10,
            socket: null,
            store: null,
            score:0,
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
            const currentQuestion =
                this.store.questions[this.store.currentQuestionIndex];
            const questionDuration = currentQuestion
                ? currentQuestion.duration
                : this.defaultTime;

            this.timeRemaining = questionDuration;
            this.progressBarValue = 100;

            this.timerInterval = setInterval(() => {
                if (this.timeRemaining > 0) {
                    this.timeRemaining--; // Decrement timeRemaining by 1 every second
                    this.progressBarValue =
                        (this.timeRemaining / questionDuration) * 100;
                } else {
                    clearInterval(this.timerInterval);
                }
            }, 1000);
        },
        handleReturnValues(returnedValues) {
            this.submitted = true;
            const { selectedOptions, answeredCorrectly } = returnedValues;

            this.postSubmitAction(selectedOptions, answeredCorrectly);
        },

        postSubmitAction(submitedAns, answeredCorrectly) {
            if (!Array.isArray(submitedAns)) {
                submitedAns = [submitedAns];
            }

            const currentTime = this.timeRemaining;
            const timeTaken =
                this.store.questions[this.store.currentQuestionIndex].duration -
                currentTime;
            const questionId =
                this.store.questions[this.store.currentQuestionIndex].id;

            clearInterval(this.timerInterval);

            this.store.storeQuestionTime(questionId, timeTaken);
            this.store.storeQuizResponse(questionId, submitedAns);
            this.store.storeCorrectness(questionId, answeredCorrectly);
            this.store.storeQuestionPoints(questionId, answeredCorrectly);

            this.score = this.store.totalPoints;

            this.socket.emit("update score", {
                sessionCode: this.store.sessionCode,
                userId: this.store.userId,
                newScore: this.store.totalPoints,
            });

            this.socket.emit("userData", {
                sessionCode: this.store.sessionCode,
                userData: {
                    userId: this.store.userId,
                    username: this.store.username,
                    questionId: this.question.id,
                    answeredOption: submitedAns ?? Array(0),
                    timeTaken: timeTaken,
                    correctness: answeredCorrectly,
                },
            });

            this.submitResponseToDatabase(
                timeTaken,
                submitedAns,
                answeredCorrectly
            );
            this.timeRemaining = 5;
            this.progressBarValue = 100;
            this.timerInterval = setInterval(() => {
                if (this.timeRemaining > 0) {
                    this.timeRemaining--; // Decrement timeRemaining by 1 every second
                    this.progressBarValue = (this.timeRemaining / 5) * 100; // Update progress bar value accordingly
                } else {
                    clearInterval(this.timerInterval);
                    if (
                        this.question.answer_explaination !== null &&
                        this.question.answer_explaination !== "[]"
                    ) {
                        this.$router.push("/quiz/quiz-explaination");
                    } else if (this.store.showLeaderboardFlag === 1) {
                        this.$router.push("/quiz/quiz-leaderboard");
                    } else {
                        this.store.currentQuestionIndex += 1;
                        if (
                            this.store.currentQuestionIndex <
                            this.store.questions.length
                        ) {
                            this.$router.push("/quiz/quiz-page-layout");
                        } else {
                            this.$router.push("/quiz/quiz-closure");
                        }
                    }
                }
            }, 1000); // Update every second (1000 milliseconds)
        },
        async submitResponseToDatabase(
            timeTaken,
            submitedAns,
            answeredCorrectly
        ) {
            const payload = {
                session_id: this.store.sessionId,
                user_id: this.store.userId,
                question_id: this.question.id,
                quiz_id: this.store.quizId,
                time_taken: timeTaken,
                user_response: submitedAns,
                correctness: answeredCorrectly,
                points: this.store.questionPoints[this.question.id],
            };

            await this.store.storeIndividualResponse(payload);
        },
        resetTimer(time) {
            clearInterval(this.timerInterval);
            this.timeRemaining = time;
            this.progressBarValue = 100;
        },
    },
    computed: {
        question() {
            if (this.store.shuffleOptionFlag === 1) {
                this.store.shuffle(
                    this.store.questions[this.store.currentQuestionIndex]
                        .options
                );
            }
            return this.store.questions[this.store.currentQuestionIndex] || {};
        },
    },
    beforeUnmount() {
        clearInterval(this.timerInterval);
        const store = useQuizStore();
        this.socket.emit("exitRoom", store.sessionCode);
    },
};
</script>
