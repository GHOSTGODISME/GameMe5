<template>
    <div id="review-question-container">
        <p class="review-question-title">Review Questions</p>
        <div id="quiz-container">
            <div
                class="review-question-container-single"
                v-for="(question, index) in questionsData"
                :key="question.id"
            >
                <div
                    :class="{
                        'container-style': true,
                        'correct-ans-title-bg': correctness[question.id],
                        'incorrect-ans-title-bg': !correctness[question.id],
                    }"
                >
                    {{ index + 1 }}. {{ question.title }}
                </div>
                <div
                    :class="{
                        'container-style': true,
                        'correct-ans-options-bg': correctness[question.id],
                        'incorrect-ans-options-bg': !correctness[question.id],
                    }"
                >
                    <!-- Render different HTML based on the question type -->
                    <template
                        v-if="question.type === '0' || question.type === '1'"
                    >
                        <p
                            v-for="(option, optionIndex) in question.options"
                            :key="optionIndex"
                            class="radio-text"
                        >
                            <i
                                :class="{
                                    fas: true,
                                    'fa-check-square':
                                        !question.single_ans_flag &&
                                        userResponses[question.id].includes(
                                            option
                                        ),
                                        'fa-check-square':
                                        !question.single_ans_flag &&
                                        userResponses[question.id].includes(
                                            option
                                        ),
                                    'fa-circle':
                                        question.single_ans_flag &&
                                        userResponses[question.id].includes(
                                            option
                                        ),
                                    'icon-style': true,
                                    checked:
                                        userResponses[question.id].includes(
                                            option
                                        ),
                                    correct:
                                        question.correct_ans.includes(option),
                                    'incorrect-ans':
                                        !question.correct_ans.includes(option),
                                }"
                            ></i>
                            {{ option }}
                            <span
                                v-if="
                                    userResponses[question.id].includes(option)
                                "
                                :class="{
                                    'review-answer': true,
                                    'correct-ans':
                                        question.correct_ans.includes(option),
                                    'incorrect-ans':
                                        !question.correct_ans.includes(option),
                                }"
                                >Your Answer</span
                            >
                            <span
                                v-else-if="
                                    !userResponses[question.id].includes(
                                        option
                                    ) && question.correct_ans.includes(option)
                                "
                                class="review-answer correct-ans"
                                >Correct Answer</span
                            >
                        </p>
                    </template>
                    <template v-else-if="question.type === '2'">
                        <!-- For text input type questions -->
                        <p
                            v-if="
                                userResponses[question.id][0] !== undefined &&
                                userResponses[question.id][0].trim() !== ''
                            "
                        >
                            {{ userResponses[question.id][0] }}
                            <span
                                v-if="
                                    userResponses[
                                        question.id
                                    ][0].toLowerCase() ===
                                    question.correct_ans[0].toLowerCase()
                                "
                                class="review-answer correct-ans"
                                >Your Answer</span
                            >
                            <span v-else class="review-answer incorrect-ans"
                                >Your Answer</span
                            >
                        </p>
                        <p v-else>No answer provided</p>
                        <hr v-if="!correctness[question.id]" />
                        <span
                            v-if="!correctness[question.id]"
                            class="correct-ans"
                            >Correct Answer: {{ question.correct_ans[0] }}</span
                        >
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        questionsData: {
            type: Array,
            default: () => [],
        },
        userResponses: {
            type: Object,
            default: () => ({}),
        },
        correctness: {
            type: Object,
            default: () => ({}),
        },
    },
};
</script>

<style>
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
    color: #35a32b;
}

.correct-ans-title-bg {
    border-radius: 10px 10px 0 0;
    background: #85ffb6;
}

.correct-ans-options-bg {
    border-radius: 0 0 10px 10px;
    background: #dcffe4;
}

.incorrect-ans {
    color: #b90000;
}

.incorrect-ans-title-bg {
    border-radius: 10px 10px 0 0;
    background: #ff9191;
}

.incorrect-ans-options-bg {
    border-radius: 0 0 10px 10px;
    background: #ffc7c7;
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
