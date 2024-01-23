<template>
    <div>
        <QuizHeader :quizTitle="title" />

        <div class="container join-quiz-bg">
            <div v-if="!joinedQuiz" class="row join-quiz-screen">
                <div class="col-md-6 col-lg-5 p-5 join-quiz-title">
                    You have joined the "{{ title }}" Quiz!
                </div>
                <div class="col-md-6 col-lg-5 join-quiz-bar">
                </div>

                <div class="col-md-6 col-lg-7 p-5 join-quiz-details">
                    <p class="join-quiz-details-username">Username</p>
                    <input
                        type="text"
                        class="form-control join-quiz-details-input"
                        :style="inputStyle"
                        v-model="username"
                        placeholder="Player's name"
                        required
                    />
                    <span v-if="emptyUserNameMsg" class="input-fails-text"
                        >Please enter a username</span
                    >
                    <p class="join-quiz-details-instruction">
                        Please enter your username and wait for the host to
                        start the game.
                    </p>

                    <div class="button-container">
                        <button
                            class="btn btn-dark button-style"
                            @click="validateUsername"
                        >
                            Confirm
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="wait-start-screen">
                <p style="font-size: 20px">
                    Waiting for the host to start the quiz...
                </p>
                <span class="joined-participants-people">{{ username }}</span>
            </div>
        </div>

        <JoinQuizJoinedParticipants :participants="participantList" />
    </div>
</template>

<script>
import { useQuizStore } from "../../../store.js";
import QuizHeader from "../quiz-header.vue";
import JoinQuizJoinedParticipants from "../join-quiz-joined-participants.vue";
import axios from "axios";

export default {
    components: {
        QuizHeader,
        JoinQuizJoinedParticipants,
    },
    data() {
        return {
            title: "",
            username: "",
            joinedQuiz: false,
            emptyUserNameMsg: false,
            participantList: [],
            socket: null,
            store: null,
        };
    },
    created() {
        this.socket = io("http://localhost:3000");
        this.store = useQuizStore();
        // this.store.clearPinialocalStorage();
        const code = this.$route.query.code.toString();
        this.store.setSessionCode(code);

        this.store.fetchQuizDetails().then(() => {
            this.title = this.store.quizTitle;
        });
        const studId = sessionStorage.getItem("stud_id");
        this.store.setUserId(studId);
        this.username = this.store.username || "";

        if (this.username.trim() !== "") {
            this.joinedQuiz = true;
        }
    },
    mounted() {
        this.initializeSocket();
    },
    beforeUnmount() {
        // Ensure to disconnect the socket instance when the component is destroyed
        if (this.socket) {
            this.socket.emit("exitRoom", this.store.sessionCode);
        }
    },
    computed: {
        inputStyle() {
            return this.emptyUserNameMsg
                ? {
                      border: "3px solid #CA0000",
                      background: "#FFEDED",
                  }
                : {};
        },
    },
    methods: {
        initializeSocket() {
            this.socket.emit(
                "getSessionParticipants",
                this.$route.query.code.toString()
            );

            this.socket.on("initial participants", (participants) => {
                if (
                    !participants.find(
                        (participant) => participant.id === this.store.userId
                    )
                ) {
                    this.clearLocalStorageWithPrefix("quiz:");
                }
                this.participantList = participants.map(
                    (participant) => participant.username
                );
            });

            this.socket.on("participant joined", ({ username }) => {
                this.participantList.push(username);
            });

            this.socket.on("session status", (sessionStatus) => {
                this.store.quizState = sessionStatus;
                if (sessionStatus === "running" && this.joinedQuiz) {
                    // this.socket.emit("exitRoom", this.store.sessionCode);
                    this.$router.push("/quiz/quiz-loading");
                } else if (sessionStatus === "ended") {
                    alert(
                        "The session has ended.\n" +
                            " You will be redirected to the home page."
                    );
                    window.location.href = "/stud_homepage";
                }
            });
        },
        checkUserQualification(userId, sessionId) {
            return new Promise((resolve, reject) => {
                axios
                    .post("/api/check-user-qualification", {
                        session_id: sessionId,
                        user_id: userId,
                    })
                    .then((response) => {
                        const hasCompletedQuiz = response.data;
                        if (hasCompletedQuiz) {
                            this.store.clearPinialocalStorage();
                            alert(
                                "You have participated in this session.\n" +
                                    " You will be redirected to the homepage."
                            );
                            window.location.href = "/stud_homepage";
                        } else {
                            resolve(false);
                        }
                    })
                    .catch((error) => {
                        console.error(
                            "Error checking user qualification:",
                            error
                        );
                        reject(error);
                    });
            });
        },

        validateUsername() {
            if (this.username.trim() === "") {
                this.emptyUserNameMsg = true;
            } else {
                this.emptyUserNameMsg = false;

                this.store.setUsername(this.username);

                axios
                    .post("/api/check-user-qualification", {
                        session_id: this.store.sessionId,
                        user_id: sessionStorage.getItem("stud_id"),
                    })
                    .then((response) => {
                        const hasCompletedQuiz = response.data;
                        if (hasCompletedQuiz) {
                            // User has already completed the quiz
                            this.store.clearPinialocalStorage();
                            alert(
                                "You have participated in this session.\n" +
                                    " You will be redirected to the homepage."
                            );
                            window.location.href = "/";
                        } else {
                            // User hasn't completed the quiz, proceed with joining
                            axios
                                .post("/api/register-name", {
                                    username: this.store.username,
                                    sessionId: this.store.sessionId,
                                    userId: this.store.userId,
                                })
                                .then((response) => {
                                    this.joinedQuiz = true;
                                    this.socket.emit("join", {
                                        sessionCode: this.store.sessionCode,
                                        id: this.store.userId,
                                        username: this.store.username,
                                    });
                                    this.socket.emit(
                                        "get status",
                                        this.store.sessionCode
                                    );
                                })
                                .catch((error) => {
                                    console.error(
                                        "Error joining the quiz:",
                                        error
                                    );
                                });
                        }
                    })
                    .catch((error) => {
                        console.error(
                            "Error checking user qualification:",
                            error
                        );
                    });
            }
        },
        clearLocalStorageWithPrefix(prefix) {
            let localStorageKeysToRemove = [];
            for (let i = 0; i < localStorage.length; i++) {
                const key = localStorage.key(i);
                if (key.startsWith(prefix)) {
                    localStorageKeysToRemove.push(key);
                }
            }

            localStorageKeysToRemove.forEach((key) => {
                localStorage.removeItem(key);
            });
        },
    },
};
</script>
