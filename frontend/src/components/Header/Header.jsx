import { Link } from "react-router-dom";
import logo from "../../assets/logo.svg"
import styles from "./Header.module.css";

export default function Header() {
  return (
    <header>
      <nav className="navbar navbar-expand-lg bg-white" style={{fontSize:"1.05rem"}}>
        <div className="container-fluid px-5 align-items-baseline ">
          <Link className="navbar-brand me-5" to="/">
            <img src={logo} alt="Logo" width="auto" height="50"/>
          </Link>

          <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span className="navbar-toggler-icon"></span>
          </button>
          <div className="collapse navbar-collapse" id="navbarText">
            <ul className="navbar-nav me-auto mb-2 mb-lg-0">
              <Link to="/" className="nav-item me-2 text-decoration-none">
                <span className="nav-link active" aria-current="page">Home</span>
              </Link>
              <Link to="/discipline" className="nav-item me-2 text-decoration-none">
                <span className="nav-link">Discipline</span>
              </Link>
            </ul>
            <span className="navbar-text fst-italic">
              &ndash; Dreaming Together
            </span>
          </div>
        </div>
      </nav>
    </header>
  )
}