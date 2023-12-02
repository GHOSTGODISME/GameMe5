// Import required modules using ES6 syntax
import express from 'express';
import http from 'http';
import { Server } from 'socket.io';
import cors from 'cors';

const app = express();
const server = http.createServer(app);
const port = process.env.PORT || 3000;
const io = new Server(server, {
  cors: { origin: "*" }
});

// Use CORS middleware
app.use(cors());

// to store session's data in object
const sessions = {};
const interactiveSessions = {};

function initializeSessionData(sessionCode) {
  sessions[sessionCode] = {
    participants: [],
    leaderboard: [],
    totalParticipants: 0,
    sessionStatus: 'waiting',
  }
}

function initializeInteractiveSessionData(sessionCode) {
  interactiveSessions[sessionCode] = {
    participants: [],
    messages: [],
    votes: {},
    sessionStatus: '',
  }
}

function initializePollVotes(sessionCode, pollId, options) {
  const interactiveSession = interactiveSessions[sessionCode];

  interactiveSession.votes[pollId] = {};
  options.forEach((option) => {
    interactiveSession.votes[pollId][option] = 0; // Initialize votes for each option to 0
  });
}

function voteForPollOption(sessionCode, pollId, optionSelected) {
  const interactiveSession = interactiveSessions[sessionCode];

  if ( interactiveSession&& interactiveSession.votes[pollId]) {
    console.log("pass1");
    if (interactiveSession.votes[pollId][optionSelected] !== undefined) {
    console.log("pass2");
      
      interactiveSession.votes[pollId][optionSelected]++;
      io.to(sessionCode).emit('pollVoteReceived', {pollId,
        optionSelected,
        votes: interactiveSession.votes[pollId],
      });
    }
    console.log(interactiveSession.votes);

  }
}


function updateSessionStatus(status, sessionCode) {
  sessions[sessionCode].sessionStatus = status;
  io.to(sessionCode).emit('session status', sessions[sessionCode].sessionStatus);
}

function addLeaderboardEntry(participant, sessionCode) {
  sessions[sessionCode].leaderboard[participant.id] = {
    id: participant.id,
    username: participant.username,
    score: 0,
  };
}

function updateLeaderboardEntry(userId, newScore, sessionCode) {
  const leaderboard = sessions[sessionCode].leaderboard;
  if (leaderboard[userId]) {
    leaderboard[userId].score = newScore;
    const sortedLeaderboard = Object.values(leaderboard).sort((a, b) => b.score - a.score);
    io.to(sessionCode).emit('update leaderboard', sortedLeaderboard);
  }
}

// Function to initialize the leaderboard with participants
function initializeLeaderboard(sessionCode) {
  const participants = sessions[sessionCode].participants;
  const leaderboard = sessions[sessionCode].leaderboard;

  if (Object.keys(leaderboard).length === 0) {
    participants.forEach((participant) => {
      if (!leaderboard[participant.id]) {
        leaderboard[participant.id] = {
          id: participant.id,
          username: participant.username,
          score: 0,
        };
      }
    });
  }
  io.to(sessionCode).emit('update leaderboard', Object.values(leaderboard));
}

app.get('/', (req, res) => {
  res.send('<h1>Hello world</h1>');
});

io.on('connection', (socket) => {
  console.log('A user connected');

  handleJoinEvents(socket);
  handleScoreUpdates(socket);
  handleSessionEvents(socket);
  handleQuizEvents(socket);
  handleLeaderboardEvents(socket);
  handleDisconnect(socket);
  handleUserResponse(socket);

  handleSession(socket);
  handleInteractiveSession(socket)
});

