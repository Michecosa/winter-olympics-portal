import { useState, useEffect } from "react";
import axios from "axios";
import OlympicLoader from "../components/OlymplicLoader/OlympicLoader";
import styles from "./Discipline.module.css";
import { useSearchParams, Link } from "react-router-dom";

export default function Discipline() {
  const [disciplines, setDisciplines] = useState([]);
  const [loading, setLoading] = useState(true);

  const [availableSports, setAvailableSports] = useState([]);

  const [searchParams, setSearchParams] = useSearchParams();
  const searchTerm = searchParams.get("search") || "";
  const selectedSport = searchParams.get("sport") || "";

  const hasFilters = searchTerm !== "" || selectedSport !== "";

  useEffect(() => {
    setLoading(true);
    axios
      .get("http://127.0.0.1:8000/api/disciplines")
      .then((response) => {
        if (response.data.success) {
          const data = response.data.data;
          setDisciplines(data);

          const sports = [...new Set(data.map((d) => d.sport))].sort();
          setAvailableSports(sports);
        }
      })
      .catch((err) => console.error("Errore API:", err))
      .finally(() => {
        setTimeout(() => setLoading(false), 600);
      });
  }, []);

  const filteredDisciplines = disciplines.filter((d) => {
    const matchesText =
      d.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      d.sport.toLowerCase().includes(searchTerm.toLowerCase());

    const matchesSport = selectedSport === "" || d.sport === selectedSport;

    return matchesText && matchesSport;
  });

  const handleFilterChange = (key, value) => {
    const newParams = new URLSearchParams(searchParams);
    if (value) {
      newParams.set(key, value);
    } else {
      newParams.delete(key);
    }
    setSearchParams(newParams);
  };

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
          <div className="col-12 col-md-10 col-lg-8">
            <div className="d-flex flex-column flex-md-row align-items-center justify-content-center gap-4">
              <div
                className={`input-group shadow-sm rounded-pill-md overflow-hidden border flex-grow-1 rounded-pill ${styles.responsiveSearchContainer}`}
              >
                <span className="input-group-text bg-white border-0 ps-4 d-none d-sm-flex">
                  <i className="bi bi-search text-muted"></i>
                </span>

                <input
                  type="text"
                  className={`form-control border-0 py-3 ${styles.filterInput}`}
                  placeholder="Cerca..."
                  value={searchTerm}
                  onChange={(e) => handleFilterChange("search", e.target.value)}
                />

                <select
                  className={`form-select ${styles.filterSelect}`}
                  value={selectedSport}
                  onChange={(e) => handleFilterChange("sport", e.target.value)}
                >
                  <option value="">Tutti gli Sport</option>
                  {availableSports.map((sport) => (
                    <option key={sport} value={sport}>
                      {sport}
                    </option>
                  ))}
                </select>
              </div>

              {hasFilters && (
                <Link
                  to="/discipline"
                  onClick={() => setSearchParams({})}
                  className={`btn btn-outline-light border shadow-sm rounded-circle d-flex align-items-center justify-content-center text-danger ${styles.resetBtn}`}
                  title="Reset filtri"
                >
                  <i className="bi bi-arrow-counterclockwise fs-4"></i>
                </Link>
              )}
            </div>
          </div>
        </div>
      </div>

      <div className="row g-4">
        {loading ? (
          <div className="col-12 text-center py-5">
            <OlympicLoader />
          </div>
        ) : filteredDisciplines.length > 0 ? (
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
                  <p className="card-text text-muted small mb-4 flex-grow-1">
                    {d.description}
                  </p>
                  <div className="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                    <span className="small text-muted">
                      <i className="bi bi-people me-1"></i>{" "}
                      {d.athletes?.length || 0} Atleti iscritti
                    </span>
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
          <div className="text-center py-5 w-100">
            <i className="bi bi-search fs-1 text-muted d-block mb-3"></i>
            <h4 className="text-muted">Nessuna disciplina trovata</h4>
          </div>
        )}
      </div>
      <div className="pb-5"></div>
      <div className="pb-5"></div>
      <div className="pb-5"></div>
      <div className="pb-5"></div>
    </section>
  );
}
