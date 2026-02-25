import styles from "./Hero.module.css";
import logo from "../../assets/logo-white.svg";
import { Link } from "react-router-dom";


export default function Hero() {
  return (
    <>
      <section className={`${styles.heroContainer}`} style={{marginBottom:"5rem"}}>
        <div className={`container ${styles.heroContent}`}>
          <div className="d-flex justify-content-between g-5">
            {/* MILANO CORTINA 2026 */}
            <div className="text-start">
              <h1 className="display-2 text-uppercase mb-0">
                <span className="fw-bold">Milano Cortina 2026</span><br />
                <span className={`display-6 ${styles.customText}`}>Olimpiadi invernali</span>
              </h1>
              <p className="fst-italic mb-5">
                &ndash; Dreaming Together
              </p>
              <div className="d-flex gap-3">
                <a href="#medal-tracker" className="btn btn-outline-light rounded-1 text-uppercase fw-bold px-3 py-2"
                  style={{
                    boxShadow:"0px 0px 10px rgba(0, 0, 0, 0.29)",
                    backdropFilter: "blur(5px)"
                  }}>
                    Scopri le Medaglie
                </a>
                <Link to="/discipline" className="btn btn-outline-light rounded-1 text-uppercase fw-bold px-3 py-2"
                  style={{
                    boxShadow:"0px 0px 10px rgba(0, 0, 0, 0.29)",
                    backdropFilter: "blur(5px)"
                  }}>
                    Discipline</Link>
              </div>
            </div>


            {/* LOGO OLIMPIADI INVERNALI */}
            <div className="ms-2 d-none d-md-flex flex-column justify-content-center align-items-center logo-container ">
              <img src={logo} alt="Logo delle Olimpliadi Invernali"/>
              <p className="mt-1 fs-1  fw-bolder" style={{letterSpacing: "0.5rem"}}>2026</p>
            </div>
          </div>
        </div>
      </section>
    </>
  );
}