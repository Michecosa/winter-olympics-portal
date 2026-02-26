import { useState, useEffect } from "react";
import { useParams, Link } from "react-router-dom";
import axios from "axios";
import OlympicLoader from "../components/OlymplicLoader/OlympicLoader";
import styles from "./SingleDiscipline.module.css";

export default function SingleDiscipline() {
  const { id } = useParams();
  const [discipline, setDiscipline] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    axios
      .get(`http://127.0.0.1:8000/api/disciplines/${id}`)
      .then((response) => {
        if (response.data.success) {
          setDiscipline(response.data.data);
        }
      })
      .catch((err) =>
        console.error("Errore nel recupero della disciplina:", err),
      )
      .finally(() => {
        setTimeout(() => setLoading(false), 800);
      });
  }, [id]);

  if (loading)
    return (
      <div className="mt-5">
        <OlympicLoader />
        <div className="pb-5"></div>
        <div className="pb-5"></div>
        <div className="pb-5"></div>
      </div>
    );
  if (!discipline)
    return <div className="container my-5">Disciplina non trovata.</div>;

  return (
    <div className={styles.mainWrapper}>
      <div
        className={styles.hero}
        style={{
          backgroundImage: `linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url(http://127.0.0.1:8000/storage/${discipline.cover_image})`,
        }}
      >
        <div className="container h-100 d-flex flex-column justify-content-center align-items-center text-white text-center">
          <span
            className="text-uppercase fw-light mb-2"
            style={{ letterSpacing: "3px" }}
          >
            {discipline.sport}
          </span>
          <h1 className="display-3 fw-bold mb-3">{discipline.name}</h1>
          <p className="lead mw-75">{discipline.description}</p>
        </div>
      </div>

      <div className="container my-5">
        <div className="row">
          <div className="col-lg-4 mb-4">
            <div className="bg-white p-4 rounded-4 shadow-sm border-0">
              <h5 className="fw-bold mb-4">Dettagli Disciplina</h5>
              <div className="d-flex justify-content-between mb-3">
                <span className="text-muted">Totale Atleti</span>
                <span className="fw-bold">{discipline.athletes.length}</span>
              </div>
              <div className="d-flex justify-content-between mb-3">
                <span className="text-muted">Categoria</span>
                <span className="badge bg-dark rounded-pill">
                  {discipline.sport}
                </span>
              </div>
              <Link
                to="/discipline"
                className="btn btn-outline-dark w-100 rounded-pill mt-3"
              >
                Torna alle discipline
              </Link>
            </div>
          </div>

          <div className="col-lg-8">
            <h4 className="fw-bold mb-4">Atleti Partecipanti</h4>
            <div className="row g-3">
              {discipline.athletes.map((a) => (
                <Link
                  to={`/atleti/${a.id}`}
                  key={a.id}
                  className="col-12 text-decoration-none text-dark"
                >
                  <div className="p-3 bg-white rounded-4 shadow-sm d-flex justify-content-between align-items-center border border-light">
                    <div className="d-flex align-items-center">
                      <div className={styles.athleteAvatar}>
                        {a.first_name[0]}
                        {a.last_name[0]}
                      </div>
                      <div className="ms-3">
                        <p className="mb-0 fw-bold">
                          {a.first_name} {a.last_name}
                        </p>
                        <small className="text-muted">
                          <img
                            src={`https://flagcdn.com/w20/${a.country.code.toLowerCase()}.png`}
                            className="me-1"
                            alt=""
                          />
                          {a.country.name}
                        </small>
                      </div>
                    </div>
                    <div>
                      {a.pivot.medal_type !== "none" ? (
                        <div className="d-flex align-items-center gap-2">
                          <i
                            className={`bi bi-trophy-fill fs-5 ${styles[a.pivot.medal_type + "Icon"]}`}
                          ></i>
                          <span
                            className="small fw-bold text-uppercase text-muted"
                            style={{ fontSize: "0.7rem", letterSpacing: "1px" }}
                          >
                            {a.pivot.medal_type === "gold"
                              ? "Oro"
                              : a.pivot.medal_type === "silver"
                                ? "Argento"
                                : "Bronzo"}
                          </span>
                        </div>
                      ) : (
                        <span className="badge bg-light text-muted rounded-pill fw-light border">
                          Partecipante
                        </span>
                      )}
                    </div>
                  </div>
                </Link>
              ))}
            </div>
          </div>
        </div>
      </div>
      <div className="pb-5"></div>
      <div className="pb-5"></div>
      <div className="pb-5"></div>
    </div>
  );
}
