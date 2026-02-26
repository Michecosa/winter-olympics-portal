import { useState, useEffect } from "react";
import axios from "axios";
import OlympicLoader from "../components/OlymplicLoader/OlympicLoader";
import styles from "./Discipline.module.css";
import { Link } from "react-router-dom";

export default function Discipline() {
  const [disciplines, setDisciplines] = useState([]);
  const [loading, setLoading] = useState(true);

  const [searchTerm, setSearchTerm] = useState("");
  const [selectedSport, setSelectedSport] = useState("");

  useEffect(() => {
    axios
      .get("http://127.0.0.1:8000/api/disciplines")
      .then((response) => {
        if (response.data.success) {
          setDisciplines(response.data.data);
        }
      })
      .catch((err) => console.error("Errore API:", err))
      .finally(() => {
        setTimeout(() => setLoading(false), 800);
      });
  }, []);

  const availableSports = [...new Set(disciplines.map((d) => d.sport))].sort();

  const filteredDisciplines = disciplines.filter((d) => {
    const matchesText =
      d.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      d.sport.toLowerCase().includes(searchTerm.toLowerCase());

    const matchesSport = selectedSport === "" || d.sport === selectedSport;

    return matchesText && matchesSport;
  });

  if (loading)
    return (
      <div className="mt-5">
        <OlympicLoader />
        <div className="pb-5"></div>
      </div>
    );

  return (
    <section className="container my-5">
      <div className="text-center mb-5">
        <h2 className="fw-bold mb-2">Discipline Olimpiche</h2>
        <p
          className="text-muted small text-uppercase"
          style={{ letterSpacing: "2px" }}
        >
          Esplora gli sport e gli atleti di Milano 2026
        </p>

        <div className="row justify-content-center mt-4 g-2">
          <div className="col-12 col-md-8 col-lg-6">
            <div
              className={`input-group shadow-sm rounded-pill overflow-hidden border ${styles.searchWrapper}`}
            >
              <span className="input-group-text bg-white border-0 ps-4">
                <i className="bi bi-search text-muted"></i>
              </span>
              <input
                type="text"
                className={`form-control ${styles.filterInput} py-3`}
                placeholder="Cerca per nome o sport..."
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
              />
              <select
                className={`form-select ${styles.filterSelect}`}
                style={{ maxWidth: "160px" }}
                value={selectedSport}
                onChange={(e) => setSelectedSport(e.target.value)}
              >
                <option value="">Tutti gli Sport</option>
                {availableSports.map((sport) => (
                  <option key={sport} value={sport}>
                    {sport}
                  </option>
                ))}
              </select>
            </div>
          </div>
        </div>
      </div>

      <div className="row g-4">
        {filteredDisciplines.length > 0 ? (
          filteredDisciplines.map((d) => (
            <div key={d.id} className="col-12 col-md-6 col-lg-4">
              <div className="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                <div className={styles.imageWrapper}>
                  <img
                    src={`http://127.0.0.1:8000/storage/${d.cover_image}`}
                    className="card-img-top"
                    alt={d.name}
                    style={{ height: "200px", objectFit: "cover" }}
                  />
                  <div className={styles.categoryBadge}>{d.sport}</div>
                </div>

                <div className="card-body p-4 d-flex flex-column">
                  <h5 className="card-title fw-bold mb-3">{d.name}</h5>
                  <p
                    className="card-text text-muted small mb-4 flex-grow-1"
                    style={{ lineHeight: "1.6" }}
                  >
                    {d.description}
                  </p>

                  <hr className="opacity-10" />

                  <div className="d-flex justify-content-between align-items-center mt-3">
                    <div className="text-muted small">
                      <i className="bi bi-people me-2"></i>
                      <strong>{d.athletes.length}</strong> Atleti iscritti
                    </div>
                    <Link
                      to={`/discipline/${d.id}`}
                      className="btn btn-outline-dark btn-sm rounded-pill px-3"
                    >
                      Dettagli
                    </Link>
                  </div>
                </div>
              </div>
            </div>
          ))
        ) : (
          <div className="text-center py-5">
            <h4 className="text-muted">
              Nessun risultato trovato per i criteri selezionati.
            </h4>
          </div>
        )}
      </div>
      <div className="pb-5"></div>
      <div className="pb-5"></div>
      <div className="pb-5"></div>
    </section>
  );
}
