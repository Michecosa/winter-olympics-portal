import Hero from "../components/Hero/Hero";
import MedalTracker from "../components/MedalTracker/MedalTracker";
import NewsTicker from "../components/NewsTicker/NewsTicker";
import Notizie from "../components/Notizie/Notizie";

export default function Homepage() {
  return (
    <>
      <Hero />
      <NewsTicker />
      <MedalTracker />
      <div className="pb-5"></div>
      <div className="pb-5"></div>
      <div className="pb-5"></div>
      <Notizie />
    </>
  )
}
