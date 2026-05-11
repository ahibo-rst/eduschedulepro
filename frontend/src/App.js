import React, { useState } from 'react';
import './App.css';
import Dashboard from './components/Dashboard';

function App() {
  const [isLoggedIn, setIsLoggedIn] = useState(false);
  const [user, setUser] = useState(null);
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');

  const handleLogin = async (e) => {
  e.preventDefault();

  try {
    const response = await fetch("http://localhost/eduschedulepro/backend/api/login.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        email: email,
        password: password,
      }),
    });

    const data = await response.json();

    if (data.success) {
      alert("Connexion réussie");
      setIsLoggedIn(true);
    } else {
      setError(data.message);
    }
  } catch (error) {
    console.error(error);
    setError("Erreur de connexion au serveur");
  }
};

  if (isLoggedIn) {
    return <Dashboard user={user} onLogout={() => setIsLoggedIn(false)} />;
  }

  return (
    <div className="login-container">
      <h1>EduSchedulePro</h1>
      <form onSubmit={handleLogin}>
        <input
          type="email"
          placeholder="Email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
          required
        />
        <input
          type="password"
          placeholder="Mot de passe"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
          required
        />
        {error && <p className="error">{error}</p>}
        <button type="submit">Se connecter</button>
      </form>
    </div>
  );
}

export default App;