function handleSession(socket) {
  socket.on('createSession', (sessionCode) => {
    console.log(sessionCode);
    initializeSessionData(sessionCode);
    initializeConnection(sessionCode);
    console.log("session created for " + sessionCode);
    io.to(socket.id).emit('session created');
  });

  socket.on('joinSession', (sessionCode) => {
    console.log(sessionCode);
    if (sessions[sessionCode]) {
      const leaderboard = sessions[sessionCode].leaderboard;

      socket.join(sessionCode); // Participant joins the room with session code
      console.log("joined " + sessionCode);
      socket.to(sessionCode).emit("get leaderboard");
      io.to(sessionCode).emit('initial leaderboard', Object.values(leaderboard));

    }
  });

  socket.on('rejoinRoom', (sessionCode) => {
    if (sessions[sessionCode]) {
      socket.join(sessionCode);
    }
  });

  socket.on('createInteractiveSession', (sessionCode) => {
    console.log(sessionCode + " entered");
    if (!interactiveSessions[sessionCode]) {
      console.log(sessionCode + " - interactive session created");
      initializeInteractiveSessionData(sessionCode);
      broadcastAllIS(sessionCode);
    }
    socket.join(sessionCode);
    console.log(sessionCode + " - interactive session joined");
  })

  socket.on('rejoinInteractiveSessionRoom', (sessionCode) => {
    if (interactiveSessions[sessionCode]) {
      socket.join(sessionCode);
    }
  })
}

function handleInteractiveSession(socket) {
  socket.on('sendChatMessage', (data) => {
    const { sessionCode, id, username, message } = data;
    if (interactiveSessions[sessionCode]) {
      const messages = interactiveSessions[sessionCode].messages;
      const msg = buildMsg(id, username, message);
      console.log(msg);
      messages.push(msg);

      io.to(sessionCode).emit('chatMessageReceived', msg);
    }
  });

  socket.on('createPoll', (data) => {
    console.log("triggered createPolls");
    const { pollId, sessionCode, pollTitle, options } = data;
    console.log(data);
    if (interactiveSessions[sessionCode]) {
      console.log(data);
      io.to(sessionCode).emit('newPollCreated', { pollId, pollTitle, options });
      initializePollVotes(sessionCode, pollId, options);
    }
  });

  socket.on('voteForPoll', (data) => {
    const { sessionCode, pollId, optionSelected, userId } = data;
    console.log(data);
    if (interactiveSessions[sessionCode]) {
      voteForPollOption(sessionCode, pollId, optionSelected);
      // io.to(sessionCode).emit('pollVoteReceived', { pollId, optionSelected, userId });
    }
  });

  socket.on('exportChatMessage', (sessionCode)=>{
    if (interactiveSessions[sessionCode]) {
      const messages = interactiveSessions[sessionCode].messages;
      io.to(sessionCode).emit('returnChatMessage', messages);
    }
  })
}

function buildMsg(id, username, message) {
  return {
    id,
    username,
    message,
    time: new Intl.DateTimeFormat('default', {
      day: 'numeric',
      month: 'numeric',
      year: 'numeric',
      hour: 'numeric',
      minute: 'numeric',
      second: 'numeric'
    }).format(new Date())
  }
}

function initializeConnection(sessionCode) {
  const participants = sessions[sessionCode].participants;
  const leaderboard = sessions[sessionCode].leaderboard;
  const sessionStatus = sessions[sessionCode].sessionStatus;

  io.to(sessionCode).emit('initial participants', participants);
  io.to(sessionCode).emit('initial leaderboard', Object.values(leaderboard));
  io.to(sessionCode).emit('session status', sessionStatus);
}

function broadcastAllIS(sessionCode) {
  const participants = interactiveSessions[sessionCode].participants;

  io.to(sessionCode).emit('is-participants-length', participants.length);
}

