<template>
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


<style>

</style>