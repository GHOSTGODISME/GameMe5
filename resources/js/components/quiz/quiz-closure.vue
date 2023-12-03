<template>
    <div class="closure-container-bg">
        <div class="closure-container">
            <img src="/img/logo_header.png" alt="img" />

            <p class="closure-title">Congratulation!</p>

            <p class="closure-description">You have completed the quiz !!!</p>

            <p class="text-white">
                Press ‘Continue’ button to view your summary.
            </p>

            <button class="btn button-style btn-dark" type="submit" @click="continueClicked">
                Continue
            </button>
        </div>
    </div>
</template>

<script>
    import {
        useQuizStore
    } from "../../store.js";

    export default {
        created() {
            this.storeQuizResponse();
        },
        methods: {
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

                const response = await axios.post("/api/store-quiz-response", payload);
                console.log("Quiz response stored successfully:", response.data);
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
                    const responsePayload = this.prepareResponsePayload(store, question.id);
                    quizResponses.push(responsePayload);
                }

                if (quizResponses.length > 0) {
                    const response = await axios.post("/api/store-full-responses", {
                        sessionId: store.sessionId,
                        userId: store.userId,
                        responses: quizResponses,
                    });
                    console.log("Individual responses stored successfully:", response.data);
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
                await axios.get(`/send-email/${store.userId}/${store.sessionId}/${store.quizId}`);
            },
            continueClicked() {
                const store = useQuizStore();
                const userId = store.userId;
                const sessionId = store.sessionId;
                const quizId = store.quizId;
                window.location.href = `/quiz-summary/${userId}/${sessionId}/${quizId}`;
                store.resetStore();
            },
        },
    };
</script>

<style>
    .closure-container-bg {
        background-image: url("/img/quiz-closure-awards.png");
        background-attachment: fixed;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        background-size: 500px;
        width: 100%;
        height: 100%;
        display: grid;
        place-items: center;
    }

    .closure-container {
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
        flex-direction: column;
        text-align: center;
        width: 80%;
        margin: auto;
    }

    .closure-title {
        color: white;
        text-shadow: 8px 8px 4px rgba(0, 0, 0, 0.25);
        /* font-size: 58px; */
        font-size: 8vw;
        font-weight: bold;
    }

    .closure-description {
        color: white;
        font-weight: 300;
        /* font-size: 32px; */
        font-size: 4vw;
        margin-bottom: 50px;
    }
</style>
