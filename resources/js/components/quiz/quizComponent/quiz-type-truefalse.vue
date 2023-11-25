<template>
    <div id="quiz-options-container" class="container">
        <div class="row" id="truefalse-container">
            <div v-for="(option, index) in options" :key="index" class="col-10 col-md-5 format-option" :class="{
                'option-not-selected': isNotSelected(option),
                'format-option-selected': selectedOption === option,
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
            options: ['True', 'False'], // True/False options
            selectedOption: null, // Selected option value
            submitted: false, // Flag to track submission status
        };
    },
    methods: {
        selectOption(option) {
            if (!this.submitted) {
                this.selectedOption = option;
            }
        },
        isCorrectOption(option) {
            return this.submitted && option === this.correctAnswer[0];
        },
        isIncorrectOption(option) {
            return this.submitted && option !== this.correctAnswer[0] && this.selectedOption === option;
        },
        isNotSelected(option) {
            return this.submitted && option !== this.correctAnswer[0] && this.selectedOption !== option;
        },
        submitInput() {
            this.submitted = true; // Set submission status to true
            this.answeredCorrectly = this.checkAnswer();
            // Emit an event to notify parent component with selected options
            this.$emit('returnValues', {
                selectedOptions: this.selectedOption,
                answeredCorrectly: this.answeredCorrectly
            });
        },
        checkAnswer() {
            return (this.selectedOption !== null) && (this.selectedOption.toLowerCase() === this.correctAnswer[0].toLowerCase());
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
#truefalse-container {
    margin: auto;
    justify-content: center;
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

/* .format-option:hover {
        box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.25);
        background-color: #00C6FF;
        cursor: pointer;
    } */

.format-option:not(.format-option-selected):not(.option-correct):not(.option-incorrect):not(.option-not-selected):hover {
    box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.25);
    background-color: #00c6ff;
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
