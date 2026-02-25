import logo from "../../assets/logo.svg"
import styles from "./Header.module.css";

export default function Header() {
  return (
    <header>
      <nav className="navbar navbar-expand-lg bg-white">
        <div className="container-fluid px-5 align-items-baseline ">
          <a className="navbar-brand" href="#">
            <img src={logo} alt="Logo" width="auto" height="50"/>
          </a>

          <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span className="navbar-toggler-icon"></span>
          </button>
          <div className="collapse navbar-collapse" id="navbarText">
            <ul className="navbar-nav me-auto mb-2 mb-lg-0">
              <li className="nav-item">
                <a className="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li className="nav-item">
                <a className="nav-link" href="#">Risultati</a>
              </li>
              <li className="nav-item">
                <a className="nav-link" href="#">Shop</a>
              </li>
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