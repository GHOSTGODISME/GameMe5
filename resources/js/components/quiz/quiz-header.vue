<template>
    <div class="header-container">
        <a href="{{ url('/stud_homepage') }}"><img class="logo" src="{{ asset('img/logo_header.png') }}" alt="Logo"></a> 

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