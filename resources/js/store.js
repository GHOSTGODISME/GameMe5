import { defineStore } from 'pinia';
import { createPinia } from 'pinia';

export const useQuizStore = defineStore('quiz', {
  state: () => ({
    currentQuestionIndex: 0,
    questions: [],
    userResponses: {},
    correctness: {},
    userRank: null,
    questionTimes: {},
    navigationHistory: [],
    questionPoints: 0,
    totalPoints: 0,

    quizTitle: '',
    quizState: 'notStarted',
    quizTimer: 0,
    quizQuestions: [],

    sessionCode: '',
    username: '',
    userId: '',
  }),
  actions: {
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
    },
    storeQuestionTime(questionId, timeTaken) {
      this.questionTimes = {
        ...this.questionTimes,
        [questionId]: timeTaken,
      };
    },
    storeQuestionPoints(questionId) {
      const question = this.questions.find(question => question.id === questionId);
      this.questionTimes = {
        ...this.questionTimes,
        [questionId]: question.points,
      };
      this.setTotalQuizPoints(this.totalPoints + question.points);
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
    },
    setSessionCode(sessionCode) {
      this.sessionCode = sessionCode;
    },
    setTotalQuizPoints(totalPoints) {
      this.totalQuizPoints = totalPoints;
    },
    setQuestionPoints(state, { questionId, points }) {
      this.questionPoints[questionId] = points;
    },
    setUserRank(rank) {
      this.userRank = rank;
    },
    addToNavigationHistory(questionId) {
      state.navigationHistory.push(questionId);
    },
    removeFromNavigationHistory() {
      state.navigationHistory.pop();
    },
    setQuizQuestions(questions) {
      this.quizQuestions = questions;
    },

    

    calculateAndSetRank({ state, commit }, userScore) {
      const otherParticipantScores = [/* Array of scores of other participants */];
      otherParticipantScores.push(userScore);
      otherParticipantScores.sort((a, b) => b - a); // Sort scores in descending order
      const userRank = otherParticipantScores.indexOf(userScore) + 1; // Find the user's rank
      this.setUserRank(userRank);
    },
    setQuestionTime(state, { questionId, timeTaken }) {
      this.questionTimes[questionId] = timeTaken;
      console.log(questionTimes);
    },
    recordQuestionTime({ setQuestionTime }, { questionId, timeTaken }) {
      setQuestionTime({ questionId, timeTaken });
    },
    
    navigateForward({ commit, state }, questionId) {
      commit('addToNavigationHistory', state.currentQuestionIndex);
      commit('setCurrentQuestionIndex', questionId);
    },
    navigateBackward({ commit, state }) {
      commit('removeFromNavigationHistory');
      const previousQuestionId = state.navigationHistory.pop();
      commit('setCurrentQuestionIndex', previousQuestionId);
    },
    navigateToNextQuestion() {
      const nextQuestionId = this.questions[this.currentQuestionIndex + 1]?.id;
      if (nextQuestionId) {
        this.navigateForward(nextQuestionId);
      } else {
        this.setQuizState('finished');
        // Additional logic when the quiz is finished
      }
    },
    navigateToPreviousQuestion() {
      const prevQuestionId = this.navigationHistory[this.navigationHistory.length - 1];
      if (prevQuestionId) {
        this.navigateBackward(prevQuestionId);
      }
    },
    // async fetchQuizDetails(code) {
    //   try {
    //     const response = await fetch(`/quiz/details/${code}`);
    //     const details = await response.json();
    //     this.setQuizTitle(details.title);
    //     console.log("this.userTitle " + this.userTitle);
    //   } catch (error) {
    //     console.error('Failed to fetch quiz details:', error);
    //   }
    // },
    async fetchQuizDetails() {
      try {
        const response = await fetch(`/quiz/details/${this.sessionCode}`);
        const details = await response.json();
    
        console.log('Fetched details:', details);
    
        if (details && details.title) {
          this.setQuizTitle(details.title); // Update quizTitle using setQuizTitle action
          console.log('Updated quizTitle:', this.quizTitle);
        } else {
          console.error('Quiz details or title is empty.');
        }
      } catch (error) {
        console.error('Failed to fetch quiz details:', error);
      }
    },
    
    async fetchQuizQuestions() {
      try {
        const response = await fetch(`/quiz/questions/${this.sessionCode}`);
        const questions = await response.json();
        this.setQuestions(questions);
        console.log('Fetched questions:', this.questions);
            } catch (error) {
              console.error('Failed to fetch questions:', error);
                  }
    },
    startQuiz() {
      this.setQuizState('started');
      this.setQuizTimer(0);
      this.fetchQuizDetails(123);
    },
  },
  getters: {
    // Define getters to access state
    // You can define getters to access and derive state variables here
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