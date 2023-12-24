<template>
    <div class="header-container">
        <img src="img/logo_header.png" alt="Logo" />
        <span class="header-quiz-title">{{ quizTitle }}</span>
    </div>
</template>

<script>
import { useQuizStore } from "./../../store.js";

export default {
    props: {
        quizTitle: String,
    },
    computed: {
        store() {
            // Compute input field style based on error condition
            return useQuizStore();
        },
    },
};
</script>