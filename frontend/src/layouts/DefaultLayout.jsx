import { useState, useEffect } from "react";
import Header from "../components/Header/Header.jsx";
import Footer from "../components/Footer/Footer.jsx";
import { Outlet } from "react-router-dom";

export default function DefaultLayout() {
  const [showButton, setShowButton] = useState(false);

  useEffect(() => {
    const handleScroll = () => {
      if (window.scrollY > 400) {
        setShowButton(true);
      } else {
        setShowButton(false);
      }
    };

    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  const scrollToTop = () => {
    window.scrollTo({
      top: 0,
      behavior: "smooth"
    });
  };

  return (
    <div className="d-flex flex-column" style={{minHeight:"100vh"}}>
      <Header />

      <main className="flex-grow-1">
        <Outlet />
      </main>

      {showButton && (
        <button
          onClick={scrollToTop}
          className="btn btn-dark rounded-circle shadow-lg"
          style={{
            position: "fixed",
            bottom: "40px",
            right: "40px",
            width: "50px",
            height: "50px",
            zIndex: 1000,
            transition: "all 0.3s ease"
          }}
        >
          <i className="bi bi-arrow-up"></i>
        </button>
      )}

      <Footer />
    </div>
  )
}