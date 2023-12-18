import { defineStore } from 'pinia';
import { useLocalStorage } from "@vueuse/core"


export const useQuizStore = defineStore('quiz', {
  state: () => ({
    currentQuestionIndex: useLocalStorage('quiz:currentQuestionIndex', 0),
    questions: useLocalStorage('quiz:questions', []),
    userResponses: useLocalStorage('quiz:userResponses', {}),

    correctness: useLocalStorage('quiz:correctness', {}),
    questionTimes: useLocalStorage('quiz:questionTimes', {}),
    questionPoints: useLocalStorage('quiz:questionPoints', {}),

    userRank: useLocalStorage('quiz:userRank', null),
    totalPoints: useLocalStorage('quiz:totalPoints', 0),

    quizTitle: useLocalStorage('quiz:quizTitle', ''),
    quizState: useLocalStorage('quiz:quizState', 'notStarted'),
    quizTimer: useLocalStorage('quiz:quizTimer', 0),
    quizTotalQuestion: useLocalStorage('quiz:quizTotalQuestion', 0),

    sessionCode: useLocalStorage('quiz:sessionCode', ''),
    username: useLocalStorage('quiz:username', ''),

    userId: useLocalStorage('quiz:userId', 0),
    sessionId: useLocalStorage('quiz:sessionId', 0),
    quizId: useLocalStorage('quiz:quizId', 0),

    quizAccuracy: useLocalStorage('quiz:quizAccuracy', 0),
    correctAnswersCount: useLocalStorage('quiz:correctAnswersCount', 0),
    incorrectAnswersCount: useLocalStorage('quiz:incorrectAnswersCount', 0),
    averageTime: useLocalStorage('quiz:averageTime', 0),

    showLeaderboardFlag: useLocalStorage('quiz:showLeaderboardFlag', 0),
    shuffleOptionFlag: useLocalStorage('quiz:shuffleOptionFlag', 0),
  }),
  actions: {
    clearPinialocalStorage() {
      const piniaKeys = Object.keys(localStorage).filter((key) => key.startsWith('quiz:'));
      piniaKeys.forEach((key) => {
        if (key in localStorage) {
          localStorage.removeItem(key);
        }
      });

      this.resetLocalStorageVariablesToDefault();
    },
    resetLocalStorageVariablesToDefault() {
      this.currentQuestionIndex = 0;
      this.questions = [];
      this.userResponses = {};
      this.correctness = {};
      this.questionTimes = {};
      this.questionPoints = {};
      this.userRank = null;
      this.totalPoints = 0;
      this.quizTitle = '';
      this.quizState = 'notStarted';
      this.quizTimer = 0;
      this.quizTotalQuestion = 0;
      this.sessionCode = '';
      this.username = '';
      this.userId = 0;
      this.sessionId = 0;
      this.quizId = 0;
      this.quizAccuracy = 0;
      this.correctAnswersCount = 0;
      this.incorrectAnswersCount = 0;
      this.averageTime = 0;
      this.showLeaderboardFlag = 0;
      this.shuffleOptionFlag = 0;
    },
    setCurrentQuestionIndex(index) {
      this.currentQuestionIndex = index;
    },
    setQuestions(questions) {
      this.questions = questions;
    },
    storeQuizResponse(questionId, response) {
      this.userResponses = {
        ...this.userResponses,
        [questionId]: response,
      };
    },
    storeCorrectness(questionId, isCorrect) {
      this.correctness = {
        ...this.correctness,
        [questionId]: isCorrect,
      };
      if (isCorrect) {
        this.incrementCorrectAnswersCount();
      } else {
        this.incrementIncorrectAnswersCount();
      }
    },
    storeQuestionTime(questionId, timeTaken) {
      this.questionTimes = {
        ...this.questionTimes,
        [questionId]: timeTaken,
      };
    },
    storeQuestionPoints(questionId, answeredCorrectly) {
      const question = this.questions.find(question => question.id === questionId);

      this.questionPoints = {
        ...this.questionPoints,
        [questionId]: question.points,
      };


      if (answeredCorrectly) {
        const points = parseInt(question.points);
        const totalPoints = parseInt(this.totalPoints);
        const sum = totalPoints + points;

        this.setTotalPoints(sum);
      }
    },
    setQuizState(newState) {
      this.quizState = newState;
    },
    setQuizTimer(timer) {
      this.quizTimer = timer;
    },
    setQuizTitle(title) {
      this.quizTitle = title;
    },
    setUsername(username) {
      this.username = username;
      // this.$onAction({ type: 'setUsername', payload: username });
    },
    setSessionCode(sessionCode) {
      this.sessionCode = sessionCode;
    },
    setTotalPoints(totalPoints) {
      this.totalPoints = totalPoints;
    },
    setQuestionPoints(state, { questionId, points }) {
      this.questionPoints[questionId] = points;
    },
    setUserRank(rank) {
      this.userRank = rank;
    },

    setQuizQuestions(questions) {
      this.quizQuestions = questions;
    },
    incrementCorrectAnswersCount() {
      this.correctAnswersCount++;
    },
    incrementIncorrectAnswersCount() {
      this.incorrectAnswersCount++;
    },
    setQuestionTime(state, { questionId, timeTaken }) {
      this.questionTimes[questionId] = timeTaken;
    },
    recordQuestionTime({ setQuestionTime }, { questionId, timeTaken }) {
      setQuestionTime({ questionId, timeTaken });
    },
    updateUserRank(leaderboard) {
      const userIndex = leaderboard.findIndex((player) => player.id === this.userId);
      if (userIndex !== -1) {
        const userRank = userIndex + 1;
        this.userRank = userRank;
      } else {
        this.userRank = null;
      }
    },
    async fetchSessionSettings() {
      try {
        const response = await fetch(`/quiz/settings/${this.sessionId}`);
        const details = await response.json();
        this.showLeaderboardFlag = details.sessionSettings.show_leaderboard_flag;
        this.shuffleOptionFlag = details.sessionSettings.shuffle_option_flag;
      } catch (error) {
        console.error('Failed to fetch session settings:', error);
      }
    },
    async fetchQuizDetails() {
      try {
        const response = await fetch(`/quiz/details/${this.sessionCode}`);
        const details = await response.json();

        if (details && details.quiz.title) {
          this.setQuizTitle(details.quiz.title); // Update quizTitle using setQuizTitle action
          this.quizId = details.quiz.id;
          this.sessionId = details.session_id;
        } else {
          console.error('Quiz details or title is empty.');
        }
      } catch (error) {
        console.error('Failed to fetch quiz details:', error);
      }
    },
    async fetchQuizQuestions() {
      try {
        const response = await fetch(`/quiz/questions/${this.quizId}`);
        const questions = await response.json();
        this.setQuestions(questions);
        this.quizTotalQuestion = questions.length;
      } catch (error) {
        console.error('Failed to fetch questions:', error);
      }
    },
    calculateQuizAccuracy() {
      const totalQuestions = Object.keys(this.correctness).length;
      if (totalQuestions === 0) {
        this.quizAccuracy = 0;
        return;
      }

      const correctAnswers = Object.values(this.correctness).filter(isCorrect => isCorrect).length;
      this.correctAnswersCount = correctAnswers;
      this.incorrectAnswersCount = totalQuestions - correctAnswers;

      this.quizAccuracy = (correctAnswers / totalQuestions) * 100;
    },

    calculateAverageTime() {
      const totalQuestions = Object.keys(this.questionTimes).length;
      if (totalQuestions === 0) {
        this.averageTime = 0;
        return;
      }

      const totalTime = Object.values(this.questionTimes).reduce((acc, time) => acc + time, 0);
      this.totalQuestionTime = totalTime;
      this.averageTime = totalTime / totalQuestions;
    },
    startQuiz() {
      this.setQuizState('started');
      this.setQuizTimer(0);
      this.fetchQuizDetails(123);
    },
    async storeIndividualResponse(payload) {
      try {
        const response = await fetch('/api/store-individual-response', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(payload),
        });

        if (!response.ok) {
          throw new Error('Failed to store individual response');
        }

        const responseData = await response.json();
        // Handle successful response from the backend if needed
        console.log('Response from backend:', responseData);
      } catch (error) {
        console.error('Error storing individual response:', error);
        // Handle error
      }
    },
    setRandomUserId() {
      // Generate a random user ID between 1 and 1000 (for example)
      const randomUserId = Math.floor(Math.random() * 1000) + 1;
      this.userId = randomUserId;
    },
    setUserId(id) {
      this.userId = id;
    },
    resetStore() {
      this.$reset();
    },
    shuffle(array) {
      for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
      }
    },
  },
  mutation: {

  },
  getters: {
    getQuizAccuracy() {
      this.calculateQuizAccuracy();
      return this.quizAccuracy.toFixed(1); // Display accuracy up to 2 decimals
    },

    getAverageTime() {
      this.calculateAverageTime();
      return this.averageTime.toFixed(1); // Display average time up to 2 decimals
    },


    getQuizTitle() {
      return this.quizTitle;
    },

    getUsername() {
      return this.username;
    }
  },
});


// {
// title: 'Question title',
// type: 0, // Use 0, 1, 2 to represent MCQ, True/False, TextInput
// options: ['Option A', 'Option B', 'Option C', 'Option D'], // Array of options for MCQ or True/False
// correctAnswer: ['Option A', 'Option C'], // Array to store correct answers (useful for multiple correct answers)
// explanation: 'Answer explanation', // Nullable
// singleAnswerFlag: true, // Nullable, used for TextInput type to indicate single answer
// points: 10, // Points allocated to the question
// duration: 30, // Duration in seconds for answering the question
// }


// answer_explanation: "[]"
// ​​correct_ans: Array [ "True" ]
// ​​​created_at: "2023-11-21T15:22:56.000000Z"
// ​​​duration: 10
// ​​​id: 1
// ​​​index: "0"
// ​​​options: Array [ "True", "False" ]
// ​​​points: 15
// ​​​quiz_id: 1
// ​​​single_ans_flag: 1
// ​​​title: "Ut nobis voluptatem suscipit deleniti debitis facere."
// ​​​type: "1"
// ​​​updated_at: "2023-11-21T15:53:15.000000Z"