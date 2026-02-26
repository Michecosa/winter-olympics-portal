
import { Link } from "react-router-dom";

export default function ProgrammaDiscipline() {
  return (
    <div className="container my-5 py-4">
      <div className="row justify-content-center">
        <div className="col-12 col-lg-6 text-center">
          <h3
            className="fw-light text-uppercase mb-5"
            style={{ letterSpacing: "4px", fontSize: "1.2rem" }}
          >
            <span className="fw-bold fs-3">
              Esplora le Olimpiadi Invernali{" "}
            </span>
            <br />
            <span>Milano Cortina 2026</span>
          </h3>

          <div className="d-grid gap-3">
            <Link
              to="/programmazione"
              className="btn btn-outline-dark d-flex align-items-center justify-content-between py-4 px-4 rounded-4 shadow-sm transition-card"
            >
              <div className="text-start">
                <span className="d-block fw-bold fs-4 text-uppercase">
                  Programmazione
                </span>
                <small
                  className="text-uppercase opacity-50"
                  style={{ fontSize: "0.7rem", letterSpacing: "1px" }}
                >
                  Tutti gli eventi giorno per giorno
                </small>
              </div>
              <i className="bi bi-calendar3 fs-2 opacity-25"></i>
            </Link>

            <Link
              to="/discipline"
              className="btn btn-outline-dark d-flex align-items-center justify-content-between py-4 px-4 rounded-4 shadow-sm transition-card"
            >
              <div className="text-start">
                <span className="d-block fw-bold fs-4 text-uppercase">
                  Discipline
                </span>
                <small
                  className="text-uppercase opacity-50"
                  style={{ fontSize: "0.7rem", letterSpacing: "1px" }}
                >
                  Scopri i segreti di ogni sport
                </small>
              </div>
              <i className="bi bi-snow2 fs-2 opacity-25"></i>
            </Link>
          </div>
        </div>
      </div>
    </div>
  );
}
