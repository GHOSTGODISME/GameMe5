<template>
    <div id="quiz-options-container" class="container">
        <div class="row" id="textinput-container" @keydown="handleKeyPress">

            <div class="text-input-container">
                <!-- Display correct/incorrect answer after submission -->
                <p v-if="submitted && answeredCorrectly" class="h3" style="color: #76C893;">Correct Answer</p>
                <p v-else-if="submitted && !answeredCorrectly" class="h3" style="color: #AC4D58;">Incorrect Answer</p>
                <hr v-if="submitted">
                <div class="text-input-div">
                    <input v-for="(inputValue, index) in inputValues" :key="index" v-model="inputValues[index]" :class="{
                        'text-input-correct': submitted && answeredCorrectly,
                        'text-input-incorrect': submitted && !answeredCorrectly
                    }" type="text" class="text-input" maxlength="1" @input="onInputChange(index, $event)"
                        @keydown="onKeyDown(index, $event)" :ref="'input-' + index" />
                </div>
            </div>
            <!-- Display suggested correct answer if the user's answer is incorrect -->
            <div v-if="submitted && !answeredCorrectly" class="text-input-container">
                <p class="h3 " style="color: #76C893;">Suggested Answer</p>
                <hr>
                <div class="text-input-div">
                    <input v-for="(char, index) in correctAnswer[0].toUpperCase()" :key="index" type="text"
                        class="text-input text-input-correct" maxlength="1" :value="char" disabled />
                </div>
            </div>
        </div>
    </div>

    <div class="submit-button-container">
        <button v-if="!submitted" id="quiz-submit-button" class="btn btn-primary button-style" type="submit" @click="submitInput">
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
            inputValues: Array(this.correctAnswer[0].length).fill(''), // Array based on the length of correct answer
            submitted: false, // Flag to track submission status
            answeredCorrectly: false, // Flag to track if the user's answer is correct or not
        };
    },
    mounted() {
    document.addEventListener('keydown', this.handleKeyPress);
  },
  beforeUnmount() {
    document.removeEventListener('keydown', this.handleKeyPress);
  },
    methods: {
        onInputChange(index, event) {
            const value = event.target.value;
            if (value.length > 1) {
                this.inputValues[index] = value.slice(0, 1);
            }
            if (index < this.inputValues.length - 1 && value.length === 1) {
                const nextInput = this.$refs['input-' + (index + 1)];
                if (nextInput) {
                    nextInput[0].focus();
                }
            }
        },
        onKeyDown(index, event) {
            if (event.keyCode === 8 && index > 0 && this.inputValues[index] === '') {
                // Handle the delete key (backspace)
                const previousInput = this.$refs['input-' + (index - 1)];
                if (previousInput && previousInput[0] instanceof HTMLInputElement) {
                    this.inputValues[index - 1] = ''; // Clear the value of the previous input field
                    previousInput[0].focus();
                }
            } else if (event.keyCode === 46 && this.inputValues[index] === '') {
                // Handle the delete key (delete)
                const nextInput = this.$refs['input-' + (index + 1)];
                if (nextInput && nextInput[0] instanceof HTMLInputElement) {
                    this.inputValues[index] = ''; // Clear the value of the current input field
                    nextInput[0].focus();
                }
            }
        },
        handleKeyPress(event) {
      if (!this.submitted && event.key === 'Enter') {
        this.submitInput();
      }
    },

        submitInput() {
            this.submitted = true;
            const combinedText = this.inputValues.join('');
            this.answeredCorrectly = this.checkAnswer(combinedText);
            this.$emit('returnValues', {
                submitedAns: combinedText,
                answeredCorrectly: this.answeredCorrectly
            }
            ); // Emit event with combined text
        },
        checkAnswer(combinedText) {
            return (combinedText !== null) && 
            (combinedText.toUpperCase() === this.correctAnswer[0].toUpperCase());
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
.text-input-container {
    background-color: whitesmoke;
    padding: 20px;
    border-radius: 10px;
    width: 80%;
    margin: 10px auto;
}

.text-input-div {
    display: flex;
    justify-content: space-evenly;
    flex-wrap: wrap;
}

.text-input {
    width: 45px;
    margin: 5px;
    padding: 5px;
    text-align: center;
    border: 3px solid #0072FF;
    border-radius: 5px;
    background-color: #00C6FF;
    font-size: 20px;
}

.text-input-correct {
    border: 3px solid #000;
    background: #76C893;
    pointer-events: none;
    /* Disable further input */
}

.text-input-incorrect {
    border: 3px solid #000;
    background: #AC4D58;
    pointer-events: none;
    /* Disable further input */
}
</style>
