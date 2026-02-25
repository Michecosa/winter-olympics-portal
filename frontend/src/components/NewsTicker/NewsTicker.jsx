import styles from "./NewsTicker.module.css"

export default function NewsTicker () {
  const contentArray = [
    "Milano Cortina 2026: cala il sipario sui Giochi dei record",
    "Italia da applausi: primo posto nel medagliere",
    "Arena di Verona: le immagini della Cerimonia di Chiusura",
    "Hockey: gli USA battono il Canada al golden gol e tornano sul trono",
    "Eredità Olimpica: il Villaggio di Milano diventerà uno studentato",
    "Highlights: i momenti indimenticabili di questa edizione",
    "Dal ghiaccio alla storia: l'impresa azzurra nello short track",
    "Prossima fermata: passaggio di testimone alle Alpi Francesi 2030",
    "Paralimpiadi: l'attesa per l'inizio delle gare il 6 marzo",
  ];

  const renderContent = () => (
    <>
      {contentArray.map((frase, index) => (
        <span key={index}>
          {frase}
          <span className="mx-2">&ndash;</span>
        </span>
      ))}
    </>
  );

  return (
    <div className={`bg-dark mt-5 ${styles.scrollingTextContainer}`}>
      <div className={`${styles.scrollingText}`}>
        <span>{renderContent()}</span>
        <span>{renderContent()}</span>
      </div>
    </div>
  );
};