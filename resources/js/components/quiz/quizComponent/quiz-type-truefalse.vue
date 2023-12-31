<template>
    <div id="quiz-options-container" class="container" ref="quizContainer">
        <div class="row" id="truefalse-container" @keydown="handleKeyPress">
            <div
                v-for="(option, index) in options"
                :key="index"
                :class="getOptionClasses(option)"
                @click="selectOption(option)"
                :data-key="index + 1"
            >
                {{ option }}
            </div>
        </div>
    </div>
    <div class="submit-button-container">
        <button
            v-if="!submitted"
            id="quiz-submit-button"
            class="btn btn-primary button-style"
            type="submit"
            @click="submitInput"
        >
            Submit
        </button>
    </div>
</template>

<script>
export default {
    emits: ["returnValues"],
    props: {
        correctAnswer: {
            type: Array,
            required: true,
        },
        timeRemaining: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            options: ["True", "False"],
            selectedOption: null,
            submitted: false,
        };
    },
    methods: {
        selectOption(option) {
            if (!this.submitted) {
                this.selectedOption = option;
            }
        },
        getOptionClasses(option) {
            return {
                "option-not-selected": this.isNotSelected(option),
                "format-option-selected": this.selectedOption === option,
                "option-correct": this.isCorrectOption(option),
                "option-incorrect": this.isIncorrectOption(option),
                "col-10": true,
                "col-md-5": true,
                "format-option": true,
            };
        },
        isCorrectOption(option) {
            return this.submitted && option === this.correctAnswer[0];
        },
        isIncorrectOption(option) {
            return (
                this.submitted &&
                option !== this.correctAnswer[0] &&
                this.selectedOption === option
            );
        },
        isNotSelected(option) {
            return (
                this.submitted &&
                option !== this.correctAnswer[0] &&
                this.selectedOption !== option
            );
        },
        handleKeyPress(event) {
            if (!this.submitted) {
                const key = event.key;
                const optionIndex = parseInt(key);

                if (
                    !isNaN(optionIndex) &&
                    optionIndex >= 1 &&
                    optionIndex <= this.options.length
                ) {
                    const selectedOption = this.options[optionIndex - 1];
                    this.selectOption(selectedOption);
                } else if (key === "Enter") {
                    this.submitInput();
                }
            }
        },

        submitInput() {
            this.submitted = true;
            const answeredCorrectly = this.checkAnswer();
            this.$emit("returnValues", {
                selectedOptions: this.selectedOption,
                answeredCorrectly,
            });
        },
        checkAnswer() {
            return (
                this.selectedOption !== null &&
                this.selectedOption.toLowerCase() ===
                    this.correctAnswer[0].toLowerCase()
            );
        },
    },
    watch: {
        timeRemaining(newTimeRemaining) {
            if (newTimeRemaining === 0 && !this.submitted) {
                this.submitInput();
            }
        },
    },
};
</script>
