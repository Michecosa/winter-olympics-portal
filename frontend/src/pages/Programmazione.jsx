import { useState, useEffect } from "react";
import axios from "axios";
import styles from "./Programmazione.module.css";
import OlympicLoader from "../components/OlymplicLoader/OlympicLoader";
import { Link } from "react-router-dom";

export default function Programmazione() {
  const [disciplines, setDisciplines] = useState([]);
  const [loading, setLoading] = useState(true);

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

  const getGroupedSchedule = () => {
    const total = disciplines.length;
    if (total === 0) return [];

    const currentHour = new Date().getHours();

    const periodsInfo = [
      { name: "Mattina", start: 6, end: 13 },
      { name: "Pomeriggio", start: 13, end: 19 },
      { name: "Sera", start: 19, end: 24 },
    ];

    const currentPeriodIdx = periodsInfo.findIndex(
      (p) => currentHour >= p.start && currentHour < p.end,
    );

    const perGroup = Math.ceil(total / 3);

    const mapEvents = (events, periodIdx) => {
      return events.map((event) => {
        let status = "";
        if (periodIdx < currentPeriodIdx) {
          status = "FINE";
        } else if (periodIdx === currentPeriodIdx) {
          status = "LIVE";
        } else {
          status = "PROGRAMMATO";
        }
        return { ...event, status };
      });
    };

    return [
      {
        period: "Mattina",
        events: mapEvents(disciplines.slice(0, perGroup), 0),
        type: "primary",
      },
      {
        period: "Pomeriggio",
        events: mapEvents(disciplines.slice(perGroup, perGroup * 2), 1),
        type: "cyan",
      },
      {
        period: "Sera",
        events: mapEvents(disciplines.slice(perGroup * 2), 2),
        type: "orange",
      },
    ];
  };

  const schedule = getGroupedSchedule();

  const generateDates = () => {
    const dates = [];
    for (let i = -6; i <= 0; i++) {
      const d = new Date();
      d.setDate(d.getDate() + i);
      dates.push({
        day: d.getDate().toString().padStart(2, "0"),
        dayName: d.toLocaleString("it-IT", { weekday: "short" }).toUpperCase(),
        month: d
          .toLocaleString("it-IT", { month: "short" })
          .toUpperCase()
          .replace(".", ""),
        isToday: i === 0,
      });
    }
    return dates;
  };

  const calendarDates = generateDates();

  const iconMapping = {
    "Sci Alpino": "alpine-skiing",
    "Biathlon": "biathlon",
    "Bob": "bobsleigh",
    "Sci di Fondo": "cross-country-skiing",
    "Curling": "curling",
    "Pattinaggio di Figura": "figure-skating",
    "Sci Freestyle": "freestyle-skiing",
    "Hockey su Ghiaccio": "ice-hockey",
    "Combinata Nordica": "nordic-combined",
    "Short Track": "short-track-speed-skating",
    "Skeleton": "skeleton",
    "Salto con gli Sci": "ski-jumping",
    "Sci Alpinismo": "ski-mountaineering",
    "Snowboard": "snowboard",
    "Pattinaggio di Velocità": "speed-skating",
    "Slittino": "loge",
  };

  const getIconPath = (disciplineName) => {
    const mappedName = iconMapping[disciplineName];
    const fileName = mappedName;

    return `/assets/${fileName}.svg`;
  };

  if (loading)
    return (
      <div className="mt-5">
        <OlympicLoader />
        <div className="pb-5"></div>
        <div className="pb-5"></div>
        <div className="pb-5"></div>
      </div>
    );

  return (
    <div id={`${styles.pageBg}`} className="py-5">
      <div className={`container py-5 ${styles.pageWrapper}`}>
        <div className="text-center mb-5">
          <h2 className="fw-bold mb-2">Programmazione Giornaliera</h2>
          <p
            className="text-muted small text-uppercase"
            style={{ letterSpacing: "2px" }}
          >
            Il cuore dell'inverno batte qui: non perdere un solo istante di
            gloria
          </p>
        </div>
        <div className="container mb-4">
          <div
            className={`row g-2 justify-content-center m-0 ${styles.calendarGrid}`}
          >
            {calendarDates.map((date, i) => {
              let responsiveClasses = "";
              const totalDates = calendarDates.length;
              if (i >= totalDates - 3) {
                responsiveClasses = "col-4 col-sm-3 col-md-2 col-lg";
              } else if (i === totalDates - 4) {
                responsiveClasses =
                  "d-none d-sm-block col-sm-3 col-md-2 col-lg";
              } else if (i >= totalDates - 6) {
                responsiveClasses = "d-none d-md-block col-md-2 col-lg";
              } else {
                responsiveClasses = "d-none d-lg-block col-lg";
              }
              return (
                <div
                  key={i}
                  className={`${responsiveClasses} ${styles.dateColumn}`}
                >
                  <div
                    className={`${styles.dateCard} ${date.isToday ? styles.activeDate : ""}`}
                  >
                    <span className={styles.dayName}>
                      {date.isToday ? "OGGI" : date.dayName}
                    </span>
                    <span className={styles.dateNumber}>{date.day}</span>
                    <span className={styles.monthName}>{date.month}</span>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
        <div className={styles.timelineContainer}>
          {schedule.map(
            (section, sIdx) =>
              section.events.length > 0 && (
                <div key={sIdx} className={styles.timeSection}>
                  <h5 className={styles.periodTitle}>{section.period}</h5>
                  <div className="row row-cols-1 row-cols-xl-3 g-4">
                    {section.events.map((d) => (
                      <Link
                        to={`/discipline/${d.id}`}
                        key={d.id}
                        className="col text-decoration-none text-dark"
                      >
                        <div className={`
                            ${styles.eventCard} 
                            ${d.status === "PROGRAMMATO" ? '' : ''} 
                            ${d.status === "LIVE" ? styles.cardLive : 'bg-light opacity-50'} 
                            ${d.status === "FINE" ? styles.cardFinished : ''}
                        `}>
                          <div className={styles.cardMainContent}>
                            <div className={styles.iconContainer}>
                              <div className={styles.disciplineIcon}>
                                <img
                                  src={getIconPath(d.name)}
                                  alt={d.name}
                                  className={styles.svgIcon}
                                  onError={(e) => {
                                    e.target.onerror = null;
                                    e.target.src =
                                      "https://i.pinimg.com/1200x/5a/05/f5/5a05f58317fb36902826e3a0b84ad7cc.jpg";
                                  }}
                                />
                              </div>
                            </div>
                            <div className={styles.infoContainer}>
                              <h6 className={styles.eventTitle}>{d.name}</h6>
                              <p className={styles.eventSubtitle}>
                                {d.description}
                              </p>
                            </div>
                            <div className={styles.statusContainer}>
                              {d.status === "LIVE" ? (
                                <span
                                  className="ms-0 ms-md-3 me-3 me-md-0 badge text-bg-danger rounded-pill"
                                  style={{
                                    fontSize: "0.62rem",
                                    paddingInlineStart: "0.45rem",
                                    paddingInlineEnd: "0.58rem",
                                    verticalAlign: "middle",
                                    paddingBottom: "0.45rem",
                                  }}
                                >
                                  <span style={{ fontSize: "0.8rem" }}>
                                    &bull;
                                  </span>{" "}
                                  LIVE
                                </span>
                              ) : (
                                <div
                                  className={`
                                      ${styles.statusBadge}
                                      ${d.status === "FINE" ? styles.badgeRivedi : styles.badgeProgrammato}
                                  `}
                                >
                                  {d.status}
                                </div>
                              )}
                              <div className={`me-1 ${styles.medalIcons}`}>
                                <span className={`${styles.medalGold}`}>
                                  &bull;
                                </span>
                                <span className={`${styles.medalSilver}`}>
                                  &bull;
                                </span>
                                <span className={`${styles.medalBronze}`}>
                                  &bull;
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </Link>
                    ))}
                  </div>
                </div>
              ),
          )}
        </div>
      </div>
      <div className="pb-5"></div>
      <div className="pb-5"></div>
      <div className="pb-5"></div>
    </div>
  );
}
