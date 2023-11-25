// server.mjs (or rename your file to use `.mjs` extension)

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

let participants = []; // Array to store participants
let leaderboard = []; // Array to store leaderboard details
let totalParticipants = 0;

// Function to update the leaderboard
const updateLeaderboard = () => {
  leaderboard = {};
  participants.forEach((participant) => {
    leaderboard[participant.id] = {
      id: participant.id,
      username: participant.username,
      score: 0,
    };
  });
};

app.get('/', (req, res) => {
  res.send('<h1>Hello world</h1>');
});

io.on('connection', (socket) => {
  console.log('A user connected');

  // Send initial list of participants to the new client
  io.to(socket.id).emit('initial participants', participants);
  io.to(socket.id).emit('initial leaderboard', Object.values(leaderboard));


  socket.on('join', (userData) => {
    totalParticipants++;
    console.log('Total Participants:', totalParticipants);

    const { id, username } = userData;
    const existingUser = participants.find((participant) => participant.id === id);

    if (existingUser) {
      existingUser.username = username;
    } else {
      participants.push({ id, username });
    }

    updateLeaderboard();
    io.emit('participant joined', { id, username });
    io.emit('get leaderboard', Object.values(leaderboard));


    io.to(socket.id).emit('initial participants', participants);
    io.emit('total participants', totalParticipants);
  });

  // Handle updating scores
  socket.on('update score', (userId, newScore) => {
    console.log('updating score');
    if (leaderboard[userId]) {
      leaderboard[userId].score = newScore;
      const sortedLeaderboard = Object.values(leaderboard).sort((a, b) => b.score - a.score);
      io.emit('update leaderboard', sortedLeaderboard);
      leaderboard = sortedLeaderboard;
      console.log('Updated Leaderboard:', sortedLeaderboard); // Log the updated leaderboard
    }
  });

  // New event to add participant from the client-side
  socket.on('add participant', (userData) => {
    console.log('adding participants');
    const { id, username } = userData;
    const existingUser = participants.find((participant) => participant.id === id);

    if (!existingUser) {
      participants.push({ id, username });
      updateLeaderboard();
      io.emit('participant joined', { id, username });
      io.emit('update leaderboard', Object.values(leaderboard));
    }
  });

  socket.on('startQuiz', () => {
    // When the 'startQuiz' event is received from a client,
    // Emit the 'quizStartSignal' event to all connected clients
    io.emit('quizStartSignal');
  });


  socket.on('get leaderboard', () => {
    console.log('getting leaderboard');
    io.to(socket.id).emit('update leaderboard', Object.values(leaderboard));
  });

  socket.on('disconnect', () => {
    console.log('A user disconnected');
    console.log('Total Participants:', totalParticipants);
    totalParticipants--;
    participants = participants.filter((participant) => participant.id !== socket.id);
    updateLeaderboard();
    io.emit('participant left', socket.id);
    io.emit('update leaderboard', Object.values(leaderboard));
  });
});

server.listen(port, () => {
  console.log(`Server is running on port ${port}`);
});
