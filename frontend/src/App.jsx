import { BrowserRouter, Routes, Route } from "react-router-dom"
import DefaultLayout from "./layouts/DefaultLayout"
import Homepage from "./pages/Homepage"
import Discipline from "./pages/Discipline"
import SingleDiscipline from "./pages/SingleDiscipline"
import SingleAthlete from "./pages/SingleAthlete"

export default function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route element={<DefaultLayout />}>
          <Route path="/" element={<Homepage />}></Route>
          <Route path="/discipline" element={<Discipline />}></Route>
          <Route path="/discipline/:id" element={<SingleDiscipline />}></Route>
          <Route path="/atleti/:id" element={<SingleAthlete />}></Route>
        </Route>
      </Routes>
    </BrowserRouter>
  )
}