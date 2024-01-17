<template>
    <div class="container">
        <div class="closure-container-bg">
            <div class="closure-container">
                <a href="{{ url('/stud_homepage') }}"><img class="logo" src="{{ asset('img/logo_header.png') }}" alt="Logo"></a> 

                <p class="closure-title">Congratulation!</p>

                <p class="closure-description">
                    You have completed the quiz !!!
                </p>

                <p class="text-white">
                    Press ‘Continue’ button to view your summary.
                </p>

                <button
                    class="btn button-style btn-dark"
                    type="submit"
                    @click="continueClicked"
                >
                    Continue 
                    <br />
                    (You will be directed to summary page in {{ this.countdown }}...)
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { useQuizStore } from "../../store.js";

export default {
    data(){
        return{
            countdown:5,
        };
    },  
    created() {
        this.storeQuizResponse();
        document.body.className = "closure-body";

        this.startCountdown();
    },
    methods: {
        startCountdown() {
            // Use setTimeout to trigger the continue button after 5 seconds
            setTimeout(() => {
                this.continueClicked();
            }, this.countdown*1000);

            // Update the countdown every second
            const countdownInterval = setInterval(() => {
                this.countdown--;
                if (this.countdown <= 0) {
                    clearInterval(countdownInterval); // Stop the interval when countdown reaches 0
                }
            }, 1000);
        },
        async storeQuizResponse() {
            try {
                const store = useQuizStore();
                await this.saveQuizResponse(store);
                this.storeFullResponses(store);
                await this.sendEmail(store);
            } catch (error) {
                console.error("Error processing quiz response:", error);
            }
        },
        async saveQuizResponse(store) {
            store.calculateQuizAccuracy();
            store.calculateAverageTime();

            const payload = this.prepareQuizPayload(store);

            const response = await axios.post(
                "/api/store-quiz-response",
                payload
            );
        },
        prepareQuizPayload(store) {
            const accuracy = store.quizAccuracy;
            const averageTime = store.averageTime;

            return {
                session_id: store.sessionId,
                username: store.username,
                user_id: store.userId,
                accuracy: accuracy,
                correct_answer_count: store.correctAnswersCount,
                incorrect_answer_count: store.incorrectAnswersCount,
                total_points: store.totalPoints,
                average_time: averageTime,
            };
        },
        async storeFullResponses(store) {
            const quizResponses = [];
            for (const question of store.questions) {
                const responsePayload = this.prepareResponsePayload(
                    store,
                    question.id
                );
                quizResponses.push(responsePayload);
            }

            if (quizResponses.length > 0) {
                const response = await axios.post("/api/store-full-responses", {
                    sessionId: store.sessionId,
                    userId: store.userId,
                    responses: quizResponses,
                });
            }
        },
        prepareResponsePayload(store, questionId) {
            return {
                question_id: questionId,
                user_response: store.userResponses[questionId] ?? null,
                correctness: store.correctness[questionId],
                time_usage: store.questionTimes[questionId],
            };
        },
        async sendEmail(store) {
            await axios.get(
                `/send-email/${store.userId}/${store.sessionId}/${store.quizId}`
            );
        },
        continueClicked() {
            const store = useQuizStore();
            const userId = store.userId;
            const sessionId = store.sessionId;
            const quizId = store.quizId;
            window.location.href = `/quiz-summary/${userId}/${sessionId}/${quizId}`;
            store.clearPinialocalStorage();
            store.resetStore();
        },
    },
};
</script>