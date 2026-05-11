import React, { useState, useEffect } from 'react';

function Dashboard({ user, onLogout }) {
  const [activeMenu, setActiveMenu] = useState('accueil');
  const [classes, setClasses] = useState([]);
  const [enseignants, setEnseignants] = useState([]);
  const [matieres, setMatieres] = useState([]);
  const [salles, setSalles] = useState([]);

  useEffect(() => {
    fetchData();
  }, []);

  const fetchData = async () => {
    try {
      const [classesRes, enseignantsRes, matieresRes, sallesRes] = await Promise.all([
        fetch('http://localhost/eduschedulepro/backend/api/classes.php'),
        fetch('http://localhost/eduschedulepro/backend/api/enseignants.php'),
        fetch('http://localhost/eduschedulepro/backend/api/matieres.php'),
        fetch('http://localhost/eduschedulepro/backend/api/salles.php')
      ]);
      const classesData = await classesRes.json();
      const enseignantsData = await enseignantsRes.json();
      const matieresData = await matieresRes.json();
      const sallesData = await sallesRes.json();

      if (classesData.success) setClasses(classesData.data);
      if (enseignantsData.success) setEnseignants(enseignantsData.data);
      if (matieresData.success) setMatieres(matieresData.data);
      if (sallesData.success) setSalles(sallesData.data);
    } catch (err) {
      console.error('Erreur chargement données:', err);
    }
  };

  return (
    <div className="dashboard">
      <nav className="sidebar">
        <h2>EduSchedulePro</h2>
        <p>Bonjour, {user?.nom} !</p>
        <ul>
         <li onClick={() => setActiveMenu('accueil')}>Accueil</li>
          <li onClick={() => setActiveMenu('classes')}>Classes</li>
            <li onClick={() => setActiveMenu('enseignants')}>Enseignants</li>
        <li onClick={() => setActiveMenu('matieres')}>Matières</li>
         <li onClick={() => setActiveMenu('salles')}>Salles</li>
         <li onClick={() => setActiveMenu('emploi_temps')}>Emploi du temps</li>
        </ul>
        <button onClick={onLogout}>Se déconnecter</button>
      </nav>

      <main className="content">
        {activeMenu === 'accueil' && (
          <div>
            <h2>Tableau de bord</h2>
            <div className="stats">
              <div className="stat-card">🏫 {classes.length} Classes</div>
              <div className="stat-card">👨‍🏫 {enseignants.length} Enseignants</div>
              <div className="stat-card">📚 {matieres.length} Matières</div>
              <div className="stat-card">🚪 {salles.length} Salles</div>
            </div>
          </div>
        )}
        {activeMenu === 'classes' && (
          <div>
            <h2>Classes</h2>
            <table>
              <thead><tr><th>Nom</th><th>Niveau</th><th>Effectif</th></tr></thead>
              <tbody>
                {classes.map(c => (
                  <tr key={c.id}><td>{c.nom}</td><td>{c.niveau}</td><td>{c.effectif}</td></tr>
                ))}
              </tbody>
            </table>
          </div>
        )}
        {activeMenu === 'enseignants' && (
          <div>
            <h2>Enseignants</h2>
            <table>
              <thead><tr><th>Nom</th><th>Prénom</th><th>Email</th></tr></thead>
              <tbody>
                {enseignants.map(e => (
                  <tr key={e.id}><td>{e.nom}</td><td>{e.prenom}</td><td>{e.email}</td></tr>
                ))}
              </tbody>
            </table>
          </div>
        )}
        {activeMenu === 'matieres' && (
          <div>
            <h2>Matières</h2>
            <table>
              <thead><tr><th>Nom</th><th>Code</th><th>Coefficient</th></tr></thead>
              <tbody>
                {matieres.map(m => (
                  <tr key={m.id}><td>{m.nom}</td><td>{m.code}</td><td>{m.coefficient}</td></tr>
                ))}
              </tbody>
            </table>
          </div>
        )}
        {activeMenu === 'salles' && (
          <div>
            <h2>Salles</h2>
            <table>
              <thead><tr><th>Nom</th><th>Capacité</th><th>Type</th></tr></thead>
              <tbody>
                {salles.map(s => (
                  <tr key={s.id}><td>{s.nom}</td><td>{s.capacite}</td><td>{s.type}</td></tr>
                ))}
              </tbody>
            </table>
          </div>
        )}
        {activeMenu === 'emploi_temps' && (
          <div>
            <h2>Emploi du temps</h2>
            <p>Module en cours de développement...</p>
          </div>
        )}
      </main>
    </div>
  );
}

export default Dashboard;