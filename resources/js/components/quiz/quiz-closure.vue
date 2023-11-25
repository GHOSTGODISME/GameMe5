<template>
    <div class="closure-container-bg">
        <div class="closure-container">
            <img src="/img/logo_header.png" alt="img" />

            <p class="closure-title">Congratulation!</p>

            <p class="closure-description">You have completed the quiz !!!</p>

            <p class="text-white">
                Press ‘Continue’ button to view your summary.
            </p>

            <button class="btn button-style btn-dark" @click="continueClicked">
                Continue
            </button>
        </div>
    </div>
</template>

<script>
import { useQuizStore } from "../../store.js";

export default {
    created() {
        const store = useQuizStore();
        store.calculateQuizAccuracy();
        store.calculateAverageTime();
        // Assuming the following variables contain the calculated accuracy and average time
        const accuracy = store.quizAccuracy;
        const averageTime = store.averageTime;

        // Prepare payload for storing into the database
        const payload = {
            session_id: store.sessionId, // Assuming you have this session ID in your store
            username: store.username,
            user_id: store.userId, // Assuming you have this user ID in your store
            accuracy: accuracy,
            correct_answer_count: store.correctAnswersCount,
            incorrect_answer_count: store.incorrectAnswersCount,
            total_points: store.totalPoints,
            average_time: averageTime,
        };

        // Store the overall quiz response details into the QuizResponse table
        axios
            .post("/api/store-quiz-response", payload)
            .then((response) => {
                console.log(
                    "Quiz response stored successfully:",
                    response.data
                );
                // Proceed to store individual response details for each question
                this.storeFullResponses(store);
            })
            .catch((error) => {
                console.error("Error storing quiz response:", error);
                // Handle error
            });
    },
    methods: {
        continueClicked() {
            // this.$router.push("/quiz-summary-layout");

            const store = useQuizStore();

            // Assuming you have these variables in your store
            const userId = store.userId;
            const sessionId = store.sessionId;
            const quizId = store.quizId;

            window.location.href =`/quiz-summary/${userId}/${sessionId}/${quizId}`;
            // Redirect to the quiz summary page while passing parameters in the URL
            // this.$router.push({
            //     name: 'quiz-summary', // Replace with the actual route name
            //     params: {
            //         userId: userId,
            //         sessionId: sessionId,
            //         quizId: quizId
            //     }
            // });

        },
        async storeFullResponses(store) {
            const questions = store.questions;
            const quizResponses = [];
            const session_id = store.sessionId;
            const user_id = store.userId;

            for (const question of questions) {
                const questionId = question.id;

                // Prepare payload for storing individual response details
                const responsePayload = {
                    question_id: questionId,
                    user_response: store.userResponses[questionId] ?? null,
                    correctness: store.correctness[questionId],
                    time_usage: store.questionTimes[questionId],
                };
                // Add the payload to an array for bulk insertion
                quizResponses.push(responsePayload);
            }

            // Store the individual responses into the QuizResponseDetails table
            if (quizResponses.length > 0) {
                try {
                    console.log("session_id " + session_id);
                    console.log("user_id " + user_id);
                    console.log(quizResponses);
                    const response = await axios.post(
                        "/api/store-full-responses",
                        {
                            sessionId: session_id,
                            userId: user_id,
                            responses: quizResponses, // Pass responses array along with sessionId and userId
                        }
                    );
                    console.log(
                        "Individual responses stored successfully:",
                        response.data
                    );
                } catch (error) {
                    console.error("Error storing individual responses:", error);
                    // Handle error
                }
            }
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
