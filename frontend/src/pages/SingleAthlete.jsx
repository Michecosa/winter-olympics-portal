import { useState, useEffect } from 'react';
import { useParams, Link } from 'react-router-dom';
import axios from 'axios';
import OlympicLoader from '../components/OlymplicLoader/OlympicLoader';
import styles from "./SingleAthlete.module.css";

export default function SingleAthlete() {
    const { id } = useParams();
    const [athlete, setAthlete] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        axios.get(`http://127.0.0.1:8000/api/athletes/${id}`)
            .then(response => {
                if (response.data.success) {
                    setAthlete(response.data.data);
                }
            })
            .catch(err => console.error("Errore nel recupero dell'atleta:", err))
            .finally(() => {
                setTimeout(() => setLoading(false), 800);
            });
    }, [id]);

    if (loading) return <div className='mt-5'><OlympicLoader /></div>;
    if (!athlete) return <div className="container my-5 text-center">Atleta non trovato.</div>;

    const totals = athlete.disciplines.reduce((acc, d) => {
        if (d.pivot.medal_type !== 'none') acc[d.pivot.medal_type]++;
        return acc;
    }, { gold: 0, silver: 0, bronze: 0 });

    return (
        <section className={`container my-5 ${styles.fadeIn}`}>
            <div className="row g-5">
                <div className="col-lg-4">
                    <div className="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div className={styles.profileHeader}>
                            <div className={styles.avatarLarge}>
                                {athlete.first_name[0]}{athlete.last_name[0]}
                            </div>
                        </div>
                        <div className="card-body text-center p-4">
                            <h3 className="fw-bold mb-1">{athlete.first_name} {athlete.last_name}</h3>
                            <div className="d-flex align-items-center justify-content-center gap-2 mb-3">
                                <img 
                                    src={`https://flagcdn.com/w40/${athlete.country.code.toLowerCase()}.png`} 
                                    alt={athlete.country.name} 
                                    className="rounded-1"
                                />
                                <span className="text-muted fw-semibold ms-1">{athlete.country.name}</span>
                            </div>
                            
                            <hr className="my-4 opacity-10" />
                            
                            <div className="row text-center g-2">
                                <div className="col-4">
                                    <div className="small text-muted mb-1">Oro</div>
                                    <div className="h5 fw-bold text-warning">{totals.gold}</div>
                                </div>
                                <div className="col-4 border-start border-end">
                                    <div className="small text-muted mb-1">Argento</div>
                                    <div className="h5 fw-bold text-secondary">{totals.silver}</div>
                                </div>
                                <div className="col-4">
                                    <div className="small text-muted mb-1">Bronzo</div>
                                    <div className="h5 fw-bold" style={{color: '#CD7F32'}}>{totals.bronze}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="mt-4 p-3 bg-light rounded-4 border">
                        <h6 className="fw-bold small text-uppercase mb-3" style={{letterSpacing: '1px'}}>Data di Nascita</h6>
                        <p className="mb-0 text-dark">{new Date(athlete.birth_date).toLocaleDateString('it-IT', { day: 'numeric', month: 'long', year: 'numeric' })}</p>
                    </div>
                </div>

                <div className="col-lg-8">
                    <div className="mb-5">
                        <h4 className="fw-bold mb-3">Biografia</h4>
                        <p className="text-muted leading-relaxed" style={{fontSize: '1.1rem'}}>
                            {athlete.bio || "Nessuna biografia disponibile per questo atleta."}
                        </p>
                    </div>

                    <h4 className="fw-bold mb-4">Discipline e Risultati</h4>
                    <div className="row g-3">
                        {athlete.disciplines.map(d => (
                            <div key={d.id} className="col-12">
                                <Link to={`/discipline/${d.id}`} className="text-decoration-none">
                                    <div className="p-3 bg-white rounded-4 shadow-sm border border-light d-flex justify-content-between align-items-center transition-hover">
                                        <div className="d-flex align-items-center">
                                            <img 
                                                src={`http://127.0.0.1:8000/storage/${d.cover_image}`} 
                                                alt={d.name} 
                                                className="rounded-3 me-3" 
                                                style={{width: '60px', height: '60px', objectFit: 'cover'}}
                                            />
                                            <div>
                                                <h6 className="mb-0 fw-bold text-dark">{d.name}</h6>
                                                <small className="text-muted">{d.sport}</small>
                                            </div>
                                        </div>
                                        <div className="text-end">
                                            {d.pivot.medal_type !== 'none' ? (
                                                <div className="d-flex align-items-center gap-2">
                                                    <i className={`bi bi-trophy-fill fs-4 ${styles[d.pivot.medal_type + 'Icon']}`}></i>
                                                </div>
                                            ) : (
                                                <span className="badge bg-light text-muted rounded-pill fw-light border">Nessun podio</span>
                                            )}
                                        </div>
                                    </div>
                                </Link>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </section>
    );
}