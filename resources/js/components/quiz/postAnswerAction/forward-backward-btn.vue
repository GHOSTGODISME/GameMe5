<template>
<div id="nextPreviousbtn-container">
            <button id="quiz-previous-btn"><i class="fa-solid fa-angle-left"></i></button>
            <button id="quiz-next-btn"><i class="fa-solid fa-angle-right"></i></button>
        </div>
</template>

<script>
export default {
    };
</script>


<style scoped>
#nextPreviousbtn-container {
    display: flex;
    justify-content: flex-end;
    margin-right: 20px;
}

#quiz-previous-btn:hover,
#quiz-next-btn:hover {
    background: #55677B;
    cursor: pointer;
}

.previous-next-btn-disable{
    background: #55677B;
    pointer-events: none;
}
</style>