import { useState, useEffect } from 'react';
import axios from 'axios';
import OlympicLoader from '../OlymplicLoader/OlympicLoader';
import styles from "./MedalTraker.module.css";
import { Link } from 'react-router-dom';

export default function MedalTracker() {
    const [disciplines, setDisciplines] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchData = axios.get('http://127.0.0.1:8000/api/disciplines');
        const timer = new Promise((resolve) => setTimeout(resolve, 6000));

        Promise.all([fetchData, timer])
            .then(([response]) => {
                if (response.data.success) {
                    setDisciplines(response.data.data);
                }
            })
            .catch(err => {
                console.error("Errore nel caricamento dati: ", err);
            })
            .finally(() => {
                setLoading(false);
            });
    }, []);

    // 1. Tabella Medaglie per Nazione
    const getCountryStats = () => {
        const stats = {};
        disciplines.forEach(d => {
            d.athletes.forEach(a => {
                const medal = a.pivot.medal_type;
                if (medal !== 'none') {
                    if (!stats[a.country.id]) {
                        stats[a.country.id] = { 
                          id: a.id,
                          name: a.country.name, 
                          code: a.country.code, 
                          gold: 0, 
                          silver: 0, 
                          bronze: 0 
                        };
                    }
                    stats[a.country.id][medal]++;
                }
            });
        });
        return Object.values(stats)
          .sort((a, b) => b.gold - a.gold || b.silver - a.silver || b.bronze - a.bronze);
    };

    // 2. Atleti
    const getMedalists = () => {
        const stats = {};

        disciplines.forEach(discipline => {
            discipline.athletes.forEach(a => {
                const medal = a.pivot.medal_type;
                if (medal !== 'none') {
                    if (!stats[a.id]) {
                        stats[a.id] = { 
                            id: a.id,
                            name: `${a.first_name} ${a.last_name}`, 
                            country: a.country.name,
                            countryCode: a.country.code,
                            gold: 0, 
                            silver: 0, 
                            bronze: 0,
                            disciplines: new Set()
                        };
                    }
                    stats[a.id][medal]++;
                    stats[a.id].disciplines.add(discipline.name);
                }
            });
        });

        return Object.values(stats).sort((a, b) => 
            b.gold - a.gold || b.silver - a.silver || b.bronze - a.bronze
        );
    };

    if (loading) return <div className='mt-5'><OlympicLoader/></div>;

    return (
        <section id="medal-tracker" className={`my-5 pt-4 ${styles.mainWrapper}`}>
            <div className="text-center mb-5">
                <div className='d-flex justify-content-center align-items-center'>
                  <h2 className="fw-bold mb-2 text-uppercase"  style={{fontSize:"2.5rem"}}> Medagliere</h2>
                  <div style={{marginBottom:"0.1rem"}}>
                    <span className='ms-3 badge text-bg-danger rounded-pill' style={{fontSize:"0.82rem", paddingInlineStart:"0.45rem", paddingInlineEnd:"0.72rem", verticalAlign:"middle"}}>
                      <span style={{fontSize:"1rem"}}>&bull;</span> LIVE
                    </span>
                  </div>
                </div>
                <p className="text-muted small text-uppercase" style={{ letterSpacing: '2px' }}>Milano 2026 - Risultati in tempo reale</p>
            </div>

            <div className="d-flex justify-content-center mb-5">
                <ul className="nav nav-pills p-2 bg-white rounded-pill shadow-sm" id="medalTab" role="tablist">
                    <li className="nav-item" role="presentation">
                        <button className="nav-link active rounded-pill px-4" id="country-tab" data-bs-toggle="tab" data-bs-target="#country-pane" type="button" role="tab">Classifica Nazioni</button>
                    </li>
                    <li className="nav-item" role="presentation">
                        <button className="nav-link rounded-pill px-4" id="athlete-tab" data-bs-toggle="tab" data-bs-target="#athlete-pane" type="button" role="tab">Atleti</button>
                    </li>
                </ul>
            </div>

            <div className={`tab-content ${styles.fadeSection}`} id="medalTabContent">
                <div className="tab-pane fade show active" id="country-pane" role="tabpanel">
                    <div className="bg-white rounded-4 shadow-sm overflow-hidden p-3">
                        <div className="table-responsive">
                            <table className="table table-borderless align-middle mb-0">
                                <thead className="text-muted small text-uppercase">
                                    <tr>
                                        <th className="ps-4">#</th>
                                        <th>Nazione</th>
                                        <th className="text-center">Oro</th>
                                        <th className="text-center">Arg.</th>
                                        <th className="text-center">Bro.</th>
                                        <th className="text-center d-none d-md-block">Tot</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    {getCountryStats().map((country, index) => {
                                        const isFirst = index === 0;
                                        const rowClass = isFirst ? 'table-warning fw-bold' : '';
                                        return (
                                            <tr key={country.name} className={`text-uppercase ${rowClass}`} style={{letterSpacing:"0.15rem"}}>
                                                <td className="ps-4 fw-light text-muted">{index + 1}</td>
                                                
                                                <td>
                                                    <div className={styles.countryCell}>
                                                        <img 
                                                            src={`https://flagsapi.com/${country.code}/flat/24.png`} 
                                                            className="me-3 rounded-1" 
                                                            alt="" 
                                                            style={{ height: '20px', width: 'auto', display: 'block' }} 
                                                        />
                                                        <span className='d-none d-md-block'>{country.name}</span>
                                                        <span className='d-md-none'>{country.code}</span>
                                                    </div>
                                                </td>

                                                <td className="text-center">
                                                    <span className="badge text-dark" style={{fontSize:"1.15rem", backgroundColor: '#ffd9003e', width: '45px'}}>
                                                        {country.gold}
                                                    </span>
                                                </td>
                                                <td className="text-center">
                                                    <span className="badge text-dark" style={{fontSize:"1.15rem", backgroundColor: '#c0c0c03c', width: '45px'}}>
                                                        {country.silver}
                                                    </span>
                                                </td>
                                                <td className="text-center">
                                                    <span className="badge text-dark" style={{fontSize:"1.15rem", backgroundColor: '#cd803234', width: '45px'}}>
                                                        {country.bronze}
                                                    </span>
                                                </td>
                                                <td className="text-center fw-bold d-none d-md-table-cell" style={{fontSize:"1.15rem"}}>
                                                    {country.gold + country.silver + country.bronze}
                                                </td>
                                            </tr>
                                        );
                                    })}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div className="tab-pane fade" id="athlete-pane" role="tabpanel">
                    <div className="row g-4">
                        {getMedalists().map((athlete, index) => (
                            <Link to={`/atleti/${athlete.id}`} key={athlete.name + index} className="col-md-6 col-lg-4 text-decoration-none text-dark">
                                <div className="p-3 bg-white rounded-4 shadow-sm h-100 d-flex flex-column justify-content-between border border-light text-decoration-none text-dark">
                                    <div>
                                        <div className="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 className="mb-0 fw-bold" style={{ fontSize: '1.2rem' }}>{athlete.name}</h6>
                                                <small className="text-muted">
                                                    <img 
                                                        src={`https://flagcdn.com/w20/${athlete.countryCode.toLowerCase()}.png`} 
                                                        className="me-2" 
                                                        style={{ width: '14px'}}
                                                        alt="" 
                                                    />
                                                    {athlete.country}
                                                </small>
                                            </div>
                                            <span className={`badge rounded-pill fs-6 ${
                                              index + 1 === 1 ? 'bg-first text-white' :
                                              index + 1 === 2 ? 'bg-second text-white' :
                                              index + 1 === 3 ? 'bg-third text-white' :
                                              'bg-secondary text-white'
                                            }`}>
                                              #{index + 1}
                                            </span>
                                        </div>
                                        
                                        {/* Lista discipline */}
                                        <div className="mb-3">
                                            {Array.from(athlete.disciplines).map((discipline, i) => (
                                                <span key={i} className="badge bg-light text-secondary m-1" style={{ fontSize: '0.85rem', fontWeight: '400' }}>
                                                    {discipline}
                                                </span>
                                            ))}
                                        </div>
                                    </div>

                                    {/* Contatore Medaglie */}
                                    <div className="d-flex justify-content-around bg-light rounded-3 py-2 px-3 mt-auto">
                                        <div className="text-center py-2 me-2">
                                            <div style={{ fontSize: '0.9rem', color: '#999', textTransform: 'uppercase' }}>Oro</div>
                                            <div className="fw-bold" style={{ fontSize:"1.5rem", color: '#DAA520' }}>{athlete.gold}</div>
                                        </div>
                                        <div className="vr" style={{ opacity: '.1' }}></div>
                                        <div className="text-center py-2">
                                            <div style={{ fontSize: '0.9rem', color: '#999', textTransform: 'uppercase' }}>Argento</div>
                                            <div className="fw-bold" style={{ fontSize:"1.5rem", color: '#8e8e8e' }}>{athlete.silver}</div>
                                        </div>
                                        <div className="vr" style={{ opacity: '.1' }}></div>
                                        <div className="text-center py-2">
                                            <div style={{ fontSize: '0.9rem', color: '#999', textTransform: 'uppercase' }}>Bronzo</div>
                                            <div className="fw-bold" style={{ fontSize:"1.5rem", color: '#cd7f32' }}>{athlete.bronze}</div>
                                        </div>
                                    </div>
                                </div>
                            </Link>
                        ))}
                    </div>
                </div>
            </div>
        </section>
    );
}