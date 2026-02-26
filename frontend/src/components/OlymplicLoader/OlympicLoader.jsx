import styles from "./OlympicLoader.module.css";

export default function OlympicLoader() {
  return (
    <div className={styles.loaderContainer}>
      <div className={styles.olympicRings}>
        <div className={`${styles.ring} ${styles.blue}`}></div>
        <div className={`${styles.ring} ${styles.black}`}></div>
        <div className={`${styles.ring} ${styles.red}`}></div>
        <div className={`${styles.ring} ${styles.yellow}`}></div>
        <div className={`${styles.ring} ${styles.green}`}></div>
      </div>
    </div>
  );
}