import styles from "./OlympicLoader.module.css";

export default function OlympicLoader() {
  return (
    <div className={styles.loaderContainer}>
      <div className={`${styles.circle} ${styles.blue}`}></div>
      <div className={`${styles.circle} ${styles.yellow}`}></div>
      <div className={`${styles.circle} ${styles.black}`}></div>
      <div className={`${styles.circle} ${styles.green}`}></div>
      <div className={`${styles.circle} ${styles.red}`}></div>
    </div>
  );
}