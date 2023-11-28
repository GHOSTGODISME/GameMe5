<template>
    <div>
        <QuizHeader :quizTitle="title" />

        <div class="container join-quiz-bg">
            <div v-if="!joinedQuiz" class="row join-quiz-screen">
                <div class="col-md-6 col-lg-5 p-5 join-quiz-title">
                    You have joined the "{{ title }}" Quiz!
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
                    <!-- <span v-if="showErrorMessage" class="input-fails-text">Username has been used</span> -->
                    <span v-if="emptyUserNameMsg" class="input-fails-text"
                        >Please enter a username</span
                    >
                    <p class="join-quiz-details-instruction">
                        Please enter your username and wait for the host to
                        start the game.
                    </p>

                    <div class="button-container">
                        <!-- <button class="btn btn-dark button-style" @click="validateUsername">Confirm</button> -->
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
                <p>Waiting for the host to start the quiz...</p>
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
      title: "test",
      username: "",
      joinedQuiz: false,
      emptyUserNameMsg: false,
      participantList: [],
      socket: null,
    };
  },
  created() {
    // Fetch quiz details and set necessary data
    const store = useQuizStore();
    const code = this.$route.query.code;

    store.setRandomUserId();
    store.setSessionCode(code);

    store.fetchQuizDetails().then(() => {
      this.title = store.quizTitle;
    });
  },
  mounted() {
    this.initializeSocket();
  },
  beforeDestroy() {
    // Ensure to disconnect the socket instance when the component is destroyed
    if (this.socket) {
      this.socket.disconnect();
    }
  },
  computed: {
    inputStyle() {
      // Compute input field style based on error condition
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
      this.socket = io("http://localhost:3000");

      this.socket.on("initial participants", (participants) => {
        this.participantList = participants.map(participant => participant.username);
      });

      this.socket.on("participant joined", ({ username }) => {
        this.participantList.push(username);
      });

      this.socket.on('session status', (sessionStatus) => {
        if (this.joinedQuiz) {
          this.$router.push("/quiz/quiz-loading");
        } else if (sessionStatus === "running" && this.joinedQuiz) {
          this.$router.push("/quiz/quiz-loading");
        }else if(sessionStatus === "ended"){
          alert("The session has ended. You will be redirected to the home page.");
          this.$router.push("/");
        }
      });
    },
    validateUsername() {
      if (this.username.trim() === "") {
        this.emptyUserNameMsg = true;
      } else {
        this.emptyUserNameMsg = false;
        this.joinedQuiz = true;

        const store = useQuizStore();
        store.setUsername(this.username);

        const username = store.username;
        axios.post("/api/register-name", { "username": username, "sessionId": store.sessionId, "userId": store.userId })
          .then((response) => {
            this.socket.emit('join', { sessionCode: store.sessionCode, id: store.userId, username: username });
            this.socket.emit('get status', store.sessionCode);          
          })
          .catch((error) => {
            console.error("Error joining the quiz:", error);
          });
      }
    },
  },
};
</script>

