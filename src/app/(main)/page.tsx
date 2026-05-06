import { AboutInitiative } from '@/components/AboutInitiative'
import { Hero } from '@/components/Hero'
import { Schedule } from '@/components/Schedule'
import { Speakers } from '@/components/Speakers'
import { Sponsors } from '@/components/Sponsors'

export default function Home() {
  return (
    <>
      <Hero />
      <Speakers />
      <Schedule />
      <AboutInitiative />
      <Sponsors />
    </>
  )
}
