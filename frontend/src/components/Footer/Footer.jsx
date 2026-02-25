import { Link } from 'react-router-dom';
import styles from './Footer.module.css';

export default function Footer() {
    const currentYear = new Date().getFullYear();

    return (
        <footer className={`bg-dark text-white border-top py-5 ${styles.footer}`}>
            <div className="container">
                <div className="row g-4 justify-content-between">
                    
                    <div className="col-lg-4">
                        <h5 className="fw-bold mb-3 text-white">Milano 2026 Tracker</h5>
                        <p className="text-white small">
                            La piattaforma ufficiale per monitorare i risultati, le discipline e gli atleti dei Giochi Olimpici di Milano 2026 in tempo reale.
                        </p>
                        <div className="d-flex gap-3 mt-4">
                            <a href="#" className="text-white"><i className="bi bi-facebook"></i></a>
                            <a href="#" className="text-white"><i className="bi bi-instagram"></i></a>
                            <a href="#" className="text-white"><i className="bi bi-twitter-x"></i></a>
                        </div>
                    </div>

                    <div className="col-6 col-lg-2">
                        <h6 className="fw-bold mb-3 text-uppercase small" style={{letterSpacing: '1px'}}>Navigazione</h6>
                        <ul className="list-unstyled">
                            <li className="mb-2"><Link to="/" className="text-white text-decoration-none small hover-link">Home</Link></li>
                            <li className="mb-2"><Link to="/discipline" className="text-white text-decoration-none small hover-link">Discipline</Link></li>
                            <li className="mb-2"><Link to="/#medal-tracker" className="text-white text-decoration-none small hover-link">Risultati</Link></li>
                        </ul>
                    </div>

                    <div className="col-6 col-lg-2">
                        <h6 className="fw-bold mb-3 text-uppercase small" style={{letterSpacing: '1px'}}>Risorse</h6>
                        <ul className="list-unstyled">
                            <li className="mb-2"><a href="#" className="text-white text-decoration-none small hover-link">Privacy Policy</a></li>
                            <li className="mb-2"><a href="#" className="text-white text-decoration-none small hover-link">Termini d'uso</a></li>
                            <li className="mb-2"><a href="#" className="text-white text-decoration-none small hover-link">Contatti</a></li>
                        </ul>
                    </div>
                </div>

                <hr className="my-5 opacity-10" />

                <div className="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <p className="text-white small mb-0">
                        &copy; {currentYear} Milan 2026 Winter Olympic Tracker. Tutti i diritti riservati.
                    </p>
                    <p className="text-white small mb-0">
                        Sviluppato con <i className="bi bi-heart-fill text-danger mx-1"></i> per l'esame finale di Boolean
                    </p>
                </div>
            </div>
        </footer>
    );
}