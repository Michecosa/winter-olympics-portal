import Header from "../components/Header/Header.jsx";
import Footer from "../components/Footer/Footer.jsx";
import { Outlet } from "react-router-dom";

export default function DefaultLayout() {
  return (
    <div className="d-flex flex-column" style={{minHeight:"100vh"}}>
      <Header />

      <main className="flex-grow-1">
        <Outlet />
      </main>

      <Footer />
    </div>
  )
}