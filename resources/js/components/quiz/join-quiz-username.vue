<template>
    <div class="container join-quiz-bg">
        <div v-if="!joinedQuiz" class="row join-quiz-screen">
            <div class="col-md-6 col-lg-5 p-5 join-quiz-title">
                You have joined the "{{ quizTitle }}" Quiz!
            </div>
            <div class="col-md-6 col-lg-7 p-5 join-quiz-details">
                <p class="join-quiz-details-username">Username</p>
                <input type="text" class="form-control join-quiz-details-input" :style="inputStyle"
                    v-model="username" placeholder="Player's name" required />
                <!-- <span v-if="showErrorMessage" class="input-fails-text">Username has been used</span> -->
                <span v-if="emptyUserNameMsg" class="input-fails-text">Please enter a username</span>
                <p class="join-quiz-details-instruction">
                    Please enter your username and wait for the host to start the game.
                </p>

                <div class="button-container">
                    <!-- <button class="btn btn-dark button-style" @click="validateUsername">Confirm</button> -->
                    <button class="btn btn-dark button-style" @click="validateUsername">Confirm</button>
                </div>

            </div>
        </div>
        <div v-else class="wait-start-screen">
            <p>Waiting for the host to start the quiz...</p>
            <span class="joined-participants-people">{{ username }}</span>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            quizTitle: String
        },
        data() {
            return {
                username: '', // Holds the entered username
                joinedQuiz: false, // Flag to determine if the user has joined the quiz
                emptyUserNameMsg: false,
            };
        },
        computed: {
            inputStyle() {
                // Compute input field style based on error condition
                return this.emptyUserNameMsg ?
                    {
                        border: '3px solid #CA0000',
                        background: '#FFEDED'
                    } :
                    {};
            }
        },
        methods: {
            validateUsername() {
                if (this.username.trim() === '') {
                    this.emptyUserNameMsg = true;
                } else {
                    this.emptyUserNameMsg = false;
                    this.joinedQuiz = true; // Set the flag to indicate user has joined the quiz

                    const store = userQuizStore();
                }
            }
        }
    };
</script>

<style>
    /* Other styles as needed */
</style>
