<template>
    <div id="quiz-options-container" class="container">
        <div class="row" id="mcq-question-container" @keydown="handleKeyPress">
            <!-- <div v-for="(option, index) in options" :key="index" class="col-10 col-md-5 format-option" :class="{
                'option-not-selected': isNotSelected(option),
                'format-option-selected': isOptionSelected(option),
                'option-correct': isCorrectOption(option),
                'option-incorrect': isIncorrectOption(option),
            }" @click="selectOption(option)"> -->
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
    },
    methods: {
        selectOption(option) {
            if (!this.submitted) {
                const index = this.selectedOptions.indexOf(option);
                if (index !== -1) {
                    this.selectedOptions.splice(index, 1);
                } else {
                    this.selectedOptions.push(option);
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
            this.answeredCorrectly = this.checkAnswer();
            this.$emit("returnValues", {
                selectedOptions: [],
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
                this.submitInput();
            }
        },
    },
};
</script>

<style scoped>
#mcq-question-container {
    display: flex;
    justify-content: space-evenly;
    margin: auto;
}

.format-option {
    border-radius: 10px;
    /* border: solid 1px black; */
    background-color: #0195ff;

    margin: 20px;
    padding: 40px 20px;

    font-size: 20px;
    /* for text */
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;

    transition: box-shadow 0.25s, background-color 0.5s;
}

.format-option:hover {
    box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.25);
    background-color: #00c6ff;
    cursor: pointer;
}

.format-option-selected {
    border: 5px solid #232946;
    background-color: #00c6ff;
}

.option-correct {
    background: #76c893;
}

.option-incorrect {
    background: #ac4d58;
}

.option-not-selected {
    background: #ccc;
}
</style>
