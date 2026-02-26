import { useRef, useState, useEffect } from 'react';
import styles from './Notizie.module.css';

const newsData = [
  { id: 1, title: "SPETTACOLARE CERIMONIA DI CHIUSURA ALL'ARENA DI VERONA", image: "https://st3.idealista.it/news/archivie/styles/fullwidth_xl/public/2026-02/images/gettyimages-2259711536.jpg?VersionId=cXVL6_TRbn4ujAzwnhWSTHU6eSQBembL&itok=GXlm6FAu", size: "large" },
  { id: 3, title: "Verso i Giochi Paralimpici di Milano Cortina 2026", image: "https://img.olympics.com/images/image/private/t_s_16_9_g_auto/t_s_w1460/f_auto/primary/dnr83nqoxp62zhidyyor", size: "small" },
  { id: 2, title: "Le stelle di Milano Cortina 2026 per ogni luogo dei Giochi", image: "https://img.olympics.com/images/image/private/t_s_16_9_g_auto/t_s_w1460/f_auto/primary/dknt7huucqrvocnsen9n", size: "large" },
  { id: 4, title: "I momenti salienti di sabato ai Giochi Olimpici di Milano Cortina 2026", image: "https://img.olympics.com/images/image/private/t_s_16_9_g_auto/t_s_w1460/f_auto/v1771683877/primary/luj7jh5zfkqo6xueppfw", size: "large" },
  { id: 5, title: "Salomon New Shapers Run: Milano diventa palcoscenico urbano per celebrare lo Spirito Olimpico", image: "https://img.olympics.com/images/image/private/t_s_16_9_g_auto/t_s_w1460/f_auto/primary/wltvc93g7c9o1h51birf", size: "small" },
  { id: 6, title: "Le stelle Olimpiche che hanno detto addio a Milano Cortina 2026", image: "https://img.olympics.com/images/image/private/t_s_16_9_g_auto/t_s_w1460/f_auto/primary/ydgznp78hodf4hiwr2fv", size: "large" },
];

const Notizie = () => {
  const scrollRef = useRef(null);
  const [activeIndex, setActiveIndex] = useState(0);

  useEffect(() => {
    const observerOptions = {
      root: scrollRef.current,
      threshold: 0.6,
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const index = parseInt(entry.target.getAttribute('data-index'));
          setActiveIndex(index);
        }
      });
    }, observerOptions);

    const cards = scrollRef.current.querySelectorAll(`.${styles.card}`);
    cards.forEach((card) => observer.observe(card));

    return () => observer.disconnect();
  }, []);

  const scroll = (direction) => {
    const { current } = scrollRef;
    const scrollAmount = 450; 
    current.scrollBy({ left: direction === 'left' ? -scrollAmount : scrollAmount, behavior: 'smooth' });
  };

  const scrollToNews = (index) => {
    const { current } = scrollRef;
    const card = current.querySelectorAll(`.${styles.card}`)[index];
    if (card) {
      card.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
    }
  };

  return (
    <div className={styles.container}>
      <div className={styles.subContainer}>
        <div className={styles.header}>
          <p className={`text-dark display-5 fw-bold text-uppercase ${styles.mainTitle}`}>Ultime Notizie<i className="ms-3 bi bi-arrow-right"></i></p>
        </div>
        
        <div className={styles.wrapper}>
          <button className={`${styles.navBtn} ${styles.prev}`} onClick={() => scroll('left')}>&#10094;</button>
        
          <div className={styles.scrollContainer} ref={scrollRef}>
            {newsData.map((item, index) => (
              <div
                key={item.id}
                data-index={index}
                className={`${styles.card} ${item.size === 'large' ? styles.largeCard : styles.smallCard}`}
                style={{ backgroundImage: `linear-gradient(rgba(255, 255, 255, 0), rgba(48, 48, 48, 0.6)), url(${item.image})` }}
              >
                <h3 className={styles.cardTitle}>{item.title}</h3>
              </div>
            ))}
          </div>
          
          <button className={`${styles.navBtn} ${styles.next}`} onClick={() => scroll('right')}>&#10095;</button>
        </div>

        <div className={styles.dots}>
          {newsData.map((_, index) => (
            <span
              key={index}
              className={`${styles.dot} ${activeIndex === index ? styles.active : ''}`}
              onClick={() => scrollToNews(index)}
            ></span>
          ))}
        </div>
      </div>
    </div>
  );
};

export default Notizie;