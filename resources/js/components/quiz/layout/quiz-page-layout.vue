<template>
    <QuizHeaderWithProgressBar :timeRemaining="timeRemaining" :progressBarValue="progressBarValue" />

    <QuizQuestionText :title="question.title" />

    <div class="quiz-body">
        <div>
            <template v-if="question.type === '0'">
                <QuizTypeMCQ :options="question.options" :correctAnswer="question.correct_ans"
                    :timeRemaining="timeRemaining" @returnValues="handleReturnValues" />
            </template>

            <template v-else-if="question.type === '1'">
                <QuizTypeTrueFalse :correctAnswer="question.correct_ans" :timeRemaining="timeRemaining"
                    @returnValues="handleReturnValues" />
            </template>

            <template v-else-if="question.type === '2'">
                <QuizTypeText :correctAnswer="question.correct_ans" :timeRemaining="timeRemaining"
                    @returnValues="handleReturnValues" />
            </template>
        </div>
    </div>
</template>

<script>
    import {
        useQuizStore
    } from "../../../store.js";
    import QuizHeaderWithProgressBar from "../quiz-header-with-progress-bar.vue";
    import QuizQuestionText from "../quizComponent/quiz-question-text.vue";
    import QuizTypeMCQ from "../quizComponent/quiz-type-mcq.vue";
    import QuizTypeTrueFalse from "../quizComponent/quiz-type-truefalse.vue";
    import QuizTypeText from "../quizComponent/quiz-type-text.vue";

    import QuizExplaination from "../postAnswerAction/quiz-explaination.vue";
    import QuizLeaderboard from "../postAnswerAction/quiz-leaderboard.vue";

    export default {
        components: {
            QuizHeaderWithProgressBar,
            QuizQuestionText,
            QuizTypeMCQ,
            QuizTypeTrueFalse,
            QuizTypeText,
            QuizExplaination,
            QuizLeaderboard,
        },
        data() {
            return {
                // question: {}, // Initialize question object
                timeRemaining: 0,
                progressBarValue: 100,
                timerInterval: null,
                submitted: false,
                defaultTime: 10,
            };
        },
        mounted() {
            this.initializeSocket();
            this.startTimer();
            this.startTimer();
            this.socket = io("http://localhost:3000");
        },
        methods: {
            initializeSocket() {
                this.socket = io("http://localhost:3000");
            },
            // ... other methods
            startTimer() {
                const store = useQuizStore();
                const currentQuestion = store.questions[store.currentQuestionIndex];
                const questionDuration = currentQuestion ?
                    currentQuestion.duration :
                    this.defaultTime;

                // this.timeRemaining = questionDuration;
                this.timeRemaining = 5;
                this.progressBarValue = 100;

                this.timerInterval = setInterval(() => {
                    if (this.timeRemaining > 0) {
                        this.timeRemaining--; // Decrement timeRemaining by 1 every second
                        this.progressBarValue =
                            (this.timeRemaining / questionDuration) *
                            100; // Update progress bar value accordingly
                    } else {
                        clearInterval(this.timerInterval);
                    }
                }, 1000); // Update every second (1000 milliseconds)
            },
            handleReturnValues(returnedValues) {
                this.submitted = true;
                const {
                    selectedOptions,
                    answeredCorrectly
                } = returnedValues;

                this.postSubmitAction(selectedOptions, answeredCorrectly);
            },

            postSubmitAction(submitedAns, answeredCorrectly) {
                const store = useQuizStore();
                const currentTime = this.timeRemaining;
                const timeTaken =
                    store.questions[store.currentQuestionIndex].duration -
                    currentTime;
                const questionId = store.questions[store.currentQuestionIndex].id;

                clearInterval(this.timerInterval);

                store.storeQuestionTime(questionId, timeTaken);
                store.storeQuizResponse(questionId, submitedAns);
                store.storeCorrectness(questionId, answeredCorrectly);
                store.storeQuestionPoints(questionId, answeredCorrectly);

                this.score = store.totalPoints;

                this.socket.emit("update score", {
                    sessionCode: store.sessionCode,
                    userId: store.userId,
                    newScore: store.totalPoints,
                });

                this.socket.emit("userData", {
                    sessionCode: store.sessionCode,
                    userData: {
                        userId: store.userId,
                        username: store.username,
                        questionId: this.question.id,
                        answeredOption: submitedAns ?? Array(0),
                        timeTaken: timeTaken,
                        correctness: answeredCorrectly,
                    }

                });

                this.submitResponseToDatabase(timeTaken, submitedAns, answeredCorrectly);

                this.timeRemaining = 1;
                this.progressBarValue = 100;

                this.timerInterval = setInterval(() => {
                    if (this.timeRemaining > 0) {
                        this.timeRemaining--; // Decrement timeRemaining by 1 every second
                        this.progressBarValue = (this.timeRemaining / 5) *
                        100; // Update progress bar value accordingly
                    } else {
                        clearInterval(this.timerInterval);
                        if (this.question.answer_explaination !== null &&
                            this.question.answer_explaination !== "[]"
                        ) {
                            this.$router.push("/quiz/quiz-explaination");
                        } else if(store.showLeaderboardFlag === 1){
                            this.$router.push("/quiz/quiz-leaderboard");
                        }else{
                            store.currentQuestionIndex += 1;
                            if (store.currentQuestionIndex < store.questions.length) {
                                this.$router.push("/quiz/quiz-page-layout");
                            } else {
                                this.$router.push("/quiz/quiz-closure");
                            }
                        }
                    }
                }, 1000); // Update every second (1000 milliseconds)
            },
            async submitResponseToDatabase(timeTaken, submitedAns, answeredCorrectly) {
                const store = useQuizStore();
                const payload = {
                    session_id: store.sessionId,
                    user_id: store.userId,
                    question_id: this.question.id,
                    quiz_id: store.quizId,
                    time_taken: timeTaken,
                    user_response: submitedAns,
                    correctness: answeredCorrectly,
                    points: store.questionPoints[this.question.id],
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
                const store = useQuizStore();
                console.log(store.questions[store.currentQuestionIndex]);

                if(store.shuffleOptionFlag === 1){
                    store.shuffle(store.questions[store.currentQuestionIndex].options);
                }
                return store.questions[store.currentQuestionIndex] || {}; 
            },
        },
        beforeDestroy() {
            clearInterval(this.timerInterval);
            this.socket.close();
        },
    };
</script>

<style>
    .quiz-body {
        background-image: url("../../../../../public/img/play-quiz-bg.png");
        background-repeat: repeat;
    }
</style>
