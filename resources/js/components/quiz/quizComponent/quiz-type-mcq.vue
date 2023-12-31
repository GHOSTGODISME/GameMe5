<template>
    <div id="quiz-options-container" class="container">
        <div class="row" id="mcq-question-container" @keydown="handleKeyPress">
            <div
                v-for="(option, index) in options"
                :key="index"
                class="col-10 col-md-5 format-option"
                :class="optionClasses(option)"
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
        options: {
            type: Array,
            required: true,
        },
        correctAnswer: {
            type: Array,
            required: true,
        },
        singleSelectFlag: {
            type: Number,
            required: true,
        },
        timeRemaining: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            selectedOptions: [],
            submitted: false,
        };
    },
    mounted() {
        window.addEventListener("keydown", (e) => {
            this.handleKeyPress(e);
        });

        console.log("this.singleSelectFlag " + this.singleSelectFlag);
    },
    methods: {
        selectOption(option) {
            if (!this.submitted) {
                if (this.singleSelectFlag === 1) {
                    // Clear selectedOptions if singleSelectFlag is 1 (single answer mode)
                    this.selectedOptions = [option];
                } else {
                    // Toggle option selection for multi-answer mode (singleSelectFlag is 0)
                    const index = this.selectedOptions.indexOf(option);
                    if (index !== -1) {
                        this.selectedOptions.splice(index, 1);
                    } else {
                        this.selectedOptions.push(option);
                    }
                }
            }
        },
        optionClasses(option) {
            return {
                "option-not-selected": this.isNotSelected(option),
                "format-option-selected": this.isOptionSelected(option),
                "option-correct": this.isCorrectOption(option),
                "option-incorrect": this.isIncorrectOption(option),
            };
        },
        submitInput() {
            this.submitted = true;
            this.answeredCorrectly = this.checkAnswer();
            this.$emit("returnValues", {
                selectedOptions: this.selectedOptions,
                answeredCorrectly: this.answeredCorrectly,
            });
        },
        checkAnswer() {
            if (
                this.selectedOptions.length === this.correctAnswer.length &&
                this.selectedOptions.every((selected) =>
                    this.correctAnswer.includes(selected)
                )
            ) {
                return true;
            } else {
                return false;
            }
        },
    },
    computed: {
        isOptionSelected() {
            return (option) => this.selectedOptions.includes(option);
        },
        isCorrectOption() {
            return (option) =>
                this.submitted && this.correctAnswer.includes(option);
        },
        isIncorrectOption() {
            return (option) =>
                this.submitted &&
                !this.correctAnswer.includes(option) &&
                this.selectedOptions.includes(option);
        },
        isNotSelected() {
            return (option) =>
                this.submitted &&
                !this.selectedOptions.includes(option) &&
                !this.correctAnswer.includes(option);
        },
    },
    watch: {
        timeRemaining(newTimeRemaining, oldTimeRemaining) {
            if (newTimeRemaining === 0 && !this.submitted) {
                this.selectedOptions = [];
                this.submitInput();
            }
        },
    },
};
</script>


