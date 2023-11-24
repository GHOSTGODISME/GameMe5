<template>
        <div id="summary-container">
        <div id="summary-general-container">
            <h2>Summary</h2>
            <p id="quiz-username">Chloe Lee</p>

            <div class="summary-container-row">
                <span>Rank</span>
                <span id="quiz-rank">1/20</span>
            </div>
            <div class="summary-container-row">
                <span>Score</span>
                <span id="quiz-score">2100</span>
            </div>
            <div class="summary-container-row">
                <span>Accuracy</span>
                <span id="quiz-accuracy">88%</span>
            </div>

            <div class="summary-color-block">
                <div class="summary-container-block" style="background: #76C893;">
                    <p class="">Correct</p>
                    <p id="quiz-correct">1</p>
                </div>
                <div class="summary-container-block" style="background: #D05252;">
                    <p class="">Incorrect</p>
                    <p id="quiz-incorrect">1</p>
                </div>

                <div class="summary-container-block" style="background: #168AAD;">
                    <p class="">Avg Time</p>
                    <p id="quiz-avg-time">1</p>
                    <span>s</span>
                </div>
            </div>

            <div style="display: flex; justify-content: space-evenly; flex-wrap: wrap;align-items: center;">
                <div class="submit-button-container">
                    <button id="play-again-button" class="btn btn-primary button-style">Play again</button>
                </div>
    
                <div class="submit-button-container">
                    <button id="find-new-quiz-button" class="btn btn-primary button-style">Find new quiz</button>
                </div>
            </div>

        </div>

        <div id="review-question-container">
            <p class="review-question-title">Review Questions</p>

            <div class="review-question-container-single">
                <div id="question-title-details" class="container-style incorrect-ans-title-bg">
                    1. How much is 2 + 3 equals to?
                </div>
                <div id="question-option-details" class="container-style incorrect-ans-options-bg">
                    <p class="radio-text"><i class="fas fa-circle radio-icon checked incorrect"></i> 3 <span
                            class="review-answer incorrect-ans"> Your Answer</span></p>
                    <p class="radio-text"><i class="fas fa-circle radio-icon default"></i> 4 </p>
                    <p class="radio-text"><i class="fas fa-circle radio-icon checked correct"></i> 5 <span
                            class="review-answer correct-ans"> Correct Answer</span></p>
                </div>
            </div>


            <div class="review-question-container-single">
                <div id="question-title-details" class="container-style correct-ans-title-bg">
                    1. How much is 2 + 3 equals to?
                </div>
                <div id="question-option-details" class="container-style correct-ans-options-bg">
                    <p ><i class="fas fa-check-square checkbox-icon checked correct"></i> 3 <span
                            class="review-answer correct-ans"> Your Answer</span></p>
                            <p ><i class="fas fa-square checkbox-icon default"></i> 4 </p>
                            <p ><i class="fas fa-square checkbox-icon checked incorrect"></i> 4 </p>
                        </div>
            </div>

            <div class="review-question-container-single">
                <div id="question-title-details" class="container-style correct-ans-title-bg">
                    1. How much is 2 + 3 equals to?
                </div>
                <div id="question-option-details" class="container-style correct-ans-options-bg">
                    <p>random text input <span class="review-answer correct-ans"> Your Answer</span></p>

                    <!-- if incorrect answer answer -->
                    <p>random text input <span class="review-answer incorrect-ans"> Your Answer</span></p>

                    <hr>
                    <span class="correct-ans">Correct Answer: </span>
                    <p>Random correct answer</p>
                </div>
            </div>
        </div>

        <div class="horizontal-line-with-text">
                <span> You have reach to the end of the summary </span>
            </div>


    </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function () {
            // Get all radio buttons and their respective spans
            const radioButtons = document.querySelectorAll('input[type="radio"]');
            const spans = document.querySelectorAll('.review-answer');
            // Loop through each span
            spans.forEach((span, index) => {
                // Check if the span contains the 'incorrect-ans' class
                if (span.classList.contains('incorrect-ans')) {
                    // Apply the 'incorrect' class to the radio button's parent element
                    radioButtons[index].parentNode.classList.add('incorrect');
                    radioButtons[index].classList.add("incorrect");
                }
                // Check if the span contains the 'correct-ans' class
                if (span.classList.contains('correct-ans')) {
                    // Apply the 'correct' class to the radio button's parent element
                    radioButtons[index].parentNode.classList.add('correct');
                    radioButtons[index].classList.add("correct");
                }
            });
        });
</script>