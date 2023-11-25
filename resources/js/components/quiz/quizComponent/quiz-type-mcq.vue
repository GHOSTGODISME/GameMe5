<template>
    <div id="quiz-options-container" class="container">
        <div class="row" id="mcq-question-container">
            <div v-for="(option, index) in options" :key="index" class="col-10 col-md-5 format-option" :class="{
                'option-not-selected': isNotSelected(option),
                'format-option-selected': isOptionSelected(option),
                'option-correct': isCorrectOption(option),
                'option-incorrect': isIncorrectOption(option),
            }" @click="selectOption(option)">
                {{ option }}
            </div>
        </div>
    </div>
    <div class="submit-button-container">
        <button v-if="!submitted" id="quiz-submit-button" class="btn btn-primary button-style" @click="submitInput">
            Submit
        </button>
    </div>
</template>
  
<script>
export default {
    emits: ['returnValues'],
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
            selectedOptions: [], // Array to store selected options
            submitted: false, // Flag to track submission status
        };
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
        isOptionSelected(option) {
            return this.selectedOptions.includes(option);
        },
        isCorrectOption(option) {
            return this.submitted && this.correctAnswer.includes(option);
        },
        isIncorrectOption(option) {
            return this.submitted && !this.correctAnswer.includes(option) && this.selectedOptions.includes(option);
        },
        isNotSelected(option) {
            return this.submitted && !this.selectedOptions.includes(option) && !this.correctAnswer.includes(option);
        },
        submitInput() {
            this.submitted = true; // Set submission status to true
            this.answeredCorrectly = this.checkAnswer();
            this.$emit('returnValues', {
                selectedOptions: this.selectedOptions,
                answeredCorrectly: this.answeredCorrectly,
            });
        },
        checkAnswer() {
            // Check if all selected options match the correct answer
            if (
                this.selectedOptions.length === this.correctAnswer.length &&
                this.selectedOptions.every((selected) => this.correctAnswer.includes(selected))
            ) {
                return true; // All selected options match the correct answer
            } else {
                return false; // Selected options do not match the correct answer
            }
        },
    },
    watch: {
        timeRemaining(newTimeRemaining, oldTimeRemaining) {
            if (newTimeRemaining === 0 && !this.submitted) {
                this.submitInput();
            }
        }
    }
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
    background-color: #0195FF;

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
    background-color: #00C6FF;
    cursor: pointer;
}

.format-option-selected {
    border: 5px solid #232946;
    background-color: #00C6FF;
}

.option-correct {
    background: #76C893;
}

.option-incorrect {
    background: #AC4D58;
}

.option-not-selected {
    background: #CCC;
}
</style>
