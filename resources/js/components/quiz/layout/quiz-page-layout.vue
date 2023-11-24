<template>
    <QuizHeaderWithProgressBar :ranking="ranking" :questionsRemaining="questionsRemaining" :quizTitle="quizTitle"
        :timeRemaining="timeRemaining" :progressBarValue="progressBarValue" />

    <QuizQuestionText :title="question.title" />

    <div class="quiz-body">
        <div>
            <template v-if="question.type === '0'"> <!-- Check question type -->
                <QuizTypeMCQ :options="question.options" :correctAnswer="question.correct_ans"
                    :timeRemaining="timeRemaining"  @returnValues="handleReturnValues" />
            </template>

            <template v-else-if="question.type === '1'"> <!-- Check question type -->
                <QuizTypeTrueFalse :correctAnswer="question.correct_ans" :timeRemaining="timeRemaining" @returnValues="handleReturnValues" />
            </template>

            <template v-else-if="question.type === '2'"> <!-- Check question type -->
                <QuizTypeText :correctAnswer="question.correct_ans" :timeRemaining="timeRemaining" @submitText="handleSubmittedText" />
            </template>

            <!-- <ForwardBackwardBtn v-if="submitted" /> -->
        </div>

        <!-- <div v-if="showExplanation">
            <QuizExplaination :explaination="question.answer_explanation" />
            <!== <ForwardBackwardBtn v-if="submitted" /> ==>
        </div>

        <div v-if="showLeaderboard">
            <QuizLeaderboard />
            <!== <ForwardBackwardBtn v-if="submitted" /> ==>
        </div> -->

    </div>
    <!-- Other components -->
</template>
  
<script>
import { useQuizStore } from '../../../store.js';
import QuizHeaderWithProgressBar from '../quiz-header-with-progress-bar.vue';
import QuizQuestionText from '../quizComponent/quiz-question-text.vue';
import QuizTypeMCQ from '../quizComponent/quiz-type-mcq.vue';
import QuizTypeTrueFalse from '../quizComponent/quiz-type-truefalse.vue';
import QuizTypeText from '../quizComponent/quiz-type-text.vue';

import ForwardBackwardBtn from '../postAnswerAction/forward-backward-btn.vue'
import QuizExplaination from '../postAnswerAction/quiz-explaination.vue';
import QuizLeaderboard from '../postAnswerAction/quiz-leaderboard.vue';


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
            timeRemaining: 10,
            progressBarValue: 100,
            timerInterval: null,
            submitted: false,
            showExplanation: false,
            showLeaderboard: false,
            defaultTime: 10,
            leaderboardTime: 5,
        };
    },
    created() {
        const store = useQuizStore(); // Create store instance
        this.quizTitle = store.quizTitle;
        this.startTimer();
        //   this.fetchQuizDetails(code);
    },
    methods: {
        // ... other methods
        startTimer() {
            const store = useQuizStore();
            const currentQuestion = store.questions[store.currentQuestionIndex];
            const questionDuration = currentQuestion ? currentQuestion.duration : this.defaultTime;

            this.timeRemaining = questionDuration;
            this.progressBarValue = 100;

            this.timerInterval = setInterval(() => {
                if (this.timeRemaining > 0) {
                    this.timeRemaining--; // Decrement timeRemaining by 1 every second
                    this.progressBarValue = (this.timeRemaining / 10) * 100; // Update progress bar value accordingly
                } else {
                    // Time is up, perform necessary actions or stop the timer
                    clearInterval(this.timerInterval);
                    // For example, emit an event or perform a specific action when the time is up
                    // this.$emit('timeUp');
                }
            }, 1000); // Update every second (1000 milliseconds)
        },
        handleReturnValues(returnedValues) {
            this.submitted = true;
            this.resetTimer(this.defaultTime);
            const { selectedOptions, answeredCorrectly } = returnedValues;
            console.log('Selected Options:', selectedOptions);
            console.log('Answered Correctly:', answeredCorrectly);

            this.postSubmitAction(selectedOptions, answeredCorrectly);
        },
        handleSubmittedText(combinedText) {
            this.submitted = true;
            this.resetTimer(this.defaultTime);
            const { submitedAns, answeredCorrectly } = returnedValues;

            this.postSubmitAction(submitedAns, answeredCorrectly);
        },

        postSubmitAction(submitedAns, answeredCorrectly) {
            const store = useQuizStore();
            const timeTaken = store.questions[store.currentQuestionIndex].duration - this.timeRemaining;
            const questionId = store.questions[store.currentQuestionIndex].id;
            console.log("questionId " + questionId);
            console.log("timeTaken " + timeTaken);
            // store.recordQuestionTime({ questionId , timeTaken });

            store.storeQuestionTime(questionId, timeTaken);
            store.storeQuizResponse(questionId, submitedAns);
            store.storeCorrectness(questionId, answeredCorrectly);
            store.storeQuestionPoints(questionId);

            this.timeRemaining = 5;
            this.progressBarValue = 100;

            this.timerInterval = setInterval(() => {
                if (this.timeRemaining > 0) {
                    this.timeRemaining--; // Decrement timeRemaining by 1 every second
                    this.progressBarValue = (this.timeRemaining / 10) * 100; // Update progress bar value accordingly
                } else {
                    clearInterval(this.timerInterval);
                    if(store.questions[store.currentQuestionIndex].answer_explanation !== null && 
                    store.questions[store.currentQuestionIndex].answer_explanation !== '[]'){
                        this.$router.push('/quiz-explanation');
                    }else{
                        this.$router.push('/quiz-leaderboard');
                    }
                }
            }, 1000); // Update every second (1000 milliseconds)

            // clearInterval(this.timerInterval);
            // // Display the explanation after a certain time

            // this.timeRemaining = this.defaultTime;
            // this.progressBarValue = 100;
            // this.resetTimer();
            // this.setTimer(5);

            // setTimeout(() => {
            //     this.showExplanation = true;
            //     this.resetTimer();
            //     this.setTimer(5);

            //     setTimeout(() => {
            //         this.showLeaderboard = true;
            //         this.resetTimer();
            //         this.setTimer(5);
            //     }, 10000);
            // }, 10000); // Delay for 5 seconds (revealing the answer)
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
                    this.progressBarValue = (this.timeRemaining / duration) * 100;
                } else {
                    clearInterval(this.timerInterval);
                }
            }, 1000);
        }
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
    background-image: url('../../../../../public/img/play-quiz-bg.png');
    background-repeat: repeat;
}
</style>