function handleJoinEvents(socket) {
  socket.on('join', (data) => {
    const { sessionCode, id, username } = data;

    if (sessions[sessionCode]) {
      const participants = sessions[sessionCode].participants;
      const leaderboard = sessions[sessionCode].leaderboard;

      //sessions[sessionCode].add(socket.id); // Add participant to the room
      socket.join(sessionCode);

      console.log(sessionCode + 'adding participants');

      const existingUser = participants.find((participant) => participant.id === id);

      if (!existingUser) {
        participants.push({ id, username });
        addLeaderboardEntry({ id, username }, sessionCode);

        io.to(sessionCode).emit('participant joined', { id, username });
        io.to(sessionCode).emit('update leaderboard', Object.values(leaderboard));
        io.to(sessionCode).emit('initial participants', participants);
      }

      console.log("start " + sessionCode);
      console.log(participants);
      console.log(leaderboard);
      console.log("end " + sessionCode);


    }
  });

  socket.on('endInteractiveSession', (sessionCode) => {
    if (interactiveSessions[sessionCode]) {
      delete interactiveSessions[sessionCode];
    }
  });

  socket.on('joinInteractiveSession', (data) => {
    const { sessionCode, id, username } = data;
    console.log("sessionCode " + sessionCode);
    console.log("sessions " + sessions);
    console.log(sessions);
    if (interactiveSessions[sessionCode]) {
      const participants = interactiveSessions[sessionCode].participants;

      socket.join(sessionCode);

      const existingUser = participants.find((participant) => participant.id === id);

      if (!existingUser) {
        participants.push({ id, username });
        broadcastAllIS(sessionCode);
      }

      console.log("start " + sessionCode);
      console.log(participants);
      console.log("end " + sessionCode);
      


    } else {
      console.log("not joined");
    }
  });
}

function handleSessionEvents(socket) {
  socket.on('startSession', (sessionCode) => {
    if (sessions[sessionCode]) {
      updateSessionStatus('running', sessionCode);
      initializeLeaderboard(sessionCode);
      io.to(sessionCode).emit('session status', sessionStatus);

    }
  });

  socket.on('endSession', (sessionCode) => {
    if (sessions[sessionCode]) {
      delete sessions[sessionCode];
    }
  });

  socket.on('get status', (sessionCode) => {
    if (sessions[sessionCode]) {
      const sessionStatus = sessions[sessionCode].sessionStatus;
      console.log("get status");
      console.log(sessionStatus);
      io.to(sessionCode).emit('session status', sessionStatus);
    }
  });
}

function handleScoreUpdates(socket) {
  socket.on('update score', (data) => {
    const { sessionCode, userId, newScore } = data;

    if (sessions[sessionCode]) {
      console.log('updating score');
      updateLeaderboardEntry(userId, newScore, sessionCode);
    }
  });
}

function handleQuizEvents(socket) {
  socket.on('startQuiz', (sessionCode) => {
    if (sessions[sessionCode]) {
      io.to(sessionCode).emit('quizStartSignal');
    }
  });
}

function handleUserResponse(socket) {
  socket.on('userData', (data) => {
    const { sessionCode, userData } = data;
    if (sessions[sessionCode]) {
      console.log("received");
      console.log(userData);
      io.to(sessionCode).emit('updateResponse', userData);
    }
  });
}

function handleLeaderboardEvents(socket) {
  socket.on('get leaderboard', (sessionCode) => {
    if (sessions[sessionCode]) {
      const leaderboard = sessions[sessionCode].leaderboard;
      io.to(sessionCode).emit('update leaderboard', Object.values(leaderboard));
    }
  });
}

function handleDisconnect(socket) {
  socket.on('disconnect', () => {
    console.log('A user disconnected');
    // Remove the participant from the list
    let sessionCodes = Object.keys(sessions);
    sessionCodes.forEach((sessionCode) => {
      const participants = sessions[sessionCode].participants;
      sessions[sessionCode].participants = participants.filter((participant) => participant.id !== socket.id);
      const leaderboard = sessions[sessionCode].leaderboard;
      delete leaderboard[socket.id]; // Remove the participant from the leaderboard
      io.to(sessionCode).emit('participant left', socket.id);
      io.to(sessionCode).emit('update leaderboard', Object.values(leaderboard));
    });

    // Check if the user is in any interactive session
    sessionCodes = Object.keys(interactiveSessions);
    sessionCodes.forEach((sessionCode) => {
      const participants = interactiveSessions[sessionCode].participants;
      interactiveSessions[sessionCode].participants = participants.filter((participant) => participant.id !== socket.id);
      io.to(sessionCode).emit('participant left', socket.id);
      broadcastAllIS(sessionCode);
    });
  });
}


server.listen(port, () => {
  console.log(`Server is running on port ${port}`);
});
