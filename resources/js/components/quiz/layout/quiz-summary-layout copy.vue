<template>

    <div id="summary-container">
        <div id="summary-general-container">
            <h2>Summary</h2>
            <p id="quiz-username">Chloe Lee</p>
            <QuizSummaryBlock1 
            :rank="rank"
            :numOfParticipants="numOfParticipants"
            :score="score"
            :accuracy="accuracy"
            />
            <QuizSummaryBlock2 
            :numOfCorrect="numOfCorrect"
            :numOfIncorrect="numOfIncorrect"
            :avgTime="avgTime"
            />

            <!-- <div style="display: flex; justify-content: space-evenly; flex-wrap: wrap;align-items: center;">
                <div class="submit-button-container">
                    <button id="play-again-button" class="btn btn-primary button-style">Play again</button>
                </div>

                <div class="submit-button-container">
                    <button id="find-new-quiz-button" class="btn btn-primary button-style">Find new quiz</button>
                </div>
            </div> -->

        </div>


        <QuizSummaryReviewQuestion/>

        <div class="horizontal-line-with-text">
                <span> You have reach to the end of the summary </span>
            </div>
    </div>


</template>


<script>
    import QuizSummaryBlock1 from '../quiz-summary-block1.vue';
    import QuizSummaryBlock2 from '../quiz-summary-block2.vue';
    import QuizSummaryReviewQuestion from '../quiz-summary-review-question.vue';

    export default {
        components: {
            QuizSummaryBlock1,
            QuizSummaryBlock2,
            QuizSummaryReviewQuestion
        },
        data() {
            return {
                /// block1
                rank: 1,
                numOfParticipants: 20,
                score: 20,
                accuracy: 100,
                /// block2
                numOfCorrect: 4,
                numOfIncorrect: 5,
                avgTime:7.5,
                /// reviewquestion
            }
        }

    }
</script>


<style>

</style>